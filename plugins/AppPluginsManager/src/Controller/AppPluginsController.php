<?php

    namespace AppPluginsManager\Controller;

    use Cake\Http\Exception\NotFoundException;

    /**
     * AppPlugins Controller
     *
     * @property \App\Model\Table\AppPluginsTable $AppPlugins
     *
     * @method \App\Model\Entity\AppPlugin[]|\Cake\Datasource\ResultSetInterface paginate($object = NULL, array $settings = [])
     */
    class AppPluginsController extends AppController
    {
        /**
         * Index method
         *
         * @return \Cake\Http\Response|void
         */
        public function index()
        {
            $appPlugins = $this->paginate($this->AppPlugins);

            $this->set(compact('appPlugins'));
        }

        /**
         * View method
         *
         * @param  string|null  $id  App Plugin id.
         * @return \Cake\Http\Response|void
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function view($id = NULL)
        {
            $appPlugin = $this->AppPlugins->get($id, [
                'contain' => []
            ]);

            $this->set('appPlugin', $appPlugin);
        }

        /**
         * Add method
         *
         * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
         */
        public function add()
        {
            $appPlugin = $this->AppPlugins->newEntity();
            if ($this->request->is('post')) {
                $appPlugin = $this->AppPlugins->patchEntity($appPlugin, $this->request->getData());
                if ($this->AppPlugins->save($appPlugin)) {
                    $this->Flash->success(__('The app plugin has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The app plugin could not be saved. Please, try again.'));
            }
            $this->set(compact('appPlugin'));
        }

        /**
         * Edit method
         *
         * @param  string|null  $id  App Plugin id.
         * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function edit($id = NULL)
        {
            $appPlugin = $this->AppPlugins->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch',
                                    'post',
                                    'put'])) {
                $appPlugin = $this->AppPlugins->patchEntity($appPlugin, $this->request->getData());
                if ($this->AppPlugins->save($appPlugin)) {
                    $this->Flash->success(__('The app plugin has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The app plugin could not be saved. Please, try again.'));
            }
            $this->set(compact('appPlugin'));
        }

        /**
         * Delete method
         *
         * @param  string|null  $id  App Plugin id.
         * @return \Cake\Http\Response|null Redirects to index.
         * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
         */
        public function delete($id = NULL)
        {
            $this->request->allowMethod(['post',
                                         'delete']);
            $appPlugin = $this->AppPlugins->get($id);
            if ($this->AppPlugins->delete($appPlugin)) {
                $this->Flash->success(__('The app plugin has been deleted.'));
            } else {
                $this->Flash->error(__('The app plugin could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        }

        public function toggleActivate($app_plugin_id)
        {
            if (!$this->AppPlugins->exists(['id' => $app_plugin_id])) {
                throw new NotFoundException(__('App plugin not found'));
            }
            $app_plugin = $this->AppPlugins->get($app_plugin_id);
            $app_plugin->activated = !$app_plugin->activated;
            $this->AppPlugins->save($app_plugin);
            $app_plugin->activated ? $this->Flash->success(__('The plugin has been activated.')) : $this->Flash->success(__('The plugin has been deactivated.'));
            return $this->redirect(['action' => 'index']);
        }
    }
