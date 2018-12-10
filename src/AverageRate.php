<?php
namespace Romash1408;

class AverageRate
{
    const CBR_ENDPOINT = "http://www.cbr.ru/scripts/XML_daily_eng.asp";
    const RBC_ENDPOINT = "https://cash.rbc.ru/json/converter_currency_rate/";

    public function get(Currency $cur, \DateTime $date = null): float
    {
        if ($date === null)
        {
            $date = new DateTime();
        }

        $cbr = $this->getFromCbr($cur, $date);
        $rbc = $this->getFromRbc($cur, $date);

        return $cbr / 2 + $rbc / 2;
    }

    private function getFromCbr(Currency $cur, \DateTime $date = null): float
    {
        $query = http_build_query([
            "date_req" => $date->format('d/m/Y'),
        ]);

        $response = file_get_contents(self::CBR_ENDPOINT . "?" . $query);
        if ($response === false)
        {
            throw new ServerException();
        }

        try 
        {
            $xml = new \SimpleXmlElement($response);
        }
        catch (\Exception $e)
        {
            throw new ServerException();
        }

        $result = $xml->xpath("/ValCurs/Valute[@ID='{$cur->getCbrId()}']");
        if (!$result)
        {
            throw new \InvalidArgumentException("No info about this currency on this date in CBR");
        }

        return str_replace(',', '.', $result[0]->Value) / $result[0]->Nominal;
    }

    private function getFromRbc(Currency $cur, \DateTime $date = null): float
    {
        $query = http_build_query([
            "currency_from" => $cur->getCharCode(),
            "currency_to" => "RUR",
            "source" => "cbrf",
            "sum" => 1,
            "date" => $date->format("Y-m-d"),
        ]);

        $response = file_get_contents(self::RBC_ENDPOINT . "?" . $query);
        if ($response === false)
        {
            throw new ServerException();
        }

        $json = json_decode($response);
        if ($json === null)
        {
            throw new ServerException();
        }

        if ($json->status !== 200)
        {
            throw new \InvalidArgumentException("No info about this currency on this date in CBR");
        }

        return $json->data->rate1;
    }
}
