<?php
require_once 'RouletteApiCest.php';

class BetStreetRouletteApiCest extends RouletteApiCest
{
    const WIN_RATIO = parent::WIN_RATIO_1_to_11;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    /**
    * @dataProvider streetBetsProvider
    */
    public function testStreetBets(ApiTester $I, \Codeception\Example $example)
    {
        $bet = $this->randomValidBet();

        $numbersInStreet = explode('-', $example['street']);

        foreach($numbersInStreet as $number) {
            $I->amNewPlayer();
            $I->betStreet($bet, $example['street']);
            $I->spinAndSeeNumber($number);
            $I->shouldHaveChips($this->totalChipsAfterWin(self::CHIPS_ON_START, $bet, self::WIN_RATIO));
        }
    }

    protected function streetBetsProvider()
    {
        return array_map(function($streetNumbers){
            return ['street' => join('-', $streetNumbers)];
        }, $this->getAllPossibleStreets());
    }
}