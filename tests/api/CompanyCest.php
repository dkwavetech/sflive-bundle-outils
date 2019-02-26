<?php

namespace App\Tests;

use App\Tests\ApiTester;

class CompanyCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    // tests
    public function getCompaniesAPI(ApiTester $I)
    {
        $I->sendGET('/companies');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"name":"Suzanne Moen"}');
    }
}
