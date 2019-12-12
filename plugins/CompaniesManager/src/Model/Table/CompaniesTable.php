<?php

    namespace CompaniesManager\Model\Table;

    use Cake\Collection\Collection;
    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;

    class CompaniesTable extends Table
    {
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->hasMany('OperationsManager.Operations');
            $this->hasMany('PropertiesManager.Properties');
            $this->hasMany('BankManager.banks');
            $this->hasMany('LeasesManager.Leases');
            $this->hasMany('Accountings.accounts');
            $this->hasMany('PaymentsManager.Payments');
            $this->setDisplayField('raison_sociale');
            $this->setTable('companies');
        }

        public function canDelete()
        {
            return TRUE;
        }

        /**
         * Enregistre une opération pour la société
         * @param int $operation_id référence de l'opération à enregistrer
         * @param int $societe_id référence de la société concernée
         */
        public function enregistre_operation($operation_id)
        {
            // récupération de l'opération
            $operations = TableRegistry::get('Operations');
            $operation = $operations->get($operation_id, [
                'contain' => [
                    'TypeOperations',
                    'DetailOperations',
                    'Societes',
                    'DetailOperations.TypeOperations'
                ]
            ]);
            // récupération des informations de l'opération
            $societe_id = $operation->societe_id;
            foreach ($operation['detail_operations'] as $detailoperation) {
                $this->enregistre_detail_operation($operation, $detailoperation, $societe_id);
            }
        }

        /**
         * Enregistre le détail d'une opération pour une société,
         * cela génère une écriture pour la société et si la société est soumise à la TVA enregistre une écriture
         * sur le compte de TVA
         * @param $operation
         * @param $detailoperation
         * @param $societe_id
         */
        public function enregistre_detail_operation($operation, $detailoperation, $societe_id)
        {
            $societe = $this->get($societe_id);
            $comptes = TableRegistry::get('Comptes');
            $ecritures = TableRegistry::get('Ecritures');
            $plan_id = $detailoperation->type_operation->plan_id;
            $sens_societe = $detailoperation->type_operation->sens_societe;
            $tva = $societe->tva;
            if (!empty($detailoperation->libelle)) {
                $libelle = $detailoperation->libelle;
            } else {
                $libelle = $operation->libelle;
            }
            // on s'assure que la société possède bien un compte correspondant au plan
            $compte = $comptes->findOrCreateSociete($societe_id, $plan_id);
            // on génère l'écriture sur le compte associé à la société
            // si la société est soumis à TVA, le revenu HT en enregistré dans les comptes
            if ($tva) {
                $montant = $detailoperation->montant_ht;
                $montant_tva = $detailoperation->montant_tva;
                // le sens_societe détermine si c'est une charge ou un produit
                // 1 = charge
                // 2 = produits
                if ($sens_societe == 1) {
                    // si le sens est au débit (compte de charge), alors la TVA est déduite
                    $comptetva = $comptes->getCompteDeductionTVA($societe_id);
                    $libelletva = $libelle . ' - TVA déduite';
                } else {
                    // si le sens est au crédit (compte de résultat) alors la TVA est collectée
                    $comptetva = $comptes->getCompteCollecteTVA($societe_id);
                    $libelletva = $libelle . ' - TVA collectée';
                }
                // et la part de TVA est placée dans le bon compte (TVA collectée ou déductible)
                $ecriture_tva = $ecritures->genere_ecritures_operations($operation->id,
                    $comptetva->id,
                    $libelletva,
                    $montant_tva,
                    $sens_societe
                );

            } else {
                $montant = $detailoperation->montant_ttc;
            }
            $ecriture_societe = $ecritures->genere_ecritures_operations($operation->id,
                $compte->id,
                $libelle,
                $montant,
                $sens_societe
            );
        }

        /**
         * Extraction de l'ensemble des écritures du compte de charge
         * @param $societe_id
         */
        public function calcul_compte_charge($societe_id)
        {
            $result = [];
            $ecritures = TableRegistry::get('Ecritures');
            // récupération des comptes de produits pour la société
            // récupération de toutes les écritures ayant pour référence de compte un des comptes ci-dessus
            $comptes = TableRegistry::get('Comptes');
            $plans = TableRegistry::get('Plancomptas');
            // on ajoute au résultat le compte parent principal
            $plan7 = $plans->get(6);
            $result[] = [
                'id'        => 6,
                '_parentId' => NULL,
                'libelle'   => $plan7->name
            ];
            // On récupère tous les comptes produits déclarés pour la société
            $comptesproduits = $comptes->getComptesCharges($societe_id);
            // on combine les comptes produits pour les indéxer par numéro de plan
            $comptesproduits = new Collection($comptesproduits);
            $comptesproduits = $comptesproduits->groupBy('plan_id')
                                               ->toArray();
            // on parcours l'arbre et on construit le tableau de résultat
            $plans = $plans->find('children', ['for' => 6]);
            foreach ($plans as $plan) {
                $result[] = [
                    'id'        => $plan->id,
                    '_parentId' => $plan->parent_id,
                    'libelle'   => $plan->name,
                ];
                if (isset($comptesproduits[$plan->id])) {
                    foreach ($comptesproduits[$plan->id] as $compteproduit) {
                        // récupération de la somme des écritures pour ce compte
                        $ecriture = $ecritures->getSoldeCompte($compteproduit->id);
                        $result[] = [
                            'id'        => $compteproduit->numero,
                            '_parentId' => $plan->id,
                            'libelle'   => $compteproduit->libelle,
                            'montant'   => $ecriture->sumdebit,
                        ];
                    }
                }
            }
            return $result;
        }

        public function calcul_compte_produit($societe_id)
        {
            $result = [];
            $ecritures = TableRegistry::get('Ecritures');
            // récupération des comptes de produits pour la société
            // récupération de toutes les écritures ayant pour référence de compte un des comptes ci-dessus
            $comptes = TableRegistry::get('Comptes');
            $plans = TableRegistry::get('Plancomptas');
            // on ajoute au résultat le compte parent principal
            $plan7 = $plans->get(7);
            $result[] = [
                'id'        => 7,
                '_parentId' => NULL,
                'libelle'   => $plan7->name
            ];
            // On récupère tous les comptes produits déclarés pour la société
            $comptesproduits = $comptes->getComptesProduits($societe_id);
            // on combine les comptes produits pour les indéxer par numéro de plan
            $comptesproduits = new Collection($comptesproduits);
            $comptesproduits = $comptesproduits->groupBy('plan_id')
                                               ->toArray();
            // on parcours l'arbre et on construit le tableau de résultat
            $plans = $plans->find('children', ['for' => 7]);
            foreach ($plans as $plan) {
                $result[] = [
                    'id'        => $plan->id,
                    '_parentId' => $plan->parent_id,
                    'libelle'   => $plan->name,
                ];
                if (isset($comptesproduits[$plan->id])) {
                    foreach ($comptesproduits[$plan->id] as $compteproduit) {
                        // récupération de la somme des écritures pour ce compte
                        $ecriture = $ecritures->getSoldeCompte($compteproduit->id);
                        $result[] = [
                            'id'        => $compteproduit->numero,
                            '_parentId' => $plan->id,
                            'libelle'   => $compteproduit->libelle,
                            'montant'   => $ecriture->sumcredit,
                        ];
                    }
                }
            }
            return $result;
        }

        public function sum_compte_produit($societe_id, $annee = NULL)
        {
            $comptes = TableRegistry::get('Comptes');
            $ecritures = TableRegistry::get('Ecritures');
            // on ajoute au résultat le compte parent principal
            // On récupère tous les comptes produits déclarés pour la société
            $comptesproduits = $comptes->getComptesProduits($societe_id);
            $comptesproduits = new Collection($comptesproduits);
            $comptesproduits = $comptesproduits->extract('id')
                                               ->toArray();
            $ecriture = $ecritures->getSumCompte($comptesproduits, $annee);
            $result = [
                'id'      => 'Total Produits',
                'libelle' => '',
                'montant' => $ecriture->sumcredit,
                'iconCls' => 'icon-sum'
            ];
            return $result;
        }

        public function sum_compte_charge($societe_id, $annee = NULL)
        {
            $comptes = TableRegistry::get('Comptes');
            $ecritures = TableRegistry::get('Ecritures');
            // On récupère tous les comptes produits déclarés pour la société
            $comptesproduits = $comptes->getComptesCharges($societe_id);
            $comptesproduits = new Collection($comptesproduits);
            $comptesproduits = $comptesproduits->extract('id')
                                               ->toArray();
            $ecriture = $ecritures->getSumCompte($comptesproduits, $annee);
            $result = [/*'id'      => 0,*/
                       'id'      => 'Total Charges',
                       'libelle' => '',
                       'montant' => $ecriture->sumdebit,
                       'iconCls' => 'icon-sum'
            ];
            return $result;
        }
    }

    ?>
