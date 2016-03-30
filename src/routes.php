<?php
// API RESTful Routes

// Default response
$app->get('/', 'App\Controller\Base:welcome');

// V1 REST API
$app->group('/v1', function() use($app)
{
    // Default response for /api/v1
    $app->get('/', 'App\Controller\Base:welcome');

    // Authentication
    $app->post('/token', 'App\Controller\Authentication:login');

    // Cities
    $app->group('/city', function() use($app)
    {
        $app->get('(/:id)', 'App\Controller\City:get');
        $app->post('/', 'App\Controller\City:post');
        $app->put('/:id', 'App\Controller\City:put');
        $app->delete('/:id', 'App\Controller\City:delete');
    });

    // Categories
    $app->group('/category', function() use($app)
    {
        $app->get('(/:id)', 'App\Controller\Category:get');
        $app->post('/', 'App\Controller\Category:post');
        $app->put('/:id', 'App\Controller\Category:put');
        $app->delete('/:id', 'App\Controller\Category:delete');
    });

    // Businesses
    $app->group('/business', function() use($app)
    {
        $app->get('(/:id)', 'App\Controller\Business:get');
        $app->post('/', 'App\Controller\Business:post');
        $app->put('/:id', 'App\Controller\Business:put');
        $app->delete('/:id', 'App\Controller\Business:delete');
    });

    // Users
    $app->group('/user', function() use($app)
    {
        $app->get('(/:id)', 'App\Controller\User:get');
        $app->post('/', 'App\Controller\User:post');
        $app->put('/:id', 'App\Controller\User:put');
        $app->delete('/:id', 'App\Controller\User:delete');
    });
});
