<?php

    $router->get('/', 'BlogController@index');
    $router->get('/blog', 'BlogController@show');
    $router->get('/blog/{id}', 'BlogController@show');
    $router->get('/write', 'BlogController@create');
    $router->post('/write', 'BlogController@store');
    $router->get('/blog/edit', 'BlogController@edit');
    $router->post('/blog/update', 'BlogController@update');
    $router->post('/blog/delete', 'BlogController@delete');
    $router->post('/comment', 'BlogController@comment');
    $router->post('/like', 'BlogController@like');
    $router->get('/notifications', 'BlogController@notifications');
    $router->post('/notifications/read', 'BlogController@markNotificationsRead');
    $router->get('/profile', 'ProfileController@show');
    $router->get('/posts', 'BlogController@posts');
    $router->get('/reading-list', 'ProfileController@readingList');
    $router->post('/profile/update', 'ProfileController@update');

    // auth routes 
    $router->get('/register', 'AuthController@registerForm');
    $router->post('/register', 'AuthController@register');
    $router->get('/login', 'AuthController@loginForm');
    $router->post('/login', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');

    $router->get('/terms-and-conditions', 'UserController@terms');
    $router->get('/robots.txt', 'UserController@robots');
    $router->get('/sitemap.xml', 'UserController@sitemap');
    $router->post('/reading-list', 'ProfileController@store');
    $router->post('/reading-list/unfollow', 'ProfileController@unfollow');

?>
