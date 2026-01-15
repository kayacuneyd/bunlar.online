<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 *
 * This file defines the routes for the application. It sets
 * defaults and maps URIs to controllers and methods.
 */

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Frontend\\HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// You can enable Auto Routing (Improved) if you wish to avoid defining
// all routes by hand. The route definitions here make it explicit which
// routes are available.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Home page
$routes->get('/', 'Frontend\\HomeController::index');

// Authentication
$routes->get('login', 'Auth\\LoginController::index');
$routes->post('login', 'Auth\\LoginController::attempt');
$routes->get('logout', 'Auth\\LoginController::logout');

// Admin routes group with auth filter
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // When visiting /admin or /admin/dashboard, show the dashboard
    $routes->get('/', 'Admin\\DashboardController::index');
    $routes->get('dashboard', 'Admin\\DashboardController::index');
});

/*
 * --------------------------------------------------------------------
 * Module Routes
 * --------------------------------------------------------------------
 */

// Load Property Module routes
require_once APPPATH . 'Modules/Property/Config/Routes.php';

// Load Profile Module routes (admin only, frontend routes are special)
require_once APPPATH . 'Modules/Profile/Config/Routes.php';

// Load ProfileLink Module routes
require_once APPPATH . 'Modules/ProfileLink/Config/Routes.php';

// Load ShortLink Module routes
require_once APPPATH . 'Modules/ShortLink/Config/Routes.php';

// Load Analytics Module routes
require_once APPPATH . 'Modules/Analytics/Config/Routes.php';

/*
 * --------------------------------------------------------------------
 * Public Profile Route (MUST be at the end to avoid conflicts)
 * --------------------------------------------------------------------
 * Reserved routes that cannot be used as usernames:
 * - admin, login, logout, register, api, l
 * - settings, dashboard, profile, profiles
 * - link, links, short, analytics, help
 * - about, contact, terms, privacy, static
 * - assets, uploads, images, css, js
 * - properties, templates (existing modules)
 */
$routes->get('(:segment)', 'App\Modules\Profile\Controllers\Frontend\ProfileController::show/$1');
$routes->get('(:segment)/qr', 'App\Modules\Profile\Controllers\Frontend\ProfileController::qrCodePage/$1');
$routes->get('(:segment)/qr.png', 'App\Modules\Profile\Controllers\Frontend\ProfileController::qrCode/$1');
