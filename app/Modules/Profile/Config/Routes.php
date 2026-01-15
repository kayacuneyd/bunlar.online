<?php

namespace App\Modules\Profile\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/profiles', ['namespace' => 'App\Modules\Profile\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProfileController::index');
    $routes->get('create', 'ProfileController::create');
    $routes->post('/', 'ProfileController::store');
    $routes->get('(:num)', 'ProfileController::show/$1');
    $routes->get('(:num)/edit', 'ProfileController::edit/$1');
    $routes->put('(:num)', 'ProfileController::update/$1');
    $routes->post('(:num)', 'ProfileController::update/$1');
    $routes->delete('(:num)', 'ProfileController::delete/$1');
    $routes->post('(:num)/delete', 'ProfileController::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Frontend Routes - Profile Page (/{username})
 * These routes are defined at the end of main Routes.php to avoid conflicts
 * --------------------------------------------------------------------
 */
