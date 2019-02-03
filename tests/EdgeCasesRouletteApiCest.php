<?php
require_once 'RouletteApiCest.php';

class EdgeCasesRouletteApiCest extends RouletteApiCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
     * @example [6000]
     * @example [0]
     * @example [-100]
     * @example [50.70]
     * @example ["string"]
     */
    public function testInvalidBetParameters(ApiTester $I, \Codeception\Example $example)
    {
        $I->amNewPlayer();
        $I->betStraight($example[0], 7);
        $I->seeResponseCodeIs(422);
    }

    /**
     * @example [40, 422]
     * @example [-100, 404]
     * @example [50.50, 404]
     * @example ["string", 404]
     */
    public function testInvalidSpinParameters(ApiTester $I, \Codeception\Example $example)
    {
        $I->amNewPlayer();
        $I->spinAndSeeNumber($example[0]);
        $I->seeResponseCodeIs($example[1]);
    }
}