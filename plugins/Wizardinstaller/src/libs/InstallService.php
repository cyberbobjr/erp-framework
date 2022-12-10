<?php

    namespace Wizardinstaller\libs;

    use Cake\ORM\ResultSet;
    use Cake\ORM\TableRegistry;
    use Migrations\Migrations;
    use UserManager\Model\Table\GroupesTable;
    use UserManager\Model\Table\UsersTable;
    use Wizardinstaller\Exceptions\InstallException;

    class InstallService
    {
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
            // création du fichier install.lock
            touch(ROOT . DS . 'install.lock');
            return $results;
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
            return (new Migrations())->migrate(['plugin' => 'Wizardinstaller']);
        }

        /**
         * Création des droits dans la table droits
         * @return array|bool|ResultSet
         */
        private function _createRights(): ResultSet|bool|array
        {
            return (new Migrations())->seed(['seed' => 'RightsSeed']);
        }

        /**
         * Création du compte admin
         * @param $admin
         * @return bool
         */
        private function _createAdminAccount($admin): bool
        {

            /** @var GroupesTable $groupestable */
            $groupestable = TableRegistry::getTableLocator()
                                         ->get('UserManager.Groupes');
            /** @var UsersTable $userstable */
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
    }
