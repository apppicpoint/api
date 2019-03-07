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


// Points
Route::apiResource('spots','SpotController')->middleware('check.token');
Route::post('distance', 'SpotController@distance');
Route::post('checkSpotNear', 'SpotController@checkSpotNear');
Route::get('userSpots/{user_id}', 'SpotController@getUserSpots');


// Tags
Route::apiResource('tag', 'TagsController');
Route::apiResource('spotTag', 'SpotsTagController');
Route::apiResource('publicationTag', 'PublicationTagController');
Route::post('spotHasTags', 'SpotsTagController@spotHasTags');
Route::get('select', 'TagsController@selectTagByName');
Route::get('getSpotsByTag/{tag_id}', 'SpotsTagController@getSpotsByTag');
Route::get('getPublicationsByTag/{tag_id}', 'PublicationsTagController@getPublicationsByTag');


// Pics
Route::apiResource('publications', 'PublicationController');
Route::get('spotPublications/{spot_id}', 'PublicationController@getSpotPublications');
Route::get('userPublications/{user_id}', 'PublicationController@getUserPublications');

// Sistema de seguidores
Route::post('follow', 'UsersFollowUserController@followUser');
Route::post('unfollow', 'UsersFollowUserController@unfollowUser');
Route::get('isFollowing/{leader_id}/{follower_id?}', 'UsersFollowUserController@isUserFollowingUser');
Route::get('followings/{user_id?}', 'UsersFollowUserController@getLeaders');
Route::get('followers/{user_id?}', 'UsersFollowUserController@getFollowers');
Route::get('followersCount/{leader_id?}', 'UsersFollowUserController@getFollowersCount');
Route::get('followingsCount/{follower_id?}', 'UsersFollowUserController@getFollowingsCount');

// Sistema de likes
Route::post('like', 'UsersLikePublicationController@likePublication');
Route::get('isLiked/{publication_id}/{user_id?}', 'UsersLikePublicationController@isPublicationLikedByUser');
Route::get('likesCount/{publication_id}', 'UsersLikePublicationController@getLikesCount');
Route::get('getLikedPublications/{user_id?}', 'UsersLikePublicationController@getLikedPublications');

// Sistema de comentarios
Route::apiResource('comments','CommentController')->middleware('check.token');





