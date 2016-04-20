<?php
namespace Currency;

class CurrencyReceiver
{
    public function getLatest($base = 'EUR')
    {
        return $this->getData('http://api.fixer.io/latest?base=' . $base);
    }

    public function getAllByDate($date)
    {
        return $this->getData('http://api.fixer.io/' . $date);
    }

    public function getLatestYears($amount)
    {
        $data = [];

        $date = getdate();

        $month = $date['mon'];
        if ($month < 10) {
            $month = '0' . $month;
        }

        $day = $date['mday'];
        if ($day < 10) {
            $day = '0' . $day;
        }

        for ($i = 0; $i < $amount; $i++) {
            $url = 'http://api.fixer.io/' . ($date['year'] - $i) . '-' . $month . '-' . $day;
            $data[] = $this->getData($url);
        }

        return $data;
    }

    public function getExchangeRate($curr1, $curr2){
        $url = 'http://api.fixer.io/latest?symbols='. $curr2 .'&base=' . $curr1;
        $data = $this->getData($url);

        return [
            'rate' =>$data->rates->$curr2
        ];
    }

    private function getData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }
}