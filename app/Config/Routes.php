<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/users/save', 'UserController::save');

$routes->post('/countary/add','CountaryController::addCountary');
$routes->get('/countary/all','CountaryController::getCountries');
$routes->put('/countary/update/(:alphanum)','CountaryController::updateCountary/$1');
$routes->delete('/countary/delete/(:num)','CountaryController::deleteCountary/$1');


$routes->post('/state/add','StateController::addState');
$routes->get('/state/all/(:alphanum)','StateController::getStateByCountry/$1');
$routes->put('/state/update/(:alphanum)','StateController::updateState/$1');
$routes->delete('/state/delete/(:alphanum)','StateController::deleteState/$1');
