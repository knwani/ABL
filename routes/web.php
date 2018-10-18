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


Route::get('/event/{id}/{slug}', 'EventController@getEventData');

Route::get('/tenets/{id}/{tenet}/{article_name}', 'TenetController@getTenetData');

Route::get('/tenets/{tenet}', 'TenetsController@getTenets');

Route::get('/about-us', 'AboutController@getAuthors');

Route::get('/welcome-address', function () {
    return view('welcome');
});

Route::get('/unique-man', 'UniqueController@getAllData');
Route::get('/unique-man/{category}', 'UniqueController@getCategoryData');
//Route::get('/unique-man/gallery', 'FemController@getGallery');

Route::get('/unique-man/{category}/{id}/{title}', 'UniqueController@getSingleData');

Route::get('/feminique-woman', 'FemController@getAllData');
Route::get('/feminique-woman/{category}', 'FemController@getCategoryData');
Route::get('/gallery', 'FemController@getGalleryLink');
Route::get('/gallery/{folder}', 'FemController@getSingleGallery');
//Route::get('/feminique-woman/gallery', 'FemController@getGallery');

Route::get('/feminique-woman/{category}/{id}/{title}', 'FemController@getSingleData');

Route::get('/ask-kenny', 'QuestionsController@getQuestions');
Route::get('/ask-kenny/{id}/{title}', 'QuestionsController@getQuestionsWithOne');
Route::post('/save-question', 'QuestionsController@saveQuestion');
Route::post('/view-question', 'QuestionsController@viewQuestion');

Route::post('/save-newsletter-signup', 'HomeController@saveSignUp');

Route::get('/blog', 'BlogController@getBlogs');

Route::get('/blog/{id}/{title}', 'BlogController@getSingleBlog');

Route::get('/redirect/{provider}', 'QuestionsController@redirect');
Route::get('/callback/{provider}', 'QuestionsController@callback');

Route::get('/redirect-twitter', 'QuestionsController@redirectFacebook');
Route::get('/callback-twitter', 'QuestionsController@callbackFacebook');
