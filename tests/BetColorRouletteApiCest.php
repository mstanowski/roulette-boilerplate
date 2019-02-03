<?php
require_once 'RouletteApiCest.php';

class BetColorRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_1;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider blackBetsProvider
    */
    public function testBlackBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betColorBlack($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider redBetsProvider
     */
    public function testRedBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betColorRed($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    protected function blackBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleBlacks());
    }

    protected function redBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleReds());
    }
}