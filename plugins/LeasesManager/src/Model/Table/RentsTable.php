<?php

    namespace LeasesManager\Model\Table;

    use Cake\ORM\Table;

    /**
     * Class LoyersTable
     * @property \Cake\ORM\Association\BelongsTo $Bails
     * @property \Cake\ORM\Association\hasMany $Loyerdetails
     * @package App\Model\Table
     */
    class RentsTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->belongsTo('Bails');
            $this->hasMany('Loyerdetails', ['dependent'    => TRUE,
                                            'saveStrategy' => 'replace']);
        }

        public function get_loyers($bail_id)
        {
            // récupération des informations du bail
            return $this->Loyerdetails->find('all')
                                      ->contain('Loyers')
                                      ->where(['Loyers.bail_id' => $bail_id])
                                      ->select(['type_operation_id',
                                                'libelle',
                                                'montant_ht',
                                                'montant_ttc',
                                                'montant_tva',
                                                'tva_id']);
        }

        /**
         * Retourne le total ht, ttc et tva d'un loyer dont le bail est spécifié en paramètre
         * @param int $bail_id Référence du bail dont nous voulons les totaux
         * @return Entity Résultat de la requête
         */
        public function get_total($bail_id)
        {
            $query = $this->Loyerdetails->find('all')
                                        ->contain('Loyers')
                                        ->where(['Loyers.bail_id' => $bail_id]);
            $query = $query->select(['total_ttc' => $query->func()
                                                          ->sum('montant_ttc'),
                                     'total_ht'  => $query->func()
                                                          ->sum('montant_ht'),
                                     'total_tva' => $query->func()
                                                          ->sum('montant_tva'),]);
            return $query->first();
        }
    }

    ?>