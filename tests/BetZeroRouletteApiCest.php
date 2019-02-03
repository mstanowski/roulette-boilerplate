<?php
require_once 'RouletteApiCest.php';

class BetZeroRouletteApiCest extends RouletteApiCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function testStraightZeroBetParameters(ApiTester $I)
    {
        $I->amNewPlayer();
        $I->betStraight(self::CHIPS_ON_START, 0);
        $I->spinAndSeeNumber(0);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, self::CHIPS_ON_START, self::WIN_RATIO_1_to_35));
    }

    public function testEvenZeroBetParameters(ApiTester $I)
    {
        $I->amNewPlayer();
        $I->betEven(self::CHIPS_ON_START, 0);
        $I->spinAndSeeNumber(0);
        $I->shouldHaveChips(0);
    }

    public function testOddZeroBetParameters(ApiTester $I)
    {
        $I->amNewPlayer();
        $I->betOdd(self::CHIPS_ON_START, 0);
        $I->spinAndSeeNumber(0);
        $I->shouldHaveChips(0);
    }

    public function testBlackZeroBetParameters(ApiTester $I)
    {
        $I->amNewPlayer();
        $I->betColorBlack(self::CHIPS_ON_START, 0);
        $I->spinAndSeeNumber(0);
        $I->shouldHaveChips(0);
    }

    public function testRedZeroBetParameters(ApiTester $I)
    {
        $I->amNewPlayer();
        $I->betColorRed(self::CHIPS_ON_START, 0);
        $I->spinAndSeeNumber(0);
        $I->shouldHaveChips(0);
    }
}