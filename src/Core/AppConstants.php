<?php

    namespace App\Core;

    use Cake\Core\Configure;
    use Cake\Network\Session;
    use UserManager\Utility\Droits;

    /**
     * Class sci
     * @package App
     */
    class AppConstants
    {
        const STRIPE_SERVER_KEY = "sk_test_fsQIDfD1Pg49PYXgxhZaWz3c";
        const STRIPE_PUB_KEY = "pk_test_juPrIz1fUlaOQiP2mVEoZnh0";

        // constantes des plans disponibles
        const PLAN_LIGHT = 1;
        const PLAN_BASIC = 2;
        const PLAN_PREMIUM = 3;

        // constantes des types de tiers
        const CUSTOMER = 1;
        const SUPPLIER = 2;

        //@deprecated constantes état opération (old state)
        const TYPE_PAYE = 1;
        const TYPE_ABANDONNE_PARTIEL = 2;
        const TYPE_IMPAYE = 3;
        const TYPE_BROUILLON = 5;
        const TYPE_REGLEMENT_PARTIEL = 6;
        const TYPE_ABANDONNE = 7;

        // constantes pour déterminer les types de documents
        const DOC_APPEL = 0;
        const DOC_QUITTANCE = 1;

        // constantes des types d'évenements possibles
        const EVENT_FIN_BAIL = 1;
        const EVENT_ECHEANCE_CLIENT = 2;

        public static function setSessionForTest()
        {
            $user = ['id'         => 1,
                     'profile'    => '',
                     'fullname' => 'Benjamin Marchand',
                     'username'   => 'bmarchand',
                     'firstname'     => 'Benjamin',
                     'lastname'        => 'Marchand'];
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $data = ['rights' => ['ADMIN'],
                     'Auth'   => ['User' => $user]];
            Droits::setUser($user);
            Droits::setDroits(['ADMIN']);
            $sessionConfig = (array)Configure::read('Session') + ['defaults' => 'php',];
            $session = Session::create($sessionConfig);
            $_SESSION = $data;
            $session->write($data);
        }

        public static function writeFile($data, $file = "debug_test.html")
        {
            $handle = fopen($file, 'w');
            fwrite($handle, $data);
        }

    }
