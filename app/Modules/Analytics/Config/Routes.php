<?php

namespace App\Modules\Analytics\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/analytics', ['namespace' => 'App\Modules\Analytics\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AnalyticsController::index');
});
