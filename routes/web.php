<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::patch('/message/{id}',[
    'uses' => 'JobsController@deleteMessage'
]);




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/users','UsersController');
Route::resource('/clients','ClientsController');
Route::resource('/pricetags','PriceTagController');
Route::resource('/jobs','JobsController');
Route::resource('/technicians','TechnicianController');
Route::resource('/inspections', 'InspectionController');
Route::resource('/routebuilder','RouteBuilderController');

route::get('/reportclient', 'ReportController@generateByClient');
route::get('/loaddates', 'TechnicianController@getVisits');
route::get('/loadjobs', 'TechnicianController@getJobs');
Route::get('routebuilderjobs/', 'RouteBuilderController@getJobs');

