<?php

    namespace App\Model\Behavior;

    use Cake\ORM\Behavior;
    use Cake\ORM\Query;
    use Cake\ORM\TableRegistry;

    /**
     * Search behavior
     */
    class SearchBehavior extends Behavior
    {
        /**
         * Default configuration.
         *
         * @var array
         */
        protected $_defaultConfig = [];
        private $_paginatorQuery = ['limit',
                                    'page',
                                    'offset',
                                    'where',
                                    '_table',
                                    'method'];

        /**
         * Recherche un produit à partir de champs passés en paramètre
         * Les champs à rechercher est dans $_QUERY "fields"
         * Le filtre est encodé en JSON dans $_QUERY "filter"
         * Le terme à rechercher est dans la $_QUERY "q"
         * @param Query $query
         * @param array $options
         * @return Query
         */
        public function findSearch(Query $query, array $options)
        {
            $param = $options['query'];
            $groupBy = [];
            // récupération des champs à utiliser pour la recherche
            $fields = $param['fields'];
            // récupération du filtre de recherche
            if (isset($param['filter'])) {
                // filtre vide par défaut
                $filters = ($param['filter']);
                // contruction du filtre de recherche
                foreach ($filters as $field => $value) {
                    $andSearch[h($field)] = $value;
                }
            }
            // récupération du terme de recherche
            $term = $param['q'];
            // tableau du critère de la recherche
            $search = [];
            // tableau du critère supplémentaire de recherche
            $andSearch = [];
            // construction de la chaine de recherche
            foreach ($fields as $field) {
                $search[$this->getTable()
                             ->getAlias() . '.' . h($field) . ' LIKE'] = '%' . $term . '%';
                $groupBy[] = $field;
            }
            return $query->where(['OR' => $search])
                         ->andWhere($andSearch)
                         ->group($groupBy);
        }

        /**
         * Recherche un enregistrement en se basant sur le filtre passé en paramètre
         * Le format du filtre est un objet JSON indexé par tables :
         * {
         *      "Table" :   [
         *                      {"Field" : "Valeur cherchée"}
         *                  ]
         * }
         * @param Query $query
         * @param array $options
         * @return Query
         */
        public function findFilter(Query $query, array $options)
        {
            $contain = [];
            $currentAliasName = $this->getTable()
                                     ->getAlias();
            if (!isset($options['query']) || count($options['query']) == 0) {
                return $query;
            }
            $filters = isset($options['query']['filter']) ? $options['query']['filter'] : [];
            if (isset($options['query']['include'])) {
                $include = $options['query']['include'];
                $contain = (is_array($include)) ? $include : json_decode($include);
            }

            $method = isset($options['query']['method']) ? $options['query']['method'] : 'andWhere';

            if (!is_array($contain)) {
                $contain = [$contain];
            }
            // nettoyage des valeurs vides
            $tables = $this->_cleanQuery($filters);

            foreach ($tables as $table => $fields) {
                // parcours des tables à filtrer
                if ($currentAliasName !== $table) {
                    // si ce n'est pas la table courante, nous nous assurons que la table demandée est bien liée
                    $associations = $this->getTable()
                                         ->associations();
                    if ($associations->has($table)) {
                        // l'association existe, nous rajoutons un filtre matching sur cette association
                        $query = $query->matching($table, function (Query $q) use ($table, $fields, $method) {
                            $q = $this->_buildQuery($q, $table, $fields, $method);
                            return $q;
                        });
                        $contain[] = $table;
                    }
                } else {
                    $query = $this->_buildQuery($query, $table, $fields, $method);
                }
            }
            $contain = array_unique($contain);
            if (($key = array_search($currentAliasName, $contain)) !== FALSE) {
                unset($contain[$key]);
            }
            $query = $this->_getAssociated($query, $contain);
            return $query;

        }

        /**
         * Nettoie la query en supprimant les clefs avec des valeurs vides
         * @param array $queries
         * @return array
         */
        private function _cleanQuery(Array $queries)
        {
            $queryClean = [];
            foreach ($queries as $table => $fields) {
                if (!is_array($fields) && in_array($table, $this->_paginatorQuery)) {
                    continue;
                }
                if (!is_array($fields)) {
                    $queryClean[($this->getTable())->getAlias()][$table] = $fields;
                } else {
                    foreach ($fields as $field => $value) {
                        if (!empty($value)) {
                            $queryClean[$table][$field] = $value;
                        }
                    }
                }
            }
            return $queryClean;
        }

        private function _buildQuery(Query $query, $tableName, $fields, $where)
        {
            $tableSchema = TableRegistry::get($tableName);
            $schema = $tableSchema->getSchema();
            foreach ($fields as $field => $values) {
                if (is_array($values)) {
                    foreach ($values as $value) {
                        $query->orWhere($this->_buildQueryColumn($schema->baseColumnType($field), $tableName, $field,
                            $value));
                    }
                } else {
                    $query->$where($this->_buildQueryColumn($schema->baseColumnType($field), $tableName, $field, $values));
                }
            }
            return $query;
        }

        private function _getAssociated($query, $contains)
        {
            if (count($contains) > 0) {
                $query = $query->contain($contains);
            }
            return $query;
        }

        private function _buildQueryColumn($type, $tableName, $field, $value)
        {
            switch ($type) {
                case 'integer':
                    return [$tableName . '.' . $field => $value];
                default :
                    return [$tableName . '.' . $field . ' LIKE ' => '%' . $value . '%'];
            }
        }
    }
