<?php
require_once 'RouletteApiCest.php';

class BetStraightRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_35;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider straightBetsProvider
    */
    public function testStraightBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betStraight($bet, $example['number']);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    protected function straightBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossible());
    }
}