<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    const ENDPOINT_SPIN = '/spin';
    const ENDPOINT_CHIPS = '/chips';
    const ENDPOINT_BETS_BLACK = '/bets/black';
    const ENDPOINT_BETS_RED = '/bets/red';
    const ENDPOINT_BETS_COLUMN_LOW = '/bets/column/1';
    const ENDPOINT_BETS_COLUMN_MEDIUM = '/bets/column/2';
    const ENDPOINT_BETS_COLUMN_HIGH = '/bets/column/3';
    const ENDPOINT_BETS_DOZEN_LOW = '/bets/dozen/1';
    const ENDPOINT_BETS_DOZEN_MEDIUM = '/bets/dozen/2';
    const ENDPOINT_BETS_DOZEN_HIGH = '/bets/dozen/3';
    const ENDPOINT_BETS_HIGH = '/bets/high';
    const ENDPOINT_BETS_LOW = '/bets/low';
    const ENDPOINT_BETS_EVEN = '/bets/even'; //parzyste
    const ENDPOINT_BETS_ODD = '/bets/odd'; //nieparzyste
    const ENDPOINT_BETS_STRAIGHT = '/bets/straight';
    const ENDPOINT_BETS_CORNER = '/bets/corner';
    const ENDPOINT_BETS_STREET = '/bets/street';
    const ENDPOINT_BETS_LINE = '/bets/line';
    const ENDPOINT_BETS_SPLIT = '/bets/split';

    public function authorizeWithHash()
    {
        $url = $this->getModule('REST')->_getConfig('url');
        $endpoint = $url . '/players';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $rawOutput = curl_exec($ch);
        if (! curl_errno($ch)) {
            $info = curl_getinfo($ch);
            if ($info['http_code'] === 201) {
                $jsonOutput = json_decode($rawOutput, true);
                return $jsonOutput['hashname'];
            }
        }
        return null;
    }

    public function amNewPlayer()
    {
        $this->getModule('REST')->haveHttpHeader('Authorization', $this->authorizeWithHash());
    }

    public function betColorBlack($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_BLACK, ['chips' => $chips]);
    }

    public function betColorRed($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_RED, ['chips' => $chips]);
    }

    public function betColumnLow($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_COLUMN_LOW, ['chips' => $chips]);
    }

    public function betColumnMedium($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_COLUMN_MEDIUM, ['chips' => $chips]);
    }

    public function betColumnHigh($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_COLUMN_HIGH, ['chips' => $chips]);
    }

    public function betDozenLow($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_DOZEN_LOW, ['chips' => $chips]);
    }

    public function betDozenMedium($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_DOZEN_MEDIUM, ['chips' => $chips]);
    }

    public function betDozenHigh($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_DOZEN_HIGH, ['chips' => $chips]);
    }

    public function betLevelLow($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_LOW, ['chips' => $chips]);
    }

    public function betLevelHigh($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_HIGH, ['chips' => $chips]);
    }

    public function betEven($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_EVEN, ['chips' => $chips]);
    }

    public function betOdd($chips)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_ODD, ['chips' => $chips]);
    }

    public function betStraight($chips, $number)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_STRAIGHT . '/' . $number, ['chips' => $chips]);
    }

    public function betCorner($chips, $corner)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_CORNER . '/' . $corner, ['chips' => $chips]);
    }

    public function betStreet($chips, $street)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_STREET . '/' . $street, ['chips' => $chips]);
    }

    public function betLine($chips, $line)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_LINE . '/' . $line, ['chips' => $chips]);
    }

    public function betSplit($chips, $split)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_BETS_SPLIT . '/' . $split, ['chips' => $chips]);
    }

    public function spinAndSeeNumber($number)
    {
        $this->getModule('REST')->sendPOST(self::ENDPOINT_SPIN . '/' . $number);
    }

    public function shouldHaveChips($chips)
    {
        $this->getModule('REST')->sendGET(self::ENDPOINT_CHIPS);
        $this->assertEquals($chips, json_decode($this->getModule('REST')->grabResponse(), true)['chips']);

    }
}
