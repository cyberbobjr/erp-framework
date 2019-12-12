<?php

    namespace TiersManager\Controller;

    use TiersManager\Model\Table\CustomersTable;

    /**
     * Clients Controller
     *
     * @property CustomersTable $Customers
     *
     * @method \App\Model\Entity\Customer[] paginate($object = NULL, array $settings = [])
     */
    class CustomersController extends AppController
    {
        public function isAuthorized($user): bool
        {
            // Les compteurs utilisateurs ayant le rôle d'administrateur ont tous les droits
            return ($user) ? TRUE : FALSE;
        }

        /**
         * Index method
         *
         * @return \Cake\Http\Response|void
         */
        public function index()
        {
            $customers = $this->Customers->find();
            $this->set(compact('customers'));
            $this->set('_serialize', ['customers']);
        }

        /**
         * View method
         *
         * @param  string|null  $id  Client id.
         * @return \Cake\Http\Response|void
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function view($id = NULL)
        {
            $customer = $this->Customers->get($id, ['contain' => ['TypeTiers']]);

            $this->set('customer', $customer);
            $this->set('_serialize', ['customer']);
        }

        /**
         * Add method
         *
         * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
         */
        public function add()
        {
            $customer = $this->Customers->newEntity();
            if ($this->request->is('post')) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData());
                if ($this->Customers->save($customer)) {
                    $this->Flash->success(__('Le client a été créé.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Erreur pendant la création du client, veuillez recommencer s\'il vous plait.'));
            }
            $this->set(compact('customer'));
            $this->set('_serialize', ['customer']);
        }

        /**
         * Edit method
         *
         * @param  string|null  $id  Client id.
         * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
         * @throws \Cake\Network\Exception\NotFoundException When record not found.
         */
        public function edit($id = NULL)
        {
            $customer = $this->Customers->get($id);
            if ($this->request->is(['patch',
                                    'post',
                                    'put'])
            ) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData());
                if ($this->Customers->save($customer)) {
                    $this->Flash->success(__('The customer has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The customer could not be saved. Please, try again.'));
            }
            $typeTiers = $this->Customers->TypeTiers->find('list', ['limit' => 200]);
            $this->set(compact('customer', 'typeTiers'));
            $this->set('_serialize', ['customer']);
        }

        /**
         * Delete method
         *
         * @param  string|null  $id  Client id.
         * @return \Cake\Http\Response|null Redirects to index.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function delete($id = NULL)
        {
            $this->request->allowMethod(['post',
                                         'delete']);
            $customer = $this->Customers->get($id);
            if ($this->Customers->delete($customer)) {
                $this->Flash->success(__('The customer has been deleted.'));
            } else {
                $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        }
    }
