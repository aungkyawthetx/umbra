<?php

$router->get('/', 'BlogController@index');
$router->get('/blog', 'BlogController@show');
$router->get('/blog/{slug}', 'BlogController@show');
$router->get('/write', 'BlogController@create');
$router->post('/write', 'BlogController@store');
$router->get('/blog/edit', 'BlogController@edit');
$router->post('/blog/update', 'BlogController@update');
$router->post('/blog/delete', 'BlogController@delete');
$router->post('/comment', 'BlogController@comment');
$router->post('/like', 'BlogController@like');
$router->get('/profile', 'ProfileController@show');
$router->get('/posts', 'BlogController@posts');
$router->get('/reading-list', 'ProfileController@readingList');

// auth routes 
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');

$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

// terms
$router->get('/terms-and-conditions', 'UserController@terms');

$router->post('/reading-list', 'ProfileController@store');
