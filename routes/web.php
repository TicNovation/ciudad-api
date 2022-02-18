<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function() use ($router) {

    $router->group(['middleware' => 'jwt.device'], function() use ($router){
        
        $router->post('user', ['uses' => 'UserController@save']);

        $router->post('categories', ['uses' => 'CategoryController@list']);

        $router->post('subcategories', ['uses' => 'SubCategoryController@list']);
        $router->post('subcategories/search', ['uses' => 'SubCategoryController@search']);

        $router->post('notis', ['uses' => 'NotiController@list']);
        $router->post('notis/search', ['uses' => 'NotiController@search']);

        $router->post('jobs', ['uses' => 'JobController@list']);
        $router->post('jobs/search', ['uses' => 'JobController@search']);
        $router->post('job/find', ['uses' => 'JobController@find']);
        $router->post('job/notifications/enable', ['uses' => 'JobController@enable']);
        $router->post('job/notifications/disable', ['uses' => 'JobController@disable']);

        $router->post('places', ['uses' => 'PlaceController@list']);
        $router->post('places/search', ['uses' => 'PlaceController@search']);

        $router->post('contacts', ['uses' => 'ContactController@list']);

        $router->post('info/find', ['uses' => 'InfoController@find']);

        $router->post('companies', ['uses' => 'CompanyController@list']);
        $router->post('companies/search', ['uses' => 'CompanyController@search']);
        $router->post('companies/fullsearch', ['uses' => 'CompanyController@fullsearch']);
        $router->post('companies/filter', ['uses' => 'CompanyController@filter']);

        $router->post('company/addresses', ['uses' => 'CompanyAddressController@list']);

        $router->post('company/schedule/list', ['uses' => 'CompanyScheduleController@find']);
        
        $router->post('company/menu/list', ['uses' => 'CompanyMenuController@list']);
        
    });

});