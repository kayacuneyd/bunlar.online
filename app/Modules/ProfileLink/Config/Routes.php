<?php

namespace App\Modules\ProfileLink\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Frontend Routes - Link Redirect
 * --------------------------------------------------------------------
 */
$routes->get('go/(:num)', 'App\Modules\ProfileLink\Controllers\Frontend\ProfileLinkController::redirect/$1');

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/profile-links', ['namespace' => 'App\Modules\ProfileLink\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProfileLinkController::index');
    $routes->get('create', 'ProfileLinkController::create');
    $routes->post('/', 'ProfileLinkController::store');
    $routes->get('(:num)/edit', 'ProfileLinkController::edit/$1');
    $routes->put('(:num)', 'ProfileLinkController::update/$1');
    $routes->post('(:num)', 'ProfileLinkController::update/$1');
    $routes->delete('(:num)', 'ProfileLinkController::delete/$1');
    $routes->post('(:num)/delete', 'ProfileLinkController::delete/$1');
    $routes->post('reorder', 'ProfileLinkController::reorder');
});
