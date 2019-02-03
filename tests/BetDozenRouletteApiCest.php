<?php
require_once 'RouletteApiCest.php';

class BetDozenRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_2;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider lowDozenBetsProvider
    */
    public function testLowDozenBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betDozenLow($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider mediumDozenBetsProvider
     */
    public function testMediumDozenBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betDozenMedium($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    /**
     * @dataProvider highDozenBetsProvider
     */
    public function testHighDozenBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $I->amNewPlayer();
        $I->betDozenHigh($bet);
        $I->spinAndSeeNumber($example['number']);
        $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
    }

    protected function lowDozenBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleInLowDozen());
    }

    protected function mediumDozenBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleInMediumDozen());
    }

    protected function highDozenBetsProvider()
    {
        return array_map(function($number){
            return ['number' => $number];
        }, $this->getAllPossibleInHighDozen());
    }
}