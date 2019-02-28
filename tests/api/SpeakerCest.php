<?php

namespace App\Tests;

use App\Tests\ApiTester;

class SpeakerCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    // tests
    public function getSpeakersAPI(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->sendGET('/speakers');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains("codeception");
    }

    // tests
    public function getUnknownSpeakersAPI(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/ld+json');
        $I->sendGET('/speakers/test');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
    }
}
