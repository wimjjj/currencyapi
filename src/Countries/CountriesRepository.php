<?php
namespace Countries;

use mysqli as mysgli;


class CountriesRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = new \mysqli('YOUR_HOST', 'YOUR_USERNAME', 'YOUR_PASSWORD', 'YOUR_DB');
    }

    public function getByCurrency($currency)
    {
        $sql = "SELECT countries.name from countries LEFT JION currencies ON countries.currency_id = currencies.id WHERE currencies.name ='" . $this->conn->real_escape_string($currency);
    }

    public function getAll()
    {
        $sql = "SELECT countries.name, currencies.name FROM countries LEFT JION currencies ON countries.currency_id = currencies.id ";

    }

    public function addCurrency($name)
    {
        $sql = "INSERT INTO currencies (name) VALUES (" . $this->conn->real_escape_string($name) . ");";

        return $sql;
    }

    public function addCountry($name, $currency_id)
    {
        $sql = "INSERT INTO countries (name, currency_id) VALUES ('" . $this->conn->real_escape_string($name) . "', '" . $this->conn->real_escape_string($currency_id) . "');";
    }

    private function executeQuerie($sql)
    {
        if (!$result = $this->conn->query($sql)) {
            return ['error' => $this->conn->error];
        }

        $return = [];

        while ($row = $result->fetch_assoc()) {
            $return[] = $row;
        }

        $this->conn->close();

        return $return;
    }
}