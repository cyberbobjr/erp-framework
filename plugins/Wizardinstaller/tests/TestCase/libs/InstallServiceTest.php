<?php

    namespace Wizardinstaller\Test\TestCase\libs;

    use Wizardinstaller\Exceptions\InstallException;
    use Wizardinstaller\libs\InstallService;
    use PHPUnit\Framework\TestCase;

    class InstallServiceTest extends TestCase
    {
        private InstallService $installService;

        protected function setUp(): void
        {
            parent::setUp();
            $this->installService = new InstallService();
        }

        /**
         * @testdox When Given null values will raise an exception
         * @return void
         */
        public function testGivenNullDataShouldThrowException(): void
        {
            $this->expectException(InstallException::class);
            $this->expectExceptionMessage(__("Données vides, session expirée"));
            $this->installService->execute(NULL, NULL);
        }

        public function testGivenValidDataShouldCreateDB(): void
        {
            $bdd['notcreate'] = FALSE;
            $admin = [
                'login'     => 'login',
                'password'  => 'password',
                'email'     => 'email',
                'lastname'  => 'lastname',
                'firstname' => 'firstname',
            ];
            $results = $this->installService->execute($admin, $bdd);
            $this->assertTrue(count($results) > 0);
        }
    }
