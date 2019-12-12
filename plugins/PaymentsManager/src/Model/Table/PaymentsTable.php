<?php

    namespace PaymentsManager\Model\Table;

    use Cake\ORM\Table;

    /**
     * Le champ "sens" détermine le sens du paiement
     * 1 = du tiers vers la société
     * 2 = de la société vers le tiers
     * Class PaiementsTable
     * @package App\Model\Table
     */
    class PaymentsTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->belongsTo('TiersManager.Tiers');
            $this->belongsTo('BanksManager.Banks');
            $this->belongsTo('CompaniesManager.Companies');
            $this->belongsTo('TypePayments');
            $this->hasMany('Ecritures', ['foreignKey' => 'ref_id',
                                         'conditions' => ['type_ecriture_id' => 2],
                                         // 2 = code paiement
                                         'dependent'  => TRUE]);
        }
    }

    ?>