<?php

    namespace UserManager\Controller;

    use Cake\Collection\Collection;
    use Cake\Core\Configure;
    use Cake\Event\Event;
    use Cake\Http\Exception\BadRequestException;
    use Cake\Http\Exception\ForbiddenException;
    use Cake\Http\Exception\NotFoundException;
    use Cake\Http\Exception\UnauthorizedException;
    use Cake\Mailer\Email;
    use Cake\Network\Http\Client;
    use Cake\Network\Response;
    use Cake\Utility\Security;
    use Exception;
    use UserManager\Model\Table\UsersTable;
    use UserManager\Utility\Droits;

    /**
     * Users Controller
     *
     * @property UsersTable $Users
     */
    class UsersController extends AppController
    {
        /**
         * Indique si l'utilisateur peut ajouter ou éditer l'utilisateur en paramètre
         * @param array $currentuser Tableau contenant les informations de l'utilisateur connecté
         * @param null  $user_id Utilisateur à modifier ou NULL si nouvel utilisateur
         * @return bool TRUE si autorisé, FALSE sinon
         */
        private function _canAdmin($currentuser, $user_id = NULL)
        {
            if (!is_null($user_id)) {
                // récupération de l'utilisateur
                $user = $this->Users->get($user_id);
                if (!$user) {
                    throw new NotFoundException(__('Utilisateur non trouvé'));
                }
                if ($currentuser['id'] == $user_id) {
                    return TRUE;
                }
                return ((Droits::aLeDroit('ADMIN')) || (Droits::aLeDroit('SUPERADMIN')));
            }
            return (Droits::aLeDroit('ADMIN'));
        }

        /**
         * Affiche la liste des utilisateurs
         * Uniquement disponible si l'utilisateur est admin
         */
        public function index()
        {
            /*if (!Droits::aLeDroit('ADMIN')) {
                throw new ForbiddenException(__('Accès non autorisé'));
            }*/
            $users = $this->Users->find('all')
                                 ->contain(['Groups']);
            $title = __('Liste des utilisateurs');
            $this->set(compact('users', 'title'));
        }

        /**
         * Affiche le détail d'un utilisateur
         * @param int $id Identifiant référencant l'utilisateur désiré
         * @throws NotFoundException
         */
        public function view($id = NULL)
        {
            if (is_null($id)) {
                $id = $this->Auth->User('id');
            }
            if (!$id || !$this->Users->exists(['id' => $id])) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            if (($id != $this->Auth->User('id')) && (!Droits::aLeDroit('ADMIN'))) {
                throw new ForbiddenException(__('Accès non autorisé'));
            }

            $user = $this->Users->get($id);
            $this->set(compact('user'));
        }

        /**
         * Edite un utilisateur en spécifiant son identifiant
         * @param int $id Référence de l'utilisateur à modifier
         * @throws NotFoundException
         */
        public function edit($id = NULL)
        {
            if (is_null($id)) {
                $id = $this->request->getSession()
                                    ->read('Auth.User.id');
            }
            $userToEdit = $this->request->getSession()
                                        ->read('Auth.User');

            if (!$this->_canAdmin($userToEdit, $id)) {
                $this->Flash->error(__('Accès non autorisé'));
                $this->redirect($this->request->referer());
            }

            // si l'utilisateur courant n'est pas l'utilisateur édité et n'est pas admin, on renvoie une erreur
            // si l'id est null, on récupère l'id de l'utilisateur en cours
            // Si l'identifiant n'existe pas nous levons une exception
            if (!$id || !$this->Users->exists(['id' => $id])) {
                throw new NotFoundException(__('Référence introuvable'));
            }
            // récupération de l'utilisateur
            $userToEdit = $this->Users->get($id, ['contain' => ['Groups']]);
            // pour ne rien afficher dans le champ password, on efface la propriété password
            unset($userToEdit['password']);
            // Si la requête est de type post, put ou patch, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put',
                                    'patch'])
            ) {
                $postData = $this->request->getData();
                // traitement de l'image du profile
                unset($postData['password']);
                unset($postData['password_confirm']);
                if (!empty($this->request->getData('password'))) {
                }
                $this->Users->patchEntity($userToEdit, $postData);
                if ($this->Users->save($userToEdit)) {
                    $this->Flash->success(__('Utilisateur mis à jour'));
                } else {
                    $this->Flash->error(__('Erreur lors de la mise à jour'));
                }
                unset($userToEdit['password']);
                unset($userToEdit['password_confirm']);
            }
            $groups = $this->Users->Groupes->find('list');

            $this->set(compact('userToEdit', 'groups'));
        }

        /**
         * Ajoute ou modifie un utilisateur
         * Cette fonction est utilisée par l'administrateur de l'organisation pour déclarer ou modifier les utilisateurs autorisés
         * Seuls les administrateurs d'organisation ou superadmin peuvent appeler cette fonction
         * @param int $user_id Référence de l'utilisateur si modification
         * @return Response|null
         */
        public function add($user_id = NULL)
        {
            if (!is_null($user_id)) {
                $userToEdit = $this->Users->get($user_id, ['contain' => 'Groups']);
            } else {
                $userToEdit = $this->Users->newEntity();
            }
            // Si la requête est de type post ou put, alors nous traitons les données reçues du formulaire
            if ($this->request->is(['post',
                                    'put'])
            ) {
                $userToEdit = $this->Users->patchEntity($userToEdit, $this->request->getData(), ['associated' => ['Groups']]);
                if ($this->Users->save($userToEdit)) {

                    $this->Flash->success(__('Utilisateur créé avec succès !'));
                    $this->redirect(['controller' => 'Users',
                                     'action'     => 'index',
                                     'plugin'     => 'UserManager']);
                } else {
                    $this->set('errors', $userToEdit->getErrors());
                    $this->Flash->error(__('Erreur dans la sauvegarde'));
                }
            }
            $groups = $this->Users->Groups->find('list');
            // récupération de la liste des avatars présents dans un répertoire
            $avatars = [];
            foreach (glob(WWW_ROOT . 'img/avatars/*.png') as $filename) {
                $avatars[] = basename($filename);
            }

            $this->set(compact('userToEdit', 'avatars', 'groups'));
        }

        /**
         * Supprime un utilisateur en spécifiant son identifiant
         * @return Response|null
         * @throws NotFoundException
         */
        public function delete($users_id)
        {
            //$users_id = $this->request->getData('id');
            // si l'identifiant n'existe pas nous levons une exception
            if (!$users_id || !$this->Users->exists(['id' => $users_id])) {
                throw new NotFoundException(__('Référence invalide'));
            }
            $user = $this->Users->get($users_id);
            if ($user) {
                if ($this->Users->setArchive($user->id)) {
                    $this->Flash->success(__('L\'utilisateur avec l\'id {0} a été supprimé.', h($users_id)));
                } else {
                    $this->Flash->error(__('Erreur lors de la suppression de l\'utilisateur {0}', h($users_id)));
                }
            }
            $this->redirect(['action' => 'index']);
        }

        /**
         * Affiche la page de login et connecte un utilisateur le cas échéant
         * @return Response|null
         */
        public function login()
        {
            if ($this->_isCookieValid()) {
                $this->_processAuthByCookie();
            } else {
                if ($this->request->is('post')) {
                    $this->_processLoginRequest();
                }
            }
        }

        /**
         * Vérifie la conformité du cookie en s'appuyant sur l'adresse IP stocké à l'intérieur
         * @return bool
         */
        private function _isCookieValid(): bool
        {
            if (!$this->request->getCookie('Gso.ip') || !$this->request->getCookie('GSO.user')) {
                return FALSE;
            }
            $ip = $this->request->getCookie('GSO.ip');
            $ipclient = $this->request->clientIp();
            return ($ip === $ipclient);
        }

        private function _processAuthByCookie()
        {
            $user = $this->_authByCookie($this->Cookie->read('GSO.username'), $this->Cookie->read('GSO.password'));
            if ($user) {
                $this->connectUser($user);
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Cookie d\'authentification non valide'));
                $this->Cookie->delete('GSO');
            }
        }

        private function _processLoginRequest()
        {
            // On identifie l'utilisateur avec les paramètres fournis par la requête POST
            $user = $this->Auth->identify();
            $user ? $this->_loginSuccess($user) : $this->_loginFailure();
        }

        private function _authByCookie($user, $password)
        {
            $this->request->withData('username', $user);
            $this->request->withData('password', $password);
            $user = $this->Auth->identify();
            return $user;
        }

        /**
         * Connexion de l'utilisateur, nous spécifions la date de connexion et nous plaçons les informations des droits
         * en session
         * @param array $userToConnect contenant les informations de l'utilisateur
         */
        public function connectUser($userToConnect)
        {
            $this->Auth->setUser($userToConnect);
            Droits::setUser($userToConnect);
            // nous récupérons l'utilisateur avec ses groupes
            $fullUser = $this->Users->get($userToConnect['id'], ['contain' => ['Groups',
                                                                               'Groups.Rights']]);
            // et nous enregistrons l'information en Session
            $fullUser->last_login = $this->_getLastLogin($userToConnect);
            $fullUser->ip = $this->_getLastIp($userToConnect);
            $this->Auth->setUser($fullUser->toArray());
            Droits::setUser($fullUser);
            $this->_saveDroitsInSession($fullUser->groupes);
        }

        private function _loginSuccess($user)
        {
            // Si l'utilisateur est identifié
            // si l'utilisateur se connecte pour la 1ere fois, on renvoie vers la page de changement de mot de passe
            if ($this->_isFirstTimeLogin($user)) {
                $this->_redirectToFirstLogin($user);
            } else {
                // sinon nous connectons
                $this->connectUser($user);
                // si l'utilisateur demande a être authentifié via le cookie, nous enregistrons le cookie
                if ($this->request->getData('remember')) {
                    $this->_setCookieLogin($user);
                }
                // nous envoyons un événement système "login success"
                $this->_sendEventWithName('User.Login.Success', ['user' => $user]);
                $this->redirect($this->Auth->redirectUrl());
            }
        }

        private function _loginFailure()
        {
            $username = $this->Users->find('auth')
                                    ->where(['username' => $this->request->getData('username')])
                                    ->first();
            $errorMsg = $username ? __('Login ou mot de passe incorrect.') : __('Compte inexistant');
            $this->Flash->error($errorMsg);
            $this->_sendEventWithName('User.Login.Failure', ['request' => $this->request]);
        }

        private function _getLastLogin($user)
        {
            // on récupère le dernier login
            $last_login = $user['last_login'];
            // on indique le dernier login
            $this->Users->setLastLogin($user['id'], date('Y-m-d H:i:s'));
            return $last_login;
        }

        private function _getLastIp($user)
        {
            $last_ip = NULL;
            if (isset($user['ip'])) {
                $last_ip = $user['ip'];
            }
            // on sauvegarde l'IP
            $this->Users->setIp($this->request->clientIp(), $user['id']);
            return $last_ip;
        }

        private function _saveDroitsInSession($groups)
        {
            // nous enregistrons les droits en sessions
            $rights = (new Collection($groups))->extract('rights.{*}.code');
            Droits::setDroits($rights);
            $this->request->session()
                          ->write('rights', $rights->toArray());
        }

        private function _isFirstTimeLogin($user)
        {
            return (is_null($user['last_login']));
        }

        private function _redirectToFirstLogin($user)
        {
            $this->request->session()
                          ->write('Auth.User', $user);
            $this->redirect(['controller' => 'Users',
                             'action'     => 'first_login',
                             'plugin'     => 'UserManager']);
        }

        private function _setCookieLogin($user)
        {
            $this->Cookie->setConfig(['expires' => '+1 month']);
            $this->Cookie->write('GSO', ['user'     => $user['username'],
                                         'password' => $this->request->getData('password')]);
        }

        private function _sendEventWithName($name, $params)
        {
            $event = new Event($name, $this, $params);
            $this->getEventManager()
                 ->dispatch($event);
        }

        /**
         * Déconnecte un utilisateur
         */
        public function logout()
        {
            $this->_removeAuthCookie();
            $this->request->getSession()
                          ->destroy();
            $this->Flash->success(__('Vous êtes bien déconnecté'));
            return $this->redirect($this->Auth->logout());
        }

        /**
         * Supprime le cookie d'authentification
         */
        private function _removeAuthCookie()
        {
            $this->Cookie->delete('GSO');
        }

        /**
         * Cette fonction affiche une page indiquant que l'utilisateur a tenté d'accéder à une page non autorisée
         */
        public function forbidden()
        {
            throw new ForbiddenException(__('Accès interdit'));
        }

        /**
         * Page affichée lors de la 1ère connexion, utilisée pour demander à l'utilisateur de changer son mot de passe
         */
        public function firstLogin()
        {
            $userToEdit = $this->Users->newEntity($this->request->getData(), ['validate' => 'password']);
            // demande de changement de mot de passe
            if ($this->request->is('post')) {
                $userToEdit = $this->Users->patchEntity($userToEdit, $this->request->getData(), ['validate' => 'password']);
                if ($userToEdit->hasErrors()) {
                    $this->set('errors', $userToEdit->getErrors());
                    $this->Flash->error(__('Erreur de saisie, recommencez s\'il vous plait'));
                } else {
                    // on récupère les informations de session
                    $userToEdit = $this->request->getSession()
                                                ->read('Auth.User');
                    if (is_null($userToEdit)) {
                        $this->Flash->error(__('Session expirée, recommencez s\'il vous plait'));
                        return $this->redirect($this->Auth->redirectUrl());
                    } else {
                        // récupération de l'utilisateur
                        $userToEdit = $this->Users->get($userToEdit['id']);
                        $userToEdit = $this->Users->patchEntity($userToEdit, $this->request->getData(),
                            ['validate' => 'password']);
                        if ($this->Users->save($userToEdit)) {
                            $this->Flash->success(__('Votre mot de passe a bien été modifié'));
                            $this->connectUser($userToEdit->toArray());
                            return $this->redirect($this->Auth->redirectUrl());
                        } else {
                            $this->Flash->error(__('Erreur de sauvegarde du nouveau mot de passe'));
                        }
                    }
                }
            }
            $this->set('userToEdit', $userToEdit);
        }

        /**
         * Ecran sur mot de passe oublié
         * Une clef de réinitialisation est caclulée puis envoyée par mail
         */
        public function lostPassword()
        {
            // si la requête est de type post, on traite les données
            if ($this->request->is(['post'])) {
                // on s'assure que l'email existe bien dans la base
                $courriel = $this->request->getData('courriel');
                $this->_parsePostDataLostPassword($courriel);
            }
        }

        private function _parsePostDataLostPassword($courriel)
        {
            if (!$this->_isCourrielExist($courriel)) {
                // si l'email n'existe pas, on affiche un message d'erreur
                $this->Flash->error(__('Ce courriel n\'est pas référencé dans notre base en tant qu\'utilisateur'));
            } else {
                $user = $this->Users->setResetKey($courriel);
                // si l'email existe, on calcule une clef temporaire pour le compte
                if ($user) {
                    // on envoie le mail de réinitialisation
                    $this->send_lost_password_mail($user);
                    // on redirige vers la page d'index avec un message
                    $this->Flash->success(__('Les instructions pour réinitialiser votre mot de passe ont été envoyées sur votre courriel'));
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('Erreur lors de la création de la clef de réinitialisation'));
                }
            }
        }

        private function _isCourrielExist($courriel)
        {
            return ($this->Users->find('all', ['bypassAuth' => TRUE])
                                ->where(['email' => $courriel])
                                ->count() >= 1);
        }

        /**
         * Envoie un mail de récupération de mot de passe à un utilisateur
         * @param null $user
         * @return bool
         */
        private function send_lost_password_mail($user = NULL)
        {
            $email = new Email();
            $email->setTemplate('UserManager.lost_password')
                  ->setFrom(['technique@key-conseil.fr' => 'GSE'])
                  ->setSubject(__('Récupération du mot de passe'))
                  ->setEmailFormat('html')
                  ->setViewVars(['user' => $user])
                  ->setTo($user->courriel)
                  ->send();
        }

        /**
         * Lien de confirmation reçu par mail
         * L'écran va afficher la possibilité de créer un mot de passe pour l'utilisateur
         * @param string $uuid Clef de réinitialisation
         * @return Response|null
         * @throws BadRequestException
         */
        public function resetPassword($uuid = NULL)
        {
            $userToEdit = $this->Users->find('all', ['bypassAuth' => TRUE])
                                      ->where(['Users.uuid' => $uuid])
                                      ->first();
            if (is_null($uuid) || (!$userToEdit)) {
                //@todo rajouter une sécurité en cas d'attaque par bruteforce
                throw new NotFoundException(__('Requête incorrecte'));
            }

            if ($this->request->is(['post',
                                    'put'])
            ) {
                Droits::setUser($userToEdit);
                $userToEdit = $this->Users->patchEntity($userToEdit, $this->request->getData());
                if ($this->Users->save($userToEdit)) {
                    $this->Users->removeResetKey($userToEdit->id);
                    // on connecte l'utilisateur
                    $this->connectUser($userToEdit->toArray());
                    $this->Flash->success(__('Votre mot de passe a été réinitialisé'));
                    $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__('Erreur lors de l\'enregistrement du mot de passe'));
                }
            } else {
                unset($userToEdit->password);
            }
            $this->set(compact('userToEdit'));
        }

        /**
         * Cette fonction va lier le compte utilisateur courant avec son compte Google
         * La liaison avec le compte Google va permettre d'inscrire / lire les événements dans son calendrier
         */
        function linkGoogle()
        {
            // un jeton existe-t'il et est-il existant et toujours valide ?
            $user = $this->_getUser();
            $access_token = $this->Users->getAccessToken($user['id']);
            if (is_null($access_token)) {
                // pas de jeton associé à l'utilisateur, on redirige vers la page d'autorisation de Google
                return $this->redirect(['action' => 'oauth2callback']);
            }
            // sinon cela signifie qu'un jeton existe déjà
            $this->Flash->success(__('Votre compte est déjà lié à votre compte Google'));
            $this->redirect(['action' => 'edit']);
        }

        /**
         * Retourne l'utilisateur connecté
         * @return null|string
         */
        private function _getUser()
        {
            return $this->request->getSession()
                                 ->read('Auth.User');
        }

        /**
         * Fonction d'enregistrement d'un utilisateur
         * La fonction register ne doit pas être
         */
        public function register()
        {
            if (Configure::read('UserManager.register') == FALSE) {
                $this->Flash->error(__('L\'enregistrement a été désactivé par l\'administrateur'));
                $this->redirect(['action' => 'login']);
            }

        }

        private function _isCaptchaValid()
        {
            $captcha = $this->request->getData('g-recaptcha-response');
            $debug = Configure::read('debug');
            if ((!$debug) && (empty($captcha) || !$this->_checkCaptcha($captcha))) {
                throw new Exception(__('Erreur, le captcha est invalide'));
            }
        }

        private function _isEmailConfirm()
        {
            if ($this->request->getData('owner.courriel') !== $this->request->getData('owner.courriel_confirm')) {
                throw new Exception(__('Erreur, les courriels ne correspondent pas'));
            }
        }

        /**
         * Vérifie le CAPTCHA Google
         * @param $code
         */
        private function _checkCaptcha($code)
        {
            $client = new Client();
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
                ['secret'   => '6LcSFxYUAAAAAFgYUUCBYArOCqeNun-Foo81cc23',
                 'response' => $code,
                 'remoteip' => $this->request->clientIp()]);
            $json = $response->json;
            return ($json['success']);
        }

        /**
         * Génère un JWT pour un utilisateur
         */
        public function token()
        {
            $user = $this->Auth->identify();
            if (!$user) {
                throw new UnauthorizedException('Invalid email or password');
            }

            $this->set(['success'    => TRUE,
                        'data'       => ['token' => $token = JWT::encode(['id'  => $user['id'],
                                                                          'sub' => $user['id'],
                                                                          'exp' => time() + 604800], Security::salt())],
                        '_serialize' => ['success',
                                         'data']]);
        }

        /**
         * Valide un utilisateur (clic sur mail de confirmation mail)
         * @param null $uuid
         * @return Response|null
         */
        public function validateUser($uuid = NULL)
        {
            if (is_null($uuid)) {
                throw new NotFoundException(__('UUID manquant dans la requête'));
            }
            // récupération de l'utilisateur
            $user = $this->Users->find()
                                ->where(['uuid' => $uuid])
                                ->first();
            if (!$user) {
                throw new NotFoundException(__('Utilisateur non trouvé'));
            }
            // activation de l'utilisateur
            $this->Users->setActive($user->id, TRUE);
            // connexion de l'utilisateur
            $this->connectUser($user);
            // message de succès
            $this->Flash->success(__('Votre compte a été authentifié, bienvenue !'));
            // redirection vers la page principale
            $this->redirect($this->Auth->redirectUrl());

        }
    }
