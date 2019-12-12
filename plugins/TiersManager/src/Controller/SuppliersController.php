<?php

namespace TiersManager\Controller;

use App\Model\Table\SuppliersTable;

/**
 * Fournisseurs Controller
 *
 * @property SuppliersTable $Fournisseurs
 * @method \App\Model\Entity\Fournisseur[] paginate($object = NULL, array $settings = [])
 */
class SuppliersController extends AppController
{
    public function isAuthorized($user)
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
        $clients = $this->Fournisseurs->find()
                                      ->contain(['TypeTiers']);

        $this->set(compact('clients'));
        $this->set('_serialize', ['clients']);
    }

    /**
     * View method
     *
     * @param string|null $id Fournisseur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = NULL)
    {
        $fournisseur = $this->Fournisseurs->get($id, ['contain' => []]);

        $this->set('fournisseur', $fournisseur);
        $this->set('_serialize', ['fournisseur']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fournisseur = $this->Fournisseurs->newEntity();
        if ($this->request->is('post')) {
            $fournisseur = $this->Fournisseurs->patchEntity($fournisseur, $this->request->getData());
            if ($this->Fournisseurs->save($fournisseur)) {
                $this->Flash->success(__('The fournisseur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fournisseur could not be saved. Please, try again.'));
        }
        $this->set(compact('fournisseur'));
        $this->set('_serialize', ['fournisseur']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Fournisseur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = NULL)
    {
        $fournisseur = $this->Fournisseurs->get($id, ['contain' => []]);
        if ($this->request->is(['patch',
                                'post',
                                'put'])) {
            $fournisseur = $this->Fournisseurs->patchEntity($fournisseur, $this->request->getData());
            if ($this->Fournisseurs->save($fournisseur)) {
                $this->Flash->success(__('The fournisseur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fournisseur could not be saved. Please, try again.'));
        }
        $this->set(compact('fournisseur'));
        $this->set('_serialize', ['fournisseur']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Fournisseur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = NULL)
    {
        $this->request->allowMethod(['post',
                                     'delete']);
        $fournisseur = $this->Fournisseurs->get($id);
        if ($this->Fournisseurs->delete($fournisseur)) {
            $this->Flash->success(__('The fournisseur has been deleted.'));
        } else {
            $this->Flash->error(__('The fournisseur could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
