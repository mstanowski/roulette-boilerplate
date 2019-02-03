<?php
class RouletteApiCest 
{
    const ENDPOINT_SPIN = '/spin';
    const ENDPOINT_CHIPS = '/chips';
    const CHIPS_ON_START = 100;
    const WIN_RATIO_1_to_1 = 1;
    const WIN_RATIO_1_to_2 = 2;
    const WIN_RATIO_1_to_5 = 5;
    const WIN_RATIO_1_to_8 = 8;
    const WIN_RATIO_1_to_11 = 11;
    const WIN_RATIO_1_to_17 = 17;
    const WIN_RATIO_1_to_35 = 35;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }
    
    protected function randomValidBet()
    {
        return rand(1, self::CHIPS_ON_START);
    }

    protected function winForGivenBetAndRatio($bet, $ratio)
    {
        return $bet * $ratio;
    }

    protected function totalChipsAfterWin($chips, $bet, $ratio)
    {
        return $chips + $this->winForGivenBetAndRatio($bet, $ratio);
    }

    /**
     * @return array
     */
    protected function getAllPossible()
    {
        return range(0, 36);
    }

    /**
     * 2-4-6-8-10-11-13-15-17-19-20-22-24-26-29-31-33-35
     * @return array
     */
    protected function getAllPossibleBlacks()
    {
        return explode('-', '2-4-6-8-10-11-13-15-17-19-20-22-24-26-29-31-33-35');
    }

    /**
     * 1-3-5-7-9-12-14-16-18-21-23-25-27-28-30-32-34-36
     * @return array
     */
    protected function getAllPossibleReds()
    {
        return explode('-', '1-3-5-7-9-12-14-16-18-21-23-25-27-28-30-32-34-36');
    }

    /**
     * @return array
     */
    protected function getAllPossibleEven()
    {
        return array_filter($this->getAllPossible(), function($number){
            if($number == 0) {
                return false;
            }

            return ($number % 2) == 0;
        });
    }

    /**
     * @return array
     */
    protected function getAllPossibleOdd()
    {
        return array_filter($this->getAllPossible(), function($number){
            return ($number % 2) != 0;
        });
    }

    /**
     * @return array
     */
    protected function getAllPossibleHigh()
    {
        return range(19, 36);
    }

    /**
     * @return array
     */
    protected function getAllPossibleLow()
    {
        return range(1, 18);
    }

    /**
     * @return array
     */
    protected function getAllPossibleInLowDozen()
    {
        return range(1, 12);
    }

    /**
     * @return array
     */
    protected function getAllPossibleInMediumDozen()
    {
        return range(2, 13); // 13..24??
    }

    /**
     * @return array
     */
    protected function getAllPossibleInHighDozen()
    {
        return range(3, 14); // 25..36??
    }

    /**
     * 1-4-7-10-13-16-19-22-25-28-31-34
     * @return array
     */
    protected function getAllPossibleInLowColumn()
    {
        return range(1, 34, 3);
    }

    /**
     * 2-5-8-11-14-17-20-23-26-29-32-35
     * @return array
     */
    protected function getAllPossibleInMediumColumn()
    {
        return range(2, 35, 3);
    }

    /**
     * 3-6-9-12-15-18-21-24-27-30-33-36
     * @return array
     */
    protected function getAllPossibleInHighColumn()
    {
        return range(3, 36, 3);
    }

    protected function getAllPossibleCorners()
    {
        $corners = [];
        $lowColumnWithoutLastNumber = range(1, 31, 3);
        $mediumColumnWithoutLastNumber = range(2, 32, 3);
        $possibleStartingNumbers = array_merge($lowColumnWithoutLastNumber, $mediumColumnWithoutLastNumber);
        foreach($possibleStartingNumbers as $number) {
            $corners[] = [
                $number,
                $number+1,
                $number+3,
                $number+4,
            ];
        }
        $corners[] = [0, 1, 2, 3];
        return $corners;
    }

    protected function getAllPossibleStreets()
    {
        $streets = [];
        foreach($this->getAllPossibleInLowColumn() as $number) {
            $streets[] = [
                $number,
                $number+1,
                $number+2,
            ];
        }
        $streets[] = [0, 1, 2];
        $streets[] = [0, 2, 3];
        return $streets;
    }

    protected function getAllPossibleSplits()
    {
        $splits = [];
        $possibleStartingNumbers = array_merge(
            $this->getAllPossibleInLowColumn(),
            $this->getAllPossibleInMediumColumn()
        );
        foreach($possibleStartingNumbers as $number) {
            $splits[] = [
                $number,
                $number+1,
            ];
        }
        $splits[] = [0, 1];
        $splits[] = [0, 2];
        $splits[] = [0, 3];
        return $splits;
    }

    protected function getAllPossibleLines()
    {
        $lines = [];
        $lowColumnWithoutLastNumber = range(1, 31, 3);
        foreach($lowColumnWithoutLastNumber as $number) {
            $lines[] = [
                $number,
                $number+1,
                $number+2,
                $number+3,
                $number+4,
                $number+5,
            ];
        }
        return $lines;
    }
}