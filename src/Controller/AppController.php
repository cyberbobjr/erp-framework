<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\AppConstants;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\I18n\I18n;
use Cake\I18n\Time;
use Cake\View\View;
use Firebase\JWT\JWT;
use Cake\Utility\Security;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 * @property \UserManager\Model\Table\UsersTable $Users
 * @property \Cake\ORM\Table $Operations
 * @property \Cake\ORM\Table $Documents
 */
class AppController extends Controller
{
    //use ControllerTrait;
    // variable utilisée pour prendre en compte le champ de recherche dans la barre de recherche
    public $tosearch;
    // variable utilisée pour déterminer le nombre de pages pour le paginator
    public $limit;
    // variable utilisée pour déterminer l'offset du paginator
    public $rows;
    protected $options = [];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        I18n::locale('fr_FR');
        Time::setToStringFormat('dd/MM/Y HH:mm');
        Date::setToStringFormat('dd/MM/YYYY');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Paginator');
        $this->loadComponent('Auth', ['flash'                => ['element' => 'default'],
                                      'authenticate'         => ['Form' => ['userModel' => 'UserManager.Users',
                                                                            'finder'    => 'auth',
                                                                            'fields'    => ['username' => 'username',
                                                                                            'password' => 'password']],
                                      ],
                                      'authError'            => __('Vous ne possédez pas l\'autorisation d\'accéder à cette page'),
                                      'authorize'            => ['Controller'],
                                      'checkAuthIn'          => 'Controller.initialize',
                                      'unauthorizedRedirect' => FALSE,
                                      'loginRedirect'        => ['plugin'     => NULL,
                                                                 'controller' => 'Dashboards',
                                                                 'action'     => 'index'],
                                      'loginAction'          => ['plugin'     => 'UserManager',
                                                                 'controller' => 'users',
                                                                 'action'     => 'login'],
                                      'logoutRedirect'       => ['plugin'     => 'UserManager',
                                                                 'controller' => 'users',
                                                                 'action'     => 'login'],
                                      'storage'              => (Configure::read('debug') ? "Session" : "Session"),
                                      'sessionKey'           => 'User']);
        $this->Auth->allow(['token']);
    }

    public function isAuthorized($user)
    {
        return TRUE;
    }

    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json',
                                                                                                   'application/xml'])
        ) {
            $this->set('_serialize', TRUE);
        }
        return parent::beforeRender($event); // TODO: Change the autogenerated stub
    }

    /**
     * Fonction executée avant l'affichage
     * Elle permet de selectionner la barre de navigation à afficher pour le layout
     * @param \Cake\Event\Event $event
     */
    public function beforeFilter(Event $event)
    {
        // si un paramètre de recherche est spécifié dans la requête
        if ($this->request->data('page')) {
            $this->options = array_merge($this->options, ['page' => $this->request->data['page']]);
        }
        if ($this->request->data('rows')) {
            $this->options = array_merge($this->options, ['limit' => $this->request->data['rows']]);
        }
    }

    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        $this->set([
            'success'    => TRUE,
            'data'       => [
                'token' => JWT::encode([
                    'id'               => $user['id'],
                    'sub'              => $user['id'],
                    'exp'              => time() + 604800], Security::salt())],
            '_serialize' => [
                'success',
                'data']]);
    }

    /**
     * Fonction de "ping" pour s'assurer que l'utilisateur est bien connecté
     * Renvoi l'utilisateur connecté dans un objet JSON
     */
    public function ping()
    {
        $user = $this->_loadUserById($this->Auth->user('id'));
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    private function _loadUserById($users_id)
    {
        $this->loadModel('UserManager.Users');
        return $this->Users->find('auth')
                           ->where(['Users.id' => $users_id])
                           ->first();
    }

    /**
     * Génère les fichiers PDF de l'opération spécifiée en paramètre
     * @param $operation_id
     * @return bool
     * @throws ForbiddenException
     */
    public function generer_doc_pdf($operation_id)
    {
        $success = FALSE;
        $this->loadModel('Operations');
        $operation = $this->Operations->get($operation_id, ['contain' => ['TypeEtats']]);
        if (!$operation->is_draft) {
            switch ($operation->type_op_id) {
                // en fonction du type d'opération, génération du document associé
                case AppConstants::OP_APPEL_LOYER : // si c'est un appel
                    if ($this->generer_appel_pdf($operation_id, TRUE)) {
                        $success = TRUE;
                    }
                    break;
                case AppConstants::OP_FACTURE : // si c'est une facture
                    if ($this->generer_facture_pdf($operation_id, TRUE)) {
                        $success = TRUE;
                    }
                    break;
            }
        }
        // si l'opération est cloturée et que l'opération est un appel de loyer
        if ($operation->is_closed && $operation->type_op_id == AppConstants::OP_APPEL_LOYER) {
            // on génère la quittance associée
            if ($this->generer_quittance_pdf($operation_id, TRUE)) {
                $success = TRUE;
            }
        }
        return $success;
    }

    /**
     * Génère un appel de loyer au format PDF
     * @param int $operation_id Référence de l'opération
     * @param bool|FALSE $force Force l'écrasement du fichier
     * @return bool
     * @throws ForbiddenException
     */
    public function generer_appel_pdf($operation_id, $force = FALSE)
    {
        try {
            $this->loadModel('Operations');
            $this->loadModel('Documents');

            if ($this->Documents->exists(['operation_id' => $operation_id,
                                          'type'         => AppConstants::DOC_APPEL]) && !$force
            ) {
                return FALSE;
            }

            if (!is_null($operation_id)) {
                $operation = $this->Operations->get($operation_id, ['contain' => ['Operationdetails',
                                                                                  'Operationdetails.TypeOperations',
                                                                                  'Clients',
                                                                                  'Bails',
                                                                                  'Bails.Societes']]);
                $filename = 'appel_' . $operation_id . '_' . date_format($operation->created, 'Y-m-d-H-i');
                // on mets à jour l'enregistrement du rapports (champs modified)
                $view = new View();
                $view->set(compact('operation', 'filename'));
                $viewdata = $view->render('Operations/appel', 'pdf/default');
                // on vérifie si le fichier existe bien, donc qu'il a été créé
                if (file_exists(ROOT . DS . 'PDF' . DS . $filename . '.pdf')) {
                    $document = $this->Documents->findOrCreate(['operation_id' => $operation_id,
                                                                'type'         => AppConstants::DOC_APPEL]);
                    $document->operation_id = $operation_id;
                    $document->file = $filename . '.pdf';
                    $document->type = AppConstants::DOC_APPEL;
                    $document->libelle = __('Appel - généré le ') . date('d/m/Y');
                    return $this->Documents->save($document);
                } else
                    return FALSE;
            } else {
                throw new ForbiddenException(__('Accès direct non autorisé'));
            }
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function generer_facture_pdf($operation_id, $force = FALSE)
    {
        try {
            $this->loadModel('Operations');
            $this->loadModel('Documents');

            if ($this->Documents->exists(['operation_id' => $operation_id,
                                          'type'         => AppConstants::DOC_APPEL]) && !$force
            ) {
                return FALSE;
            }

            if (!is_null($operation_id)) {
                $operation = $this->Operations->get($operation_id, ['contain' => ['Operationdetails',
                                                                                  'Operationdetails.TypeOperations',
                                                                                  'Tiers',
                                                                                  'Societes']]);
                $filename = 'facture_' . $operation_id . '_' . date_format($operation->created, 'Y-m-d-H-i');
                // on mets à jour l'enregistrement du rapports (champs modified)
                $view = new View();
                $view->set(compact('operation', 'filename'));
                $viewdata = $view->render('Operations/facture', 'pdf/default');
                // on vérifie si le fichier existe bien, donc qu'il a été créé
                if (file_exists(ROOT . DS . 'PDF' . DS . $filename . '.pdf')) {
                    $document = $this->Documents->findOrCreate(['operation_id' => $operation_id,
                                                                'type'         => AppConstants::DOC_APPEL]);
                    $document->operation_id = $operation_id;
                    $document->file = $filename . '.pdf';
                    $document->type = AppConstants::DOC_APPEL;
                    $document->libelle = __('Facture - générée le ') . date('d/m/Y');
                    return $this->Documents->save($document);
                } else
                    return FALSE;
            } else throw new ForbiddenException(__('Accès direct non autorisé'));
        } catch (Exception $ex) {
            return FALSE;
        }

    }

    /**
     * Génère la quittance de loyer associée à l'opération
     * @param int $operation_id Référence de l'opération
     * @return bool
     * @throws ForbiddenException
     */
    public function generer_quittance_pdf($operation_id, $force = FALSE)
    {
        $this->loadModel('Operations');
        $this->loadModel('Documents');


        if ($this->Documents->exists(['operation_id' => $operation_id,
                                      'type'         => AppConstants::DOC_QUITTANCE]) && !$force
        ) {
            return FALSE;
        }

        if (!is_null($operation_id)) {
            $operation = $this->Operations->get($operation_id, ['contain' => ['Operationdetails',
                                                                              'Operationdetails.TypeOperations',
                                                                              'Clients',
                                                                              'Bails',
                                                                              'Bails.Societes',
                                                                              'Bails.TypePeriodicites',
                                                                              'Bails.Biens']]);
            $filename = 'quittance_' . $operation_id . '_' . date_format($operation->created, 'Y-m-d-H-i');
            // on mets à jour l'enregistrement du rapports (champs modified)
            $view = new View();
            $view->set(compact('operation', 'filename'));
            $viewdata = $view->render('Operations/quittance', 'pdf/default');
            // on vérifie si le fichier existe bien, donc qu'il a été créé
            if (file_exists(ROOT . DS . 'PDF' . DS . $filename . '.pdf')) {
                $document = $this->Documents->findOrCreate(['operation_id' => $operation_id,
                                                            'type'         => AppConstants::DOC_QUITTANCE]);
                $document->operation_id = $operation_id;
                $document->file = $filename . '.pdf';
                $document->type = AppConstants::DOC_QUITTANCE;
                $document->libelle = __('Quittance - générée le ') . date('d/m/Y');
                return $this->Documents->save($document);
            } else
                return FALSE;
        } else throw new ForbiddenException(__('Accès direct non autorisé'));
    }
}
