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

/*Route::get('/', function () {
    return view('home');
});

getAllData*/
Route::get('/', 'HomeController@getAllData');


Route::get('/event/{id}', 'EventController@getEventData');

Route::get('/tenets/{id}/{tenet}/{article_name}', 'TenetController@getTenetData');

Route::get('/tenets/{tenet}', 'TenetsController@getTenets');

Route::get('/about-us', function () {
    return view('about');
});



Route::get('/feminique-woman', 'FemController@getAllData');
Route::get('/feminique-woman/{category}', 'FemController@getCategoryData');

Route::get('/feminique-woman/{category}/{id}/{title}', 'FemController@getSingleData');

Route::get('/ask-kenny', 'QuestionsController@getQuestions');
Route::post('/save-question', 'QuestionsController@saveQuestion');

Route::get('/blog', 'BlogController@getBlogs');

Route::get('/redirect-facebook', 'QuestionsController@redirect');
Route::get('/callback-facebook', 'QuestionsController@callback');
