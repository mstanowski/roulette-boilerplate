<?php
require_once 'RouletteApiCest.php';

class BetParityRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_1;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider evenBetsProvider
    */
    public function testEvenBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betEven($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider oddBetsProvider
     */
    public function testOddBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betOdd($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    protected function evenBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleEven());
    }


    protected function oddBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleOdd());
    }
}