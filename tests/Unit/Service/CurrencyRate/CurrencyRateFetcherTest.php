<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\CurrencyRate;

use App\Service\CurrencyRate\CurrencyRateFetcher;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class CurrencyRateFetcherTest extends TestCase
{
    private const EXAMPLE_URL = 'https://example.com';
    private const EXAMPLE_KEY = 'key';

    public function testFetchRatesSuccess(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn(
            new Response(
                200,
                [],
                '{"success":true,"timestamp":1627899663,"base":"EUR","date":"2021-08-02","rates":{"AED":4.367984,"AFN":95.176861,"ALL":122.157511,"AMD":578.212284,"ANG":2.140286,"AOA":759.417194,"ARS":114.990512,"AUD":1.616096,"AWG":2.14047,"AZN":2.020147,"BAM":1.959496,"BBD":2.407484,"BDT":101.231389,"BGN":1.956082,"BHD":0.448319,"BIF":2363.26131,"BMD":1.18915,"BND":1.613305,"BOB":8.210479,"BRL":6.199275,"BSD":1.192321,"BTC":3.0033871e-5,"BTN":88.365011,"BWP":13.131757,"BYN":2.974941,"BYR":23307.334557,"BZD":2.403376,"CAD":1.481883,"CDF":2379.488511,"CHF":1.076532,"CLF":0.032609,"CLP":899.77008,"CNY":7.683212,"COP":4611.522623,"CRC":738.993225,"CUC":1.18915,"CUP":31.512468,"CVE":110.166772,"CZK":25.49073,"DJF":212.265332,"DKK":7.439681,"DOP":67.987337,"DZD":160.017871,"EGP":18.653996,"ERN":17.842299,"ETB":52.82613,"EUR":1,"FJD":2.47902,"FKP":0.859471,"GBP":0.855052,"GEL":3.668549,"GGP":0.859471,"GHS":7.11066,"GIP":0.859471,"GMD":60.82527,"GNF":11643.235894,"GTQ":9.215283,"GYD":248.328584,"HKD":9.24533,"HNL":28.288924,"HRK":7.49985,"HTG":114.417057,"HUF":357.05405,"IDR":17110.615896,"ILS":3.833961,"IMP":0.859471,"INR":88.414174,"IQD":1739.654635,"IRR":50069.149019,"ISK":146.824828,"JEP":0.859471,"JMD":184.910941,"JOD":0.843137,"JPY":130.296338,"KES":129.200574,"KGS":100.790541,"KHR":4854.081264,"KMF":494.686078,"KPW":1070.234757,"KRW":1367.754113,"KWD":0.35728,"KYD":0.993651,"KZT":507.394994,"LAK":11383.400923,"LBP":1802.857718,"LKR":237.873926,"LRD":204.117382,"LSL":17.646805,"LTL":3.51125,"LVL":0.719305,"LYD":5.375712,"MAD":10.577968,"MDL":21.34305,"MGA":4550.024156,"MKD":61.624821,"MMK":1962.609346,"MNT":3386.834649,"MOP":9.547362,"MRO":424.526246,"MUR":50.482111,"MVR":18.372771,"MWK":968.797329,"MXN":23.580732,"MYR":5.024135,"MZN":75.665276,"NAD":17.647707,"NGN":489.03772,"NIO":41.868979,"NOK":10.475103,"NPR":141.772254,"NZD":1.704557,"OMR":0.457792,"PAB":1.18914,"PEN":4.679555,"PGK":4.18658,"PHP":59.28866,"PKR":193.876183,"PLN":4.563127,"PYG":8234.937092,"QAR":4.329663,"RON":4.918443,"RSD":117.795378,"RUB":86.649179,"RWF":1201.177123,"SAR":4.459662,"SBD":9.586178,"SCR":17.422729,"SDG":530.952572,"SEK":10.21075,"SGD":1.607133,"SHP":0.859471,"SLL":12194.730087,"SOS":695.652439,"SRD":25.453723,"STD":24496.275027,"SVC":10.43352,"SYP":1495.196125,"SZL":17.367145,"THB":39.163476,"TJS":13.561308,"TMT":4.173916,"TND":3.318319,"TOP":2.690154,"TRY":9.955917,"TTD":8.100587,"TWD":33.210337,"TZS":2757.638578,"UAH":31.992985,"UGX":4224.733115,"USD":1.18915,"UYU":52.087557,"UZS":12689.620392,"VEF":254276149507.1246,"VND":27293.959,"VUV":130.947623,"WST":3.034301,"XAF":657.180961,"XAG":0.046674,"XAU":0.000657,"XCD":3.213737,"XDR":0.835256,"XOF":657.180961,"XPF":120.639499,"YER":297.405139,"ZAR":17.155512,"ZMK":10703.750343,"ZMW":22.934915,"ZWL":382.906495}}'
            )
        );
        $rates = (new CurrencyRateFetcher(self::EXAMPLE_URL, self::EXAMPLE_KEY, $client))->fetchRates();
        self::assertSame(
            [
                'AED' => 4.367984,
                'AFN' => 95.176861,
                'ALL' => 122.157511,
                'AMD' => 578.212284,
                'ANG' => 2.140286,
                'AOA' => 759.417194,
                'ARS' => 114.990512,
                'AUD' => 1.616096,
                'AWG' => 2.14047,
                'AZN' => 2.020147,
                'BAM' => 1.959496,
                'BBD' => 2.407484,
                'BDT' => 101.231389,
                'BGN' => 1.956082,
                'BHD' => 0.448319,
                'BIF' => 2363.26131,
                'BMD' => 1.18915,
                'BND' => 1.613305,
                'BOB' => 8.210479,
                'BRL' => 6.199275,
                'BSD' => 1.192321,
                'BTC' => 3.0033871E-5,
                'BTN' => 88.365011,
                'BWP' => 13.131757,
                'BYN' => 2.974941,
                'BYR' => 23307.334557,
                'BZD' => 2.403376,
                'CAD' => 1.481883,
                'CDF' => 2379.488511,
                'CHF' => 1.076532,
                'CLF' => 0.032609,
                'CLP' => 899.77008,
                'CNY' => 7.683212,
                'COP' => 4611.522623,
                'CRC' => 738.993225,
                'CUC' => 1.18915,
                'CUP' => 31.512468,
                'CVE' => 110.166772,
                'CZK' => 25.49073,
                'DJF' => 212.265332,
                'DKK' => 7.439681,
                'DOP' => 67.987337,
                'DZD' => 160.017871,
                'EGP' => 18.653996,
                'ERN' => 17.842299,
                'ETB' => 52.82613,
                'EUR' => 1,
                'FJD' => 2.47902,
                'FKP' => 0.859471,
                'GBP' => 0.855052,
                'GEL' => 3.668549,
                'GGP' => 0.859471,
                'GHS' => 7.11066,
                'GIP' => 0.859471,
                'GMD' => 60.82527,
                'GNF' => 11643.235894,
                'GTQ' => 9.215283,
                'GYD' => 248.328584,
                'HKD' => 9.24533,
                'HNL' => 28.288924,
                'HRK' => 7.49985,
                'HTG' => 114.417057,
                'HUF' => 357.05405,
                'IDR' => 17110.615896,
                'ILS' => 3.833961,
                'IMP' => 0.859471,
                'INR' => 88.414174,
                'IQD' => 1739.654635,
                'IRR' => 50069.149019,
                'ISK' => 146.824828,
                'JEP' => 0.859471,
                'JMD' => 184.910941,
                'JOD' => 0.843137,
                'JPY' => 130.296338,
                'KES' => 129.200574,
                'KGS' => 100.790541,
                'KHR' => 4854.081264,
                'KMF' => 494.686078,
                'KPW' => 1070.234757,
                'KRW' => 1367.754113,
                'KWD' => 0.35728,
                'KYD' => 0.993651,
                'KZT' => 507.394994,
                'LAK' => 11383.400923,
                'LBP' => 1802.857718,
                'LKR' => 237.873926,
                'LRD' => 204.117382,
                'LSL' => 17.646805,
                'LTL' => 3.51125,
                'LVL' => 0.719305,
                'LYD' => 5.375712,
                'MAD' => 10.577968,
                'MDL' => 21.34305,
                'MGA' => 4550.024156,
                'MKD' => 61.624821,
                'MMK' => 1962.609346,
                'MNT' => 3386.834649,
                'MOP' => 9.547362,
                'MRO' => 424.526246,
                'MUR' => 50.482111,
                'MVR' => 18.372771,
                'MWK' => 968.797329,
                'MXN' => 23.580732,
                'MYR' => 5.024135,
                'MZN' => 75.665276,
                'NAD' => 17.647707,
                'NGN' => 489.03772,
                'NIO' => 41.868979,
                'NOK' => 10.475103,
                'NPR' => 141.772254,
                'NZD' => 1.704557,
                'OMR' => 0.457792,
                'PAB' => 1.18914,
                'PEN' => 4.679555,
                'PGK' => 4.18658,
                'PHP' => 59.28866,
                'PKR' => 193.876183,
                'PLN' => 4.563127,
                'PYG' => 8234.937092,
                'QAR' => 4.329663,
                'RON' => 4.918443,
                'RSD' => 117.795378,
                'RUB' => 86.649179,
                'RWF' => 1201.177123,
                'SAR' => 4.459662,
                'SBD' => 9.586178,
                'SCR' => 17.422729,
                'SDG' => 530.952572,
                'SEK' => 10.21075,
                'SGD' => 1.607133,
                'SHP' => 0.859471,
                'SLL' => 12194.730087,
                'SOS' => 695.652439,
                'SRD' => 25.453723,
                'STD' => 24496.275027,
                'SVC' => 10.43352,
                'SYP' => 1495.196125,
                'SZL' => 17.367145,
                'THB' => 39.163476,
                'TJS' => 13.561308,
                'TMT' => 4.173916,
                'TND' => 3.318319,
                'TOP' => 2.690154,
                'TRY' => 9.955917,
                'TTD' => 8.100587,
                'TWD' => 33.210337,
                'TZS' => 2757.638578,
                'UAH' => 31.992985,
                'UGX' => 4224.733115,
                'USD' => 1.18915,
                'UYU' => 52.087557,
                'UZS' => 12689.620392,
                'VEF' => 254276149507.1246,
                'VND' => 27293.959,
                'VUV' => 130.947623,
                'WST' => 3.034301,
                'XAF' => 657.180961,
                'XAG' => 0.046674,
                'XAU' => 0.000657,
                'XCD' => 3.213737,
                'XDR' => 0.835256,
                'XOF' => 657.180961,
                'XPF' => 120.639499,
                'YER' => 297.405139,
                'ZAR' => 17.155512,
                'ZMK' => 10703.750343,
                'ZMW' => 22.934915,
                'ZWL' => 382.906495,
            ],
            $rates
        );
    }

    public function testFetchRatesEmptyResponse(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn(
            new Response(
                200,
                [],
                '{}'
            )
        );
        $this->expectException('App\Exception\CurrencyRateFetcherException');
        (new CurrencyRateFetcher(self::EXAMPLE_URL, self::EXAMPLE_KEY, $client))->fetchRates();
    }

    public function testFetchRatesFail(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willThrowException(
            new RequestException('error', new Request('get', self::EXAMPLE_URL))
        );
        $this->expectException('App\Exception\CurrencyRateFetcherException');
        (new CurrencyRateFetcher(self::EXAMPLE_URL, self::EXAMPLE_KEY, $client))->fetchRates();
    }
}
