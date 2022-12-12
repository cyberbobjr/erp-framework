<?php

    namespace UserManager\Controller;

    use Cake\Datasource\Exception\RecordNotFoundException;
    use Cake\Network\Response;
    use UserManager\Model\Table\RightsTable;

    /**
     * Rights Controller
     *
     * @property RightsTable $Rights
     */
    class RightsController extends AppController
    {

        /**
         * Index method
         *
         * @return Response|null
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
         * @return Response|null
         * @throws RecordNotFoundException When record not found.
         */
        public function view($id = NULL)
        {
            $droit = $this->Rights->get($id, ['contain' => ['Groups']]);

            $this->set('right', $droit);
            $this->set('_serialize', ['right']);
        }

        /**
         * Add method
         * @param string|null $id Droit id.
         * @return Response|void Redirects on successful add, renders view otherwise.
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
         * @return Response|null Redirects to index.
         * @throws RecordNotFoundException When record not found.
         */
        public function delete($id = NULL)
        {
            $this->Flash->error(__('Vous ne pouvez pas supprimer de droits'));
            return $this->redirect(['action' => 'index']);
        }
    }
