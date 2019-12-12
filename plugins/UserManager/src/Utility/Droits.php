<?php

    namespace UserManager\Utility;

    class Droits
    {
        private static $user = NULL;
        private static $droits = NULL;

        /**
         * Vérifie la présence d'un droit dans les droits de l'utilisateur.
         * @param string $droit Le droit à vérifier
         * @param array $droitsUtilisateur Tableau contenant les droits de l'utilisateur connecté, facultatif, le tableau
         *                                  sera récupéré en session si omis
         * @return boolean TRUE si l'utilisateur a ce droit ou si il est administrateur, FALSE sinon
         */
        public static function aLeDroit($droit, $droitsUtilisateur = NULL)
        {
            return Droits::aUnDroit([$droit], $droitsUtilisateur);
        }

        /**
         * Vérifie la présence de droits dans les droits de l'utilisateur.
         * @param array $droitsRecherches Les droits à vérifier
         * @param array $droitsUtilisateur Tableau contenant les droits de l'utilisateur connecté, facultatif, le tableau
         *                                  sera récupéré en session si omis
         * @return boolean TRUE si l'utilisateur a un des droits à vérifier ou si il est administrateur, FALSE sinon
         */
        public static function aUnDroit($droitsRecherches, $droitsUtilisateur = NULL)
        {
            if (is_null($droitsUtilisateur)) {
                // si les droits utilisateurs spécifiés en paramètre sont vides, nous récupérons les droits en session s'ils existent
                if (!is_null(self::$droits)) {
                    // les droits existent en session
                    $droitsUtilisateur = self::$droits;
                } else {
                    // les droits n'existent pas en session
                    $droitsUtilisateur = [];
                }
            }

            array_push($droitsRecherches, 'ADMIN');

            return count(array_intersect($droitsUtilisateur, $droitsRecherches)) > 0 ? TRUE : FALSE;
        }

        /**
         * Indique si l'utilisateur connecté à les droits de super administrateur
         * @return bool
         */
        public static function isSuperAdmin()
        {
            return (self::$user['role'] == 'SUPERADMIN');
        }

        public static function getUser()
        {
            return self::$user;
        }

        public static function getDroits()
        {
            return self::$droits;
        }

        public static function setUser($user)
        {
            self::$user = $user;
        }

        public static function setDroits($droits)
        {
            self::$droits = $droits;
        }
    }

?>
