<?php
require_once 'RouletteApiCest.php';

class BetCornerRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_8;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider cornerBetsProvider
    */
    public function testCornerBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $numbersInCorner = explode('-', $example['corner']);

        foreach($numbersInCorner as $number) {
            $I->amNewPlayer();
            $I->betCorner($bet, $example['corner']);
            $I->spinAndSeeNumber($number);
            $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
        }
    }

    protected function cornerBetsProvider()
    {
        return array_map(function($cornerNumbers){
            return ['corner' => join('-', $cornerNumbers)];
        }, $this->getAllPossibleCorners());
    }
}