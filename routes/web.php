<?php

$router->get('/', 'BlogController@index');
$router->get('/blog', 'BlogController@show');
$router->get('/write', 'BlogController@create');
$router->post('/write', 'BlogController@store');
$router->get('/profile', 'ProfileController@show');
$router->get('/posts', 'BlogController@posts');

// auth routes 
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');

$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

// terms
$router->get('/terms-and-conditions', 'UserController@terms');