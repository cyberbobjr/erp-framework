<?php

    namespace BanksManager\Model\Table;

    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;

    /**
     * Class BanquesTable
     * @property \Cake\ORM\Association\BelongsTo $Societes
     * @property \Cake\ORM\Association\hasMany $Paiements
     * @package App\Model\Table
     */
    class BanksTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->belongsTo('Societes');
            $this->hasMany('Paiements');
            $this->setDisplayField('designation');
        }

        public function enregistre_paiement($paiement_id = NULL, $sens)
        {
            if (!is_null($paiement_id)) {
                // récupération des informations sur le paiement
                $paiements = TableRegistry::get('Paiements');
                $paiements = $paiements->find('all')
                                       ->where(['Paiements.id' => $paiement_id])
                                       ->contain(['Societes',
                                                  'Tiers',
                                                  'Banques'])
                                       ->first();
                // définition des variables
                $montant = $paiements->totalttc;
                // le sens du paiement de la banque est l'inverse
                if (empty($paiements->libelle)) {
                    $libelle = __('Paiement ') . $paiements->tier->nom_complet;
                } else {
                    $libelle = $paiements->libelle;
                }
                // récupération du compte de la banque
                $comptes = TableRegistry::get('Comptes');
                $compte_banque = $comptes->getCompteBanque($paiements->banque_id);
                $ecritures = TableRegistry::get('Ecritures');
                // lancement de l'écriture pour le compte tiers
                return $ecritures->genere_ecritures_paiements($paiement_id,
                    $compte_banque->id,
                    $libelle,
                    $montant,
                    $sens
                );
            }
        }
    }

    ?>