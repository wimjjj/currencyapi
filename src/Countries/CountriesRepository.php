<?php
namespace Countries;

use mysqli as mysqli;


class CountriesRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('YOUR_HOST', 'YOUR_USERNAME', 'YOUR_PASSWORD', 'YOUR_DB');
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
}