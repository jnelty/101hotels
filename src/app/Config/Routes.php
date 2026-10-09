<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('register', 'Auth::registerForm', ['filter' => 'guest']);
$routes->post('register', 'Auth::register', ['filter' => 'guest']);
$routes->get('login', 'Auth::loginForm', ['filter' => 'guest']);
$routes->post('login', 'Auth::login', ['filter' => 'guest']);
$routes->get('logout', 'Auth::logout');

$routes->get('comments', 'Comments::index', ['filter' => 'auth']);
$routes->post('comments', 'Comments::store', ['filter' => 'auth']);
$routes->get('comments/(:num)/edit', 'Comments::edit/$1', ['filter' => 'auth']);
$routes->post('comments/(:num)/edit', 'Comments::update/$1', ['filter' => 'auth']);
$routes->post('comments/(:num)/delete', 'Comments::delete/$1', ['filter' => 'auth']);
