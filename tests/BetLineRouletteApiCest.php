<?php
require_once 'RouletteApiCest.php';

class BetLineRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_5;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider lineBetsProvider
    */
    public function testLineBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $numbersInLine = explode('-', $example['line']);

        foreach($numbersInLine as $number) {
            $I->amNewPlayer();
            $I->betLine($bet, $example['line']);
            $I->spinAndSeeNumber($number);
            $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
        }
    }

    protected function lineBetsProvider()
    {
        return array_map(function($lineNumbers){
            return ['line' => join('-', $lineNumbers)];
        }, $this->getAllPossibleLines());
    }
}