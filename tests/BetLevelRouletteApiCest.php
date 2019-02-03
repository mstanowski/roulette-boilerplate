<?php
require_once 'RouletteApiCest.php';

class BetLevelRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_1;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider highBetsProvider
    */
    public function testHighBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betLevelHigh($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider lowBetsProvider
     */
    public function testLowBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betLevelLow($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    protected function highBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleHigh());
    }


    protected function lowBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleLow());
    }
}