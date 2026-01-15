<?php

namespace App\Modules\ShortLink\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Frontend Routes - Short Link Redirect
 * --------------------------------------------------------------------
 */
$routes->get('l/(:segment)', 'App\Modules\ShortLink\Controllers\Frontend\ShortLinkController::redirect/$1');

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/short-links', ['namespace' => 'App\Modules\ShortLink\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ShortLinkController::index');
    $routes->get('create', 'ShortLinkController::create');
    $routes->post('/', 'ShortLinkController::store');
    $routes->get('(:num)', 'ShortLinkController::show/$1');
    $routes->get('(:num)/edit', 'ShortLinkController::edit/$1');
    $routes->put('(:num)', 'ShortLinkController::update/$1');
    $routes->post('(:num)', 'ShortLinkController::update/$1');
    $routes->delete('(:num)', 'ShortLinkController::delete/$1');
    $routes->post('(:num)/delete', 'ShortLinkController::delete/$1');
});
