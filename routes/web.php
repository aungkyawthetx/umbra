<?php

$router->get('/', 'BlogController@index');
$router->get('/blog', 'BlogController@show');
$router->get('/write', 'BlogController@create');
$router->post('/write', 'BlogController@store');
$router->get('/blog/edit', 'BlogController@edit');
$router->post('/blog/update', 'BlogController@update');
$router->post('/blog/delete', 'BlogController@delete');
$router->post('/comment', 'BlogController@comment');
$router->post('/like', 'BlogController@like');
$router->get('/profile', 'ProfileController@show');
$router->get('/posts', 'BlogController@posts');
<<<<<<< HEAD
$router->get('/post/edit', 'BlogController@edit');
=======
$router->get('/reading-list', 'ProfileController@readingList');
>>>>>>> 8064755b772de20b7e6cbec298583a53c8b4959e

// auth routes 
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');

$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

// terms
$router->get('/terms-and-conditions', 'UserController@terms');

$router->post('/reading-list', 'ProfileController@store');
