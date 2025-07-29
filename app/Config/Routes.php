<?php

use App\Controllers\Dashboard;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Dashboard::index');
$routes->get('/get_kpi', 'Dashboard::get_kpi');
$routes->get('/get_percentage_ontime', 'Dashboard::get_percentage_ontime');
