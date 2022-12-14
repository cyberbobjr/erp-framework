<?php

    namespace Wizardinstaller\libs;

    use Cake\ORM\ResultSet;
    use Cake\ORM\TableRegistry;
    use Migrations\Migrations;
    use UserManager\Model\Table\GroupsTable;
    use UserManager\Model\Table\UsersTable;
    use Wizardinstaller\Exceptions\InstallException;

    class InstallService
    {
        private string $connection;

        public function __construct($connection = 'default')
        {
            $this->connection = $connection;
        }

        /**
         * @param $admin
         * @param $bdd
         * @return array
         */
        public function execute($admin, $bdd): array
        {
            if ($admin === NULL || $bdd === NULL) {
                throw new InstallException(__("Données vides, session expirée"));
            }
            $results = [];
            $this->_isTablesMustBeCreated($bdd) && !$this->_createTables();
            $results[] = __('Tables et droits créés');

            /**
             * Création du compte administrateur
             */
            if (!$this->_createAdminAccount($admin)) {
                throw new InstallException(__('Erreur durant la création du compte administrateur'));
            }
            $results[] = __('compte administrateur créé');
            $this->_createLockFile();
            return $results;
        }

        private function _createLockFile(): void
        {
            // création du fichier install.lock
            touch(ROOT . DS . 'install.lock');
        }

        /**
         */
        private function _isTablesMustBeCreated($bdd): bool
        {
            return !$bdd['notcreate'];
        }

        private function _createTables(): bool
        {
            // création des tables et enregistrement de l'utilisateur
            if (!$this->_generateTables()) {
                throw new InstallException(__('Erreur durant la création des tables'));
            }

            if (!$this->_createRights()) {
                throw new InstallException(__('Erreur durant la création des droits'));
            }

            return TRUE;
        }

        /**
         * Génére les tables nécessaires pour l'application
         * @return bool TRUE en cas de succès, FALSE si échec
         */
        private function _generateTables(): bool
        {
            return (new Migrations(['connection' => $this->connection]))->migrate(['plugin' => 'Wizardinstaller']);
        }

        /**
         * Création des droits dans la table droits
         * @return array|bool|ResultSet
         */
        private function _createRights(): ResultSet|bool|array
        {
            return (new Migrations(['connection' => $this->connection]))->seed(['plugin' => 'Wizardinstaller',
                                                                                'seed'   => 'RightsSeed']);
        }

        /**
         * Création du compte admin
         * @param $admin
         * @return bool
         */
        private function _createAdminAccount($admin): bool
        {

            /** @var GroupsTable $groupstable */
            $groupstable = TableRegistry::getTableLocator()
                                        ->get('UserManager.Groups');
            /** @var UsersTable $userstable */
            $userstable = TableRegistry::getTableLocator()
                                       ->get('UserManager.Users');
            $group = $groupstable->findOrCreate(['label' => 'ADMIN'], function ($entity) {
                $entity->description = __('Super-administrateurs de l\'application');
            });
            $user = $userstable->newEntity(['username'   => $admin['username'],
                                            'password'   => $admin['password'],
                                            'email'      => $admin['email'],
                                            'lastname'   => $admin['lastname'],
                                            'firstname'  => $admin['firstname'],
                                            'last_login' => date('now')], ['validate' => FALSE]);
            $user = $userstable->save($user);
            if ($user && $group) {
                $userstable->Groups->link($user, [$group]);
                $groupstable->Rights->link($group, [$user]);
                return TRUE;
            }
            return FALSE;
        }
    }
