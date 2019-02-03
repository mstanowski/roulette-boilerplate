<?php
require_once 'RouletteApiCest.php';

class BetColumnRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_2;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider lowColumnBetsProvider
    */
    public function testLowColumnBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betColumnLow($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider mediumColumnBetsProvider
     */
    public function testMediumColumnBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betColumnMedium($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider highColumnBetsProvider
     */
    public function testHighColumnBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betColumnHigh($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    protected function lowColumnBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleInLowColumn());
    }

    protected function mediumColumnBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleInMediumColumn());
    }

    protected function highColumnBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleInHighColumn());
    }
}