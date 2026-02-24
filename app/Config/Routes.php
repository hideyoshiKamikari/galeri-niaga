<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/attempt', 'Auth::attempt');
// $routes->get('/logout', 'Auth::logout');
$routes->get('/admin', 'Admin::index', ['filter' => 'auth']);
$routes->post('/logout', 'Auth::logout');