<?php

    namespace UserManager\Model\Entity;

    use Cake\Auth\DefaultPasswordHasher;
    use Cake\I18n\FrozenTime;
    use Cake\ORM\Entity;

    /**
     * User Entity.
     *
     * @property int $id
     * @property string $username
     * @property string $fullname
     * @property string $password
     * @property string $email
     * @property string|null $role
     * @property bool $active
     * @property string $apikey
     * @property string $adresse_complete
     * @property bool $is_first_login
     * @property string|null $avatar
     * @property FrozenTime|null $last_login
     * @property FrozenTime $created
     * @property FrozenTime $modified
     * @property string|null $firstname
     * @property string|null $lastname
     * @property string|null $civ
     * @property string|null $sex
     * @property string|null $badge
     * @property string|null $phonenumber
     * @property string|null $uuid
     * @property string|null $address
     * @property string|null $address1
     * @property string|null $zipcode
     * @property string|null $city
     * @property float|null $lat
     * @property float|null $lng
     * @property string|null $profile
     * @property string|null $profile_path
     * @property string|null $access_token
     * @property int|null $social_type
     * @property string|null $stripe
     * @property string|null $ip
     * @property bool|null $archive
     * @property Group[] $groups
     */
    class User extends Entity
    {

        /**
         * Fields that can be mass assigned using newEntity() or patchEntity().
         *
         * Note that when '*' is set to true, this allows all unspecified fields to
         * be mass assigned. For security purposes, it is advised to set '*' to false
         * (or remove it), and explicitly make individual fields accessible as needed.
         *
         * @var array
         */
        protected $_accessible = ['*'  => TRUE,
                                  'id' => FALSE];

        protected $_hidden = ['password',
                              'access_token'];

        public function cryptPassword($password)
        {
            return (new DefaultPasswordHasher)->hash($password);
        }

        protected function _setPassword($password)
        {
            return $this->cryptPassword($password);
        }

        /**
         * Retourne un champ virtuel contenant l'adresse complète d'un utilisateur
         * @return string
         */
        protected function _getAdresseComplete()
        {
            return $this->_properties['address'] . ' / ' . $this->_properties['zipcode'] . ' ' . $this->_properties['city'];
        }
    }
