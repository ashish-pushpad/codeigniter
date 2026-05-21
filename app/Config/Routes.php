<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
      $routes->resource('product');

    $routes->options('(:any)', static function () {
    return response()
        ->setStatusCode(204)
        ->setHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
});
    $routes->options('product/(:any)', static function () {});
    $routes->post('users/save', 'UserController::save');

    $routes->post('countary/add', 'CountaryController::addCountary');
    $routes->get('countary/all', 'CountaryController::getCountries');
    $routes->put('countary/update/(:alphanum)', 'CountaryController::updateCountary/$1');
    $routes->delete('countary/delete/(:alphanum)', 'CountaryController::deleteCountary/$1');

    $routes->post('state/add', 'StateController::addState');
    $routes->get('state/all/(:alphanum)', 'StateController::getStateByCountry/$1');
    $routes->put('state/update/(:alphanum)', 'StateController::updateState/$1');
    $routes->delete('state/delete/(:alphanum)', 'StateController::deleteState/$1');

    $routes->post('city/add', 'CityController::addCity');
    $routes->get('city/all/(:alphanum)', 'CityController::getCityByState/$1');
    $routes->put('city/update/(:alphanum)', 'CityController::updateCity/$1');
    $routes->delete('city/delete/(:alphanum)', 'CityController::deleteCity/$1');

});