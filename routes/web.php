<?php

$router->get('/', 'BlogController@index');
$router->get('/blog', 'BlogController@show');
$router->get('/write', 'BlogController@create');
$router->post('/write', 'BlogController@store');
$router->get('/profile', 'UserController@profile');