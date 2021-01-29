<?php

namespace app\services\parsers;


class CurrencyRateParser
{
    protected $rates = [];

    protected $url = 'http://www.cbr.ru/scripts/XML_daily.asp';
    protected $dateTime;

    public function __construct()
    {
        $xml = new \DOMDocument();
        if (!$xml->load($this->url)) {
            throw new Exception('Unable to open xml with rates');
        }

        $root = $xml->documentElement;
        $this->dateTime = $root->getAttribute('Date');

        $items = $root->getElementsByTagName('Valute');
        foreach ($items as $item) {
            $name = $item->getElementsByTagName('Name')->item(0)->nodeValue;
            $rate = floatval(
                str_replace(',', '.', $item->getElementsByTagName('Value')->item(0)->nodeValue)
            );

            $this->rates[] = [
                'insert_dt' => $this->dateTime,
                'name' => $name,
                'rate' => $rate,
            ];
        }
    }

    public function getList()
    {
        return $this->rates;
    }
}

