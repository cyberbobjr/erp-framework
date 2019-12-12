<?php

    namespace TiersManager\Model\Entity;

    use Cake\TestSuite\TestCase;

    class CustomerTest extends TestCase
    {
        public function test_should_return_fullname_with_company_name()
        {
            $customer = new Customer();
            $firstname = 'Benjamin';
            $lastname = 'Marchand';
            $company_name = 'KEY EIRL';
            $customer->set('firstname', $firstname);
            $customer->set('lastname', $lastname);
            $customer->set('company_name', $company_name);

            self::assertEquals('Benjamin Marchand KEY EIRL', $customer->get('fullname'));
        }

        public function test_should_return_fullname_with_partial_infos()
        {
            $customer = new Customer();
            $company_name = 'KEY EIRL';
            $customer->set('company_name', $company_name);

            self::assertEquals('KEY EIRL', $customer->get('fullname'));
        }

    }
