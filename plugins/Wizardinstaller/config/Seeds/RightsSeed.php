<?php

    use Migrations\AbstractSeed;

    /**
     * Droits seed.
     */
    class RightsSeed extends AbstractSeed
    {
        /**
         * Run Method.
         *
         * Write your database seeder using this method.
         *
         * More information on writing seeds is available here:
         * http://docs.phinx.org/en/latest/seeding.html
         *
         * @return void
         */
        public function run(): void
        {
            $data = [['id'    => '1',
                      'code'  => 'ADMIN',
                      'label' => 'Droits d\'administration de l\'application',],
                     ['id'    => '2',
                      'code'  => 'EDITER_CLIENT',
                      'label' => 'Droits d\'édition ou de création d\'un client',],];

            $table = $this->table('rights');
            $table->insert($data)
                  ->save();
        }
    }
