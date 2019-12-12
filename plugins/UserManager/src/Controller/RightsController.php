<?php

    namespace UserManager\Controller;

    /**
     * Rights Controller
     *
     * @property \UserManager\Model\Table\RightsTable $Rights
     */
    class RightsController extends AppController
    {

        /**
         * Index method
         *
         * @return \Cake\Network\Response|null
         */
        public function index()
        {
            $rights = $this->Rights->find()
                                   ->order(['code' => 'ASC']);

            $this->set(compact('rights'));
            $this->set('_serialize', ['rights']);
        }

        /**
         * View method
         *
         * @param string|null $id Droit id.
         * @return \Cake\Network\Response|null
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function view($id = NULL)
        {
            $droit = $this->Rights->get($id, ['contain' => ['Groupes']]);

            $this->set('right', $droit);
            $this->set('_serialize', ['right']);
        }

        /**
         * Add method
         * @param string|null $id Droit id.
         * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
         */
        public function add($id = NULL)
        {
            $this->Flash->error(__('Vous ne pouvez pas ajouter de droits'));
            return $this->redirect(['action' => 'index']);
        }

        /**
         * Delete method
         *
         * @param string|null $id Droit id.
         * @return \Cake\Network\Response|null Redirects to index.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function delete($id = NULL)
        {
            $this->Flash->error(__('Vous ne pouvez pas supprimer de droits'));
            return $this->redirect(['action' => 'index']);
        }
    }
