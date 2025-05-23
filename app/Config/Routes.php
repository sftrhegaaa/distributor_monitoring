<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', to: 'Home::index');

// $routes->get('/', 'RegionController::select2');
$routes->get('/', 'DistributorController::index');
$routes->get('distributor/index', 'DistributorController::index');
$routes->get('distributor/data', 'DistributorController::getData');
$routes->get('distributor/datatable', 'DistributorController::datatable');

$routes->get('distributor', 'DistributorController::DataListDitsributor');
$routes->get('distributor/detail', 'DistributorController::DetailDitsributor/$1');


$routes->get('distributor/create', 'DistributorController::create');
$routes->post('distributor/store', 'DistributorController::store');
$routes->get('distributor/edit/(:segment)', 'DistributorController::edit/$1');
$routes->post('distributor/update/(:segment)', 'DistributorController::update/$1');
$routes->get('distributor/delete/(:segment)', 'DistributorController::delete/$1');



