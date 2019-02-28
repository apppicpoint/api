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

// Usuarios
Route::get('getUserRol', 'UserController@getUserRol');
Route::post('login', 'UserController@login');
Route::post('guest', 'UserController@guestToken');
Route::post('register','UserController@register');
Route::delete('deleteUser','UserController@deleteUser');
Route::post('forgotPass','UserController@forgotPassword');
Route::apiResource('users','UserController');
Route::put('users/changeBannedState/{user}','UserController@changeBannedState');

// Imagenes 
Route::post('img','ImageController@store');
Route::get('imgFull/{filename}','ImageController@getFullImage');
Route::get('imgLow/{filename}','ImageController@getLowImage');


// Spots
Route::apiResource('spots','SpotController')->middleware('check.token');
Route::post('distance', 'SpotController@distance');
Route::post('checkSpotNear', 'SpotController@checkSpotNear');

// Tags
Route::apiResource('tag', 'TagsController');
Route::apiResource('spotTag', 'SpotsTagController');
Route::apiResource('publicationTag', 'PublicationTagController');
Route::post('spotHasTags', 'SpotsTagController@spotHasTags');
Route::get('select', 'TagsController@selectTagByName');

// Pics
Route::apiResource('publications', 'PublicationController');
Route::get('spotPublications/{spot_id}', 'PublicationController@getSpotPublications');
Route::get('userPublications/{user_id}', 'PublicationController@getUserPublications');

// Sistema de seguidores
Route::post('follow', 'UsersFollowUserController@followUser');
Route::post('unfollow', 'UsersFollowUserController@unfollowUser');
Route::post('isFollowing', 'UsersFollowUserController@isUserFollowingUser');
Route::post('followings', 'UsersFollowUserController@getLeaders');
Route::post('followers', 'UsersFollowUserController@getFollowers');

// Sistema de likes
Route::post('like', 'UsersLikePublicationController@likePublication');
Route::post('isLiked', 'UsersLikePublicationController@isPublicationLikedByUser');
Route::get('likesCount/{publication_id}', 'UsersLikePublicationController@getLikesCount');





