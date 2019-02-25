<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getUserRol', 'UserController@getUserRol');
Route::post('login', 'UserController@login');
Route::post('guest', 'UserController@guestToken');
Route::post('register','UserController@register');
Route::delete('deleteUser','UserController@deleteUser');
Route::post('forgotPass','UserController@forgotPassword');
Route::apiResource('users','UserController');
Route::apiResource('spots','SpotController')->middleware('check.token');
Route::put('users/changeBannedState/{user}','UserController@changeBannedState');
Route::post('img','ImageController@store');
Route::get('imgFull/{filename}','ImageController@getFullImage');
Route::get('imgLow/{filename}','ImageController@getLowImage');

Route::post('distance', 'SpotController@distance');
Route::post('checkSpotNear', 'SpotController@checkSpotNear');
Route::apiResource('tag', 'TagsController');
Route::apiResource('spotTag', 'SpotsTagController');
Route::apiResource('publicationTag', 'PublicationTagController');
Route::post('spotHasTags', 'SpotsTagController@spotHasTags');
Route::get('select', 'TagsController@selectTagByName');
Route::apiResource('publications', 'PublicationController');
Route::get('spotPublications', 'PublicationController@getSpotPublications');
