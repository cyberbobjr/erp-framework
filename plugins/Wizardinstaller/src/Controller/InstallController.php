<?php

    namespace Wizardinstaller\Controller;

    use Cake\Core\Configure;
    use Cake\Http\Response;
    use JsonException;
    use Wizardinstaller\Exceptions\InstallException;
    use Wizardinstaller\libs\CheckInstallService;
    use Wizardinstaller\libs\InstallService;

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
        public const ADMIN = 'admin';
        public const BDD = 'bdd';
        public const MAX_STEPS = 5;

        /**
         * Le fichier de configuration de la BDD doit être dans un fichier indépendant, ce qui permet de le générer lorsque
         * la BDD est validée
         * Une fois la configuration enregistrée, un fichier install.lock est créé.
         * C'est ce fichier install.lock qui est vérifié pour déterminer si l'application doit être installée ou est déjà
         * paramétrée
         * En supprimant le fichier install.lock l'utilisateur peut refaire une installation propre de GSO
         * @throws \Exception
         */

        public function step(InstallService $installService, $step = 1)
        {
            $this->viewBuilder()->setLayout('Wizardinstaller.default');
            if (file_exists(ROOT . DS . 'install.lock')) {
                throw new \RuntimeException(__('L\'installation a déjà été paramétrée, supprimez le fichier install.lock pour recommencer l\'installation.'));
            }
            if ($step > self::MAX_STEPS) {
                $this->Flash->error(__('Etape inconnue'));
                return $this->redirect(['action' => 'step', 1]);
            }

            /**
             * Si c'est un simple affichage de la page
             */
            if ($this->request->is('get')) {
                // en fonction de l'étape
                return $this->_displayStep($step, $installService);
            }
            /**
             * Si c'est une requête de passage à l'étape suivante
             */
            if ($this->request->is('post')) {
                return $this->_parseStep($step);
            }
        }

        /**
         * @throws JsonException
         */
        private function _displayStep($step, $installService)
        {
            switch ($step) {
                case 1 :
                    break;
                case 2 :
                    // gestion des informations de la bdd
                    $this->_readSession(self::BDD);
                    break;
                case 3 :
                    // gestion du compte administrateur
                    $this->_readSession(self::ADMIN);
                    break;
                case 4:
                    // vérification que les données en session soient bien présentes
                    if (!$this->_ready()) {
                        $this->Flash->error(__('Elements manquants, redirection vers la page principale de configuration'));
                        return $this->redirect(['action' => 'step', 1]);
                    }
                    $bdd = (object)$this->_readSession(self::BDD);
                    $admin = (object)$this->_readSession(self::ADMIN);
                    // récapitulatif des informations et sauvegarde définitive
                    $this->set(compact('bdd', 'admin'));
                    break;
                case 5:
                    $this->_executeInstallation($installService);
                    break;
            }
            $this->set('step', $step);
        }

        /**
         * @throws JsonException
         */
        private function _parseStep($step): ?Response
        {
            switch ($step) {
                case 1 :
                    // step1 : Informations et prérequis
                    break;
                case 2 :
                    // step2 : Renseignement url et BDD
                    // enregistrement de la configuration en session et passage au step suivant
                    $this->_saveInSession(self::BDD, $this->request->getData());
                    break;
                case 3:
                    // step3 : Renseignements admin/pwd
                    $this->_saveInSession(self::ADMIN, $this->request->getData());
                    // vérification de la conformité du mot de passe
                    if (!$this->_isPasswordCorrect()) {
                        $this->Flash->error(__('Les mots de passe ne correspondent pas'));
                        return $this->redirect(['action' => 'step', $step]);
                    }
                    break;
                case 4:
                    // step4 : finalisation de l'installation
                    // vérification que les données en session soient bien présentes
                    if (!$this->_ready()) {
                        $this->Flash->error(__('Elements manquants, redirection vers la page principale de configuration'));
                        return $this->redirect(['action' => 'step', 1]);
                    }
                    // enregistrement de la configuration
                    if (!$this->_saveConfig()) {
                        $this->Flash->error(__('Erreur lors de l\'enregistrement de la configuration'));
                        return $this->redirect(['action' => 'step', 4]);
                    }
                    $this->Flash->success(__('Configuration enregistrée'));
                    // la configuration s'est bien enregistrée, nous allons pouvoir créer les tables de l'application
                    return $this->redirect(['action' => 'step', 5]);
                    break;
            }
            // redirection vers l'étape suivante
            $step = $this->getStep();
            return $this->redirect(['action' => 'step', $step]);
        }

        /**
         * Récupération les informations en session
         * @param string $index Nom de la clef à récupérer en session
         * @throws JsonException
         */
        private function _readSession(string $index)
        {
            $data = NULL;
            if (!is_null($this->request->getSession()
                                       ->read($index))) {
                $data = json_decode($this->request->getSession()
                                                  ->read($index), TRUE, 512, JSON_THROW_ON_ERROR);
                $this->request = $this->request->withParsedBody($data);
            }
            return $data;
        }

        /**
         * @throws JsonException
         */
        private function _ready(): bool
        {
            return ($this->_readSession(self::ADMIN) !== NULL) && ($this->_readSession(self::BDD) !== NULL);
        }

        /**
         * @throws JsonException
         */
        private function _executeInstallation(InstallService $installService): void
        {
            $valid = FALSE;
            try {
                $results = $installService->execute($this->_readSession(self::ADMIN), $this->_readSession(self::BDD));
                foreach ($results as $result) {
                    $this->Flash->success($result);
                }
                $valid = TRUE;
            } catch (InstallException $ex) {
                $this->Flash->error($ex->getMessage());
            }
            $this->set('valid', $valid);
        }

        /**
         * Sauvegarde les informations en session
         * @param string $index Nom de la clef à utiliser pour la session
         * @param array  $data Tableau à sauvegarder
         * @throws JsonException
         */
        private function _saveInSession(string $index, $data): void
        {
            $this->request->getSession()
                          ->write($index, json_encode($data, JSON_THROW_ON_ERROR));
        }

        /**
         * Vérifie que le mot de passe est identique à la confirmation du mot de passe
         * @TODO refactoriser dans une lib à part
         * @return bool
         */
        private function _isPasswordCorrect(): bool
        {
            return ($this->request->getData('password') === $this->request->getData('confirmpassword'));
        }

        /**
         * Enregistre la configuration
         * @throws JsonException
         */
        private function _saveConfig(): bool
        {
            // paramétrage de la datasource
            $this->_configureDatasource();
            $this->_generateClef();
            return $this->_dumpConfig();
        }

        private function _dumpConfig(): bool
        {
            return Configure::dump('app_config', 'default', ['Security', 'Datasources']);
        }

        public function checkBdd(CheckInstallService $checkInstallService)
        {
            $host = $this->request->getData('host');
            $port = $this->request->getData('port', 3306);
            $username = $this->request->getData('username');
            $pwd = $this->request->getData('password');
            $bdd = $this->request->getData('database');
            $result = $checkInstallService->checkBdd($host, $port, $username, $pwd, $bdd);
            $this->set('result', $result);
            $this->viewBuilder()
                 ->setOption('serialize', ['result'])
                 ->setOption('jsonOptions', JSON_FORCE_OBJECT);
        }

        /**
         * Génére le fichier de configuration Bdd
         * @throws JsonException
         */
        private function _configureDatasource(): void
        {
            $bdd = json_decode($this->request->getSession()
                                             ->read(self::BDD), TRUE, 512, JSON_THROW_ON_ERROR);
            $bdd['className'] = 'Cake\Database\Connection';
            $bdd['driver'] = 'Cake\Database\Driver\Mysql';
            $bdd['persistent'] = FALSE;
            $bdd['encoding'] = 'utf8';
            $bdd['timezone'] = 'UTC';
            $bdd['cacheMetadata'] = TRUE;
            unset($bdd['clef'], $bdd['step3'], $bdd['notcreate']);
            $testbdd = $bdd;
            $testbdd['database'] = 'test_' . $bdd['database'];
            Configure::write('Datasources.test', $testbdd);
            Configure::write('Datasources.default', $bdd);
        }

        /**
         * Génére le fichier de configuration pour la clef de sécurité
         * @throws JsonException
         */
        private function _generateClef(): void
        {
            $bdd = json_decode($this->request->getSession()
                                             ->read(self::BDD), TRUE, 512, JSON_THROW_ON_ERROR);
            Configure::write('Security.salt', $bdd['clef']);
        }

        /**
         * Retourne l'étape demandée
         * @return int Numéro de l'étape
         */
        private function getStep(): int
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
    }
