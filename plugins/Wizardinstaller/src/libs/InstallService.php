<?php

    namespace Wizardinstaller\libs;

    use Cake\Core\Exception\Exception;
    use Cake\Datasource\ConnectionManager;

    class InstallService
    {
        public function checkBdd($host, $port, $username, $pwd, $bdd): array
        {
            // si l'un des paramètres est vide, erreur
            if ($this->isValidBddInfo($host, $port, $username, $pwd, $bdd)) {
                return ['success' => FALSE,
                        'msg'     => __('Les informations ne sont pas complètes')];
            }
            // paramètres non vide, nous testons la configuration
            if ($this->_checkBdd($host, $username, $pwd, $bdd)) {
                return ['success' => TRUE,
                        'msg'     => __('Connexion réussie')];
            }

            return ['success' => FALSE,
                    'msg'     => __('Les informations saisies ne sont pas correctes, erreur de connexion')];;
        }

        private function isValidBddInfo($host, $port, $username, $pwd, $bdd): bool
        {
            return is_null($host) || is_null($username) || is_null($pwd) || is_null($bdd) || is_null($port);
        }

        /**
         * Fonction de vérification des informations de connexion à la BDD
         * @param string $host Adresse du serveur MySQL
         * @param string $username Login du serveur MySQL
         * @param string $pwd Mot du passe du serveur
         * @param string $bdd Nom de la base de donnée
         * @return bool TRUE si connexion réussie, FALSE sinon
         */
        private function _checkBdd(string $host, string $username, string $pwd, string $bdd): bool
        {
            ConnectionManager::setConfig('testerp', [
                'className'        => 'Cake\Database\Connection',
                'driver'           => 'Cake\Database\Driver\Mysql',
                'persistent'       => TRUE,
                'host'             => $host,
                'username'         => $username,
                'password'         => $pwd,
                'database'         => $bdd,
                'encoding'         => 'utf8',
                'timezone'         => 'UTC',
                'cacheMetadata'    => TRUE,
                'quoteIdentifiers' => FALSE,
                'log'              => TRUE,]);
            try {
                $connection = ConnectionManager::get('testerp');
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