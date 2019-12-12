<?php

    namespace TiersManager\Model\Table;

    use Cake\ORM\Query;
    use Cake\ORM\Table;

    class TiersTable extends Table
    {
        /**
         * Fonction d'initialisation de la table
         * @param  array  $config
         */
        public function initialize(array $config)
        {
            $this->addBehavior('Timestamp');
            $this->belongsTo('TiersManager.TypeTiers');
            $this->setTable('Tiers');
        }

        public function findClients(Query $query, array $options)
        {
            $query->where([
                'type_tier_id' => 1,
            ]);
            return $query;
        }

        public function findFournisseurs(Query $query, array $options)
        {
            $query->where([
                'type_tier_id' => 2,
            ]);
            return $query;
        }

        /**
         * Indique si un type de tiers existe
         * @param $typetiers
         * @return bool
         */
        public function isTypeTierExist($typetiers)
        {
            return $this->exists(['type_tiers_id' => $typetiers]);
        }

        /**
         * Vérification si un tiers peut être supprimé
         * La vérification s'effectue si le compte associé au tiers n'est pas soldé (c'est à dire que le crédit = débit)
         * @param $id
         * @return bool
         */
        public function canDelete($id)
        {
            return TRUE;
        }

    }

?>
