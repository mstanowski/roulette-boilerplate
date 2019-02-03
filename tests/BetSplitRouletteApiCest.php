<?php
require_once 'RouletteApiCest.php';

class BetSplitRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_17;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider splitBetsProvider
    */
    public function testSplitBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();
        $numbersInSplit = explode('-', $example['split']);

        foreach($numbersInSplit as $number) {
            $I->amNewPlayer();
            $I->betSplit($bet, $example['split']);
            $I->spinAndSeeNumber($number);
            $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
        }
    }

    protected function splitBetsProvider()
    {
        return array_map(function($splitNumbers){
            return ['split' => join('-', $splitNumbers)];
        }, $this->getAllPossibleSplits());
    }
}