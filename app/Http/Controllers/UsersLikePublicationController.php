<?php

namespace App\Http\Controllers;

use App\users_like_publication;
use Illuminate\Http\Request;
use App\User;
use App\publication;

class UsersLikePublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'publications_tag' => publications_tag::all(),
        ]);
    }

   public function likePublication(Request $request)
    {

        $user_id = isset($request['user_id']) ? $request['user_id'] : parent::getUserId();
        $publication_id = $request['publication_id'];

        $user = User::find($user_id);
        $publication = publication::find($publication_id);

        if(is_null($user_id) || is_null($publication_id)){
            return parent::response("Something is null",400);
        }

        if(!$user){
            return parent::response("That users doesn't exist", 400);
        }
        
        if(!$publication){
            return parent::response("That publication  doesn't exist", 400);
        }
        
        //Ya le han dado like. 
        if (users_like_publication::where('user_id', $user_id)
        ->where('publication_id', $publication_id)->exists()) {   

            $publication->usersLiked()->detach($user);
            return parent::response("Publication disliked", 200);
        } else {

            $publication->usersLiked()->attach($user);
            return parent::response("Publication liked", 200);

        }                
    }

    public function isPublicationLikedByUser($publication_id, $user_id = null) {
        $user_id = isset($user_id) ? $user_id : parent::getUserId();
        $users_like_publication = users_like_publication::where('user_id', $user_id)
        ->where('publication_id', $publication_id)->exists();

        return response()->json([
            'is_liked' => $users_like_publication,
        ]);
    }

    public function getLikedPublications($user_id = null) {
        $user_id = isset($user_id) ? $user_id : parent::getUserId();
        $user = User::find($user_id);
        $publications = $user->publicationsLiked;

        return response()->json([
            'publications' => $publications,
        ]);
    }
    public function likesCountPublication($publication_id) {
        $users_like_publication = users_like_publication::where('publication_id', $publication_id)->get();

        return response()->json([
            'likes' => $users_like_publication->count(),
        ]);
    }

/*
    public function getTotalLikesCount($user_id) {
        $publicationsLiked = Publication::where('user_id', $user_id)->get();

        return response()->json([
            'likes' => $users_like_publication->count(),
        ]);
    }
*/
}
