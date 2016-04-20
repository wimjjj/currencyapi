<?php
require_once 'vendor/autoload.php';

include 'src/Countries/CountriesRepository.php';
include 'src/Currency/CurrencyReceiver.php';

use Slim\App as App;
use Countries\CountriesRepository as Countries;
use Currency\CurrencyReceiver as Currency;

$app = new App();

$app->get('/latest[/{base}]', function($request, $response, $args){
    if(isset($args['base'])){
        return $response->write(json_encode((new Currency())->getLatest($args['base'])));
    }
    return $response->write(json_encode((new Currency())->getLatest()));
});

$app->get('/date/{date}', function($request, $response, $args){
    return $response->write(json_encode((new Currency())->getAllByDate($args['date'])));
});

$app->get('/lastyears/{amount:[0-9]+}', function($request, $response, $args){
   return $response->write(json_encode((new Currency())->getLatestYears($args['amount'])));
});

$app->get('/exchangerate/{curr1}/{curr2}', function($request, $response, $args){
    return $response->write(json_encode((new Currency())->getExchangeRate($args['curr1'], $args['curr2'])));
});

$app->get('/countries', function($request, $response, $args){
    return $response->write(json_encode((new Countries())->addCurrency('fads')));
});


$app->run();