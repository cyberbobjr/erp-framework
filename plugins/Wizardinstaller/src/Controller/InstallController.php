<?php

    namespace Wizardinstaller\Controller;

    use Cake\Core\Configure;
    use Cake\Core\Exception\Exception;
    use Cake\Datasource\ConnectionManager;
    use Cake\ORM\TableRegistry;
    use Migrations\Migrations;

    /**
     * Wizard Controller
     *
     */
    class InstallController extends AppController
    {

// étape vérification pré-requis : urlrewriting et chmod
// étape 1 : URL du site
// étape 2 : Configuration BDD (host, login, mot de passe) et test
// étape 3 : Création d'un compte admin+mot de passe et création des tables users/groupes/droits
// étape 3 : Validation et enregistrement

        /**
         * Le fichier de configuration de la BDD doit être dans un fichier indépendant, ce qui permet de le générer lorsque
         * la BDD est validée
         * Une fois la configuration enregistrée, un fichier install.lock est créé.
         * C'est ce fichier install.lock qui est vérifié pour déterminer si l'application doit être installée ou est déjà
         * paramétrée
         * En supprimant le fichier install.lock l'utilisateur peut refaire une installation propre de GSO
         * @throws \Exception
         */

        public function step($step = 1)
        {
            if (file_exists(ROOT . DS . 'install.lock')) {
                throw new \Exception(__('L\'installation a déjà été paramétrée, supprimez le fichier install.lock pour recommencer l\'installation.'));
            }
            // vérification anti petits malins
            if ($step > 5) {
                $this->Flash->error(__('Etape inconnue'));
                return $this->redirect(['action' => 'step',
                                        1]);
            }

            /**
             * Si c'est un simple affichage de la page
             */
            if ($this->request->is('get')) {
                // en fonction de l'étape
                return $this->_displayStep($step);
            }
            /**
             * Si c'est une requête de passage à l'étape suivante
             */
            if ($this->request->is('post')) {
                return $this->_parseStep($step);
            }
        }

        private function _displayStep($step)
        {
            switch ($step) {
                case 1 :
                    break;
                case 2 :
                    // gestion des informations de la bdd
                    $this->_readSession('bdd');
                    break;
                case 3 :
                    // gestion du compte administrateur
                    $this->_readSession('admin');
                    break;
                case 4:
                    // vérification que les données en session soient bien présentes
                    if (!$this->_ready()) {
                        $this->Flash->error(__('Elements manquants, redirection vers la page principale de configuration'));
                        return $this->redirect(['action' => 'step',
                                                1]);
                    }
                    // récapitulatif des informations et sauvegarde définitive
                    break;
                case 5:
                    $this->_executeInstallation();
                    break;
            }
            $this->set('step', $step);
        }

        private function _parseStep($step): ?\Cake\Http\Response
        {
            switch ($step) {
                case 1 :
                    // step1 : Informations et prérequis
                    break;
                case 2 :
                    // step2 : Renseignement url et BDD
                    // enregistrement de la configuration en session et passage au step suivant
                    $this->_saveSession('bdd', $this->request->getData());
                    break;
                case 3:
                    // step3 : Renseignements admin/pwd
                    $this->_saveSession('admin', $this->request->getData());
                    // vérification de la conformité du mot de passe
                    if (!$this->_isPasswordCorrect()) {
                        $this->Flash->error(__('Les mots de passe ne correspondent pas'));
                        return $this->redirect(['action' => 'step',
                                                $step]);
                    }
                    break;
                case 4:
                    // step4 : finalisation de l'installation
                    // vérification que les données en session soient bien présentes
                    if (!$this->_ready()) {
                        $this->Flash->error(__('Elements manquants, redirection vers la page principale de configuration'));
                        return $this->redirect(['action' => 'step',
                                                1]);
                    }
                    // enregistrement de la configuration
                    if (!$this->_saveConfig()) {
                        $this->Flash->error(__('Erreur lors de l\'enregistrement de la configuration'));
                        return $this->redirect(['action' => 'step',
                                                4]);
                    }
                    $this->Flash->success(__('Configuration enregistrée'));
                    // la configuration s'est bien enregistrée, nous allons pouvoir créer les tables de l'application
                    return $this->redirect(['action' => 'step',
                                            5]);
                    break;
            }
            // redirection vers l'étape suivante
            $step = $this->_getStep();
            return $this->redirect(['action' => 'step',
                                    $step]);
        }

        /**
         * Récupération les informations en session
         * @param string $index Nom de la clef à récupérer en session
         */
        private function _readSession($index)
        {
            if (!is_null($this->request->getSession()
                                       ->read($index))
            ) {
                $formDatas = json_decode($this->request->getSession()
                                                       ->read($index), TRUE);
                $this->request = $this->request->withParsedBody($formDatas);
            }
        }

        private function _ready()
        {
            return ($this->request->getSession()
                                  ->check('admin') && $this->request->getSession()
                                                                    ->check('bdd'));
        }

        private function _executeInstallation()
        {
            $valid = TRUE;
            if ($this->_isTablesMustBeCreated()) {
                $valid = $this->_createTables();
            }
            /**
             * Création du compte administrateur
             */
            if ($this->_createAdminAccount()) {
                $this->Flash->success(__('compte administrateur créé'));
            } else {
                $this->Flash->error(__('Erreur durant la création du compte administrateur'));
                $valid = FALSE;
            }
            if ($valid) {
                // création du fichier install.lock
                touch(ROOT . DS . 'install.lock');
            }
            $this->set('valid', $valid);
        }

        private function _isTablesMustBeCreated()
        {
            $bdd = json_decode($this->request->getSession()
                                             ->read('bdd'), TRUE);
            return !$bdd['notcreate'];
        }

        private function _createTables()
        {
            // création des tables et enregistrement de l'utilisateur
            if (!$this->_generateTables()) {
                $this->Flash->error(__('Erreur durant la création des tables'));
                return FALSE;
            }
            $this->Flash->success(__('Tables créées'));

            if (!$this->_createRights()) {
                $this->Flash->error(__('Erreur durant la création des droits'));
                return FALSE;
            }

            $this->Flash->success(__('Rights créés'));
            return TRUE;
        }

        /**
         * Génére les tables nécessaires pour l'application
         * @return bool TRUE en cas de succès, FALSE si échec
         */
        private function _generateTables(): bool
        {
            $migrations = new Migrations();
            try {
                $success = $migrations->migrate(['plugin' => 'Wizardinstaller']);
            } catch (\Exception $ex) {
                debug($ex->getMessage());
                debug($ex->getTraceAsString());
                $success = FALSE;
            }
            return $success;
        }

        /**
         * Création des droits dans la table droits
         * @return array|bool|\Cake\ORM\ResultSet
         */
        private function _createRights(): \Cake\ORM\ResultSet|bool|array
        {
            $migrations = new Migrations();
            try {
                $success = $migrations->seed(['seed' => 'RightsSeed']);
            } catch (\Exception $ex) {
                $success = FALSE;
            }
            return $success;
        }

        /**
         * Création du compte admin
         * @return bool
         */
        private function _createAdminAccount()
        {
            $admin = json_decode($this->request->getSession()
                                               ->read('admin'), TRUE);
            $groupestable = TableRegistry::getTableLocator()
                                         ->get('UserManager.Groupes');
            $userstable = TableRegistry::getTableLocator()
                                       ->get('UserManager.Users');
            $groupe = $groupestable->findOrCreate(['label' => 'ADMIN'], function ($entity) {
                $entity->description = __('Super-administrateurs de l\'application');
            });
            $user = $userstable->newEntity(['username'   => $admin['login'],
                                            'password'   => $admin['password'],
                                            'email'      => $admin['email'],
                                            'lastname'   => $admin['lastname'],
                                            'firstname'  => $admin['firstname'],
                                            'last_login' => date('now')], ['validate' => FALSE]);
            $user = $userstable->save($user);
            if ($user && $groupe) {
                $userstable->Groupes->link($user, [$groupe]);
                $groupestable->Rights->link($groupe, [$user]);
                return TRUE;
            }
            return FALSE;
        }

        /**
         * Sauvegarde les informations en session
         * @param string $index Nom de la clef à utiliser pour la session
         * @param array $data Tableau à sauvegarder
         */
        private function _saveSession($index, $data)
        {
            $this->request->getSession()
                          ->write($index, json_encode($data));
        }

        /**
         * Vérifie que le mot de passe est identique à la confirmation du mot de passe
         * @return bool
         */
        private function _isPasswordCorrect()
        {
            return ($this->request->getData('password') == $this->request->getData('confirmpassword'));
        }

        /**
         * Enregistre la configuration
         */
        private function _saveConfig()
        {
            // paramétrage de la datasource

            // lancement des opérations de création de la configuration
            if ($this->_configureDatasource() && $this->_generateClef()) {
                // la configuration a bien été générée, on peut enregistrer le fichier de configuration
                return Configure::dump('app_config', 'default', ['Security',
                                                                 'Datasources']);
            } else {
                return FALSE;
            }
        }

        /**
         * Génére le fichier de configuration Bdd
         * @return bool
         */
        private function _configureDatasource()
        {
            $bdd = json_decode($this->request->getSession()
                                             ->read('bdd'), TRUE);
            $bdd['className'] = 'Cake\Database\Connection';
            $bdd['driver'] = 'Cake\Database\Driver\Mysql';
            $bdd['persistent'] = FALSE;
            $bdd['encoding'] = 'utf8';
            $bdd['timezone'] = 'UTC';
            $bdd['cacheMetadata'] = TRUE;
            unset($bdd['clef']);
            unset($bdd['step3']);
            unset($bdd['notcreate']);
            $testbdd = $bdd;
            $testbdd['database'] = 'test_' . $bdd['database'];
            Configure::write('Datasources.test', $testbdd);
            return Configure::write('Datasources.default', $bdd);
        }

        /**
         * Génére le fichier de configuration pour la clef de sécurité
         * @return bool
         */
        private function _generateClef()
        {
            $bdd = json_decode($this->request->getSession()
                                             ->read('bdd'), TRUE);
            return Configure::write('Security.salt', $bdd['clef']);
        }

        /**
         * Retourne l'étape demandée
         * @return int Numéro de l'étape
         */
        private function _getStep()
        {
            if (!is_null($this->request->getData('step1'))) {
                return 1;
            }
            if (!is_null($this->request->getData('step2'))) {
                return 2;
            }
            if (!is_null($this->request->getData('step3'))) {
                return 3;
            }
            if (!is_null($this->request->getData('step4'))) {
                return 4;
            }
            return 1;
        }

        /**
         * Fonction qui vérifie si les paramètres de la BDD sont corrects
         * Les paramètres sont en $_POST
         * Cette fonction est appelée en AJAX et renvoie un résultat JSON ok/nok
         */
        public function checkBdd()
        {
            // récupération des informations $_POST
            $host = $this->request->getData('host');
            $login = $this->request->getData('username');
            $pwd = $this->request->getData('password');
            $bdd = $this->request->getData('database');
            // si l'un des paramètres est vide, erreur
            if (is_null($host) || is_null($login) || is_null($pwd) || is_null($bdd)) {
                $result = ['success' => FALSE,
                           'msg'     => __('Les informations ne sont pas complètes')];
            } else {
                // paramètres non vide, nous testons la configuration
                if ($this->_checkBdd($host, $login, $pwd, $bdd)) {
                    $result = ['success' => TRUE,
                               'msg'     => __('Connexion réussie')];
                } else {
                    $result = ['success' => FALSE,
                               'msg'     => __('Les informations saisies ne sont pas correctes, erreur de connexion')];
                }
            }
            $this->set(compact('result'));
        }

        /**
         * Fonction de vérification des informations de connexion à la BDD
         * @param string $host Adresse du serveur MySQL
         * @param string $login Login du serveur MySQL
         * @param string $pwd Mot du passe du serveur
         * @param string $bdd Nom de la base de donnée
         * @return bool TRUE si connexion réussie, FALSE sinon
         */
        private function _checkBdd($host, $login, $pwd, $bdd)
        {

            ConnectionManager::setConfig('testgso', ['className'        => 'Cake\Database\Connection',
                                                     'driver'           => 'Cake\Database\Driver\Mysql',
                                                     'persistent'       => TRUE,
                                                     'host'             => $host,
                                                     'username'         => $login,
                                                     'password'         => $pwd,
                                                     'database'         => $bdd,
                                                     'encoding'         => 'utf8',
                                                     'timezone'         => 'UTC',
                                                     'cacheMetadata'    => TRUE,
                                                     'quoteIdentifiers' => FALSE,
                                                     'log'              => TRUE,]);
            try {
                $connection = ConnectionManager::get('testgso');
                $connected = $connection->connect();
            } catch (Exception $connectionError) {
                $connected = FALSE;
                $errorMsg = $connectionError->getMessage();
                if (method_exists($connectionError, 'getAttributes')):
                    $attributes = $connectionError->getAttributes();
                    if (isset($errorMsg['message'])):
                        $errorMsg .= '<br />' . $attributes['message'];
                        debug($errorMsg);
                    endif;
                endif;
            }
            return $connected;
        }
    }
