<?php

namespace App\Http\Controllers;

use App\users_follow_user;
use Illuminate\Http\Request;
use App\User;


class UsersFollowUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'followings' => users_follow_user::all(),
        ]);
    }
    

    public function followUser(Request $request)
    {
        $leader_id = $request['leader_id'];
        $follower_id = $request['follower_id'];

        $leaderUser = User::find($leader_id);
        $followerUser = User::find($follower_id);

        if ($leader_id == $follower_id) {
            return parent::response("An user cannot follow itself",400);
        }
        if (users_follow_user::where('leader_id', $leader_id)
        ->where('follower_id', $follower_id)->exists()) {             
            return parent::response("Relationship already exists",400);
        } 

        if(is_null($leader_id) || is_null($follower_id)){
            return parent::response("Something is null",400);
        }

        if(!$leaderUser){
            return parent::response("That followed users doesn't exist", 400);
        }
        
        if(!$followerUser){
            return parent::response("That follower user doesn't exist", 400);
        }
        if(!$followerUser){
            return parent::response("That follower user doesn't exist", 400);
        }


        $leaderUser->followers()->attach($follower_id);
        return parent::response("User followed", 200);
    }

    public function unFollowUser(Request $request)
    {
      $leader_id = $request['leader_id'];
        $follower_id = $request['follower_id'];

        $leaderUser = User::find($leader_id);
        $followerUser = User::find($follower_id);

        if (!users_follow_user::where('leader_id', $leader_id)
        ->where('follower_id', $follower_id)->exists()) {
             
             return parent::response("Relationship doens't exists",400);
         } 

        if(is_null($leader_id) || is_null($follower_id)){
            return parent::response("Something is null",400);
        }

        if(!$leaderUser){
            return parent::response("That followed users doesn't exist", 400);
        }
        
        if(!$followerUser){
            return parent::response("That follower user doesn't exist", 400);
        }

        $leaderUser->followers()->detach($follower_id);
        return parent::response("User unfollowed", 200);
    }

    public function show(Request $request)
    {
        $user = User::find($userId);
        $followers = $user->followers;
        $followings = $user->followings;
        return view('user.show', compact('user', 'followers' , 'followings'));
    }

    public function destroy(users_follow_user $users_follow_user)
    {

        if (parent::checkLogin() && parent::getUserFromToken()->id == $users_follow_user->follower_id || parent::getUserRol() == 1){
            $users_follow_user->delete();
            return parent::response("User unfollowed", 200);
        }
    }

    
    public function isUserFollowingUser(Request $request) {
        $leader_id = $request['leader_id'];
        $follower_id = $request['follower_id'];
        $users_follow_user = users_follow_user::where('leader_id', $leader_id)
        ->where('follower_id', $follower_id)->exists();

        return response()->json([
            'is_following' => $users_follow_user,
        ]);
    }

    public function getFollowers(Request $request) {

        $userId = $request['user_id']; 
        $user = User::find($userId);
        $followers = $user->followers;
        
        if (count($followers) <= 0) {
            parent::response("Nobody follows you", 200);
        }

        return response()->json([
            'followers' => $followers,
        ]);
        
    }

    public function getLeaders(Request $request) {
        $userId = $request['user_id']; 
        $user = User::find($userId);        
        $leaders = $user->followings;
        if (count($leaders) <= 0) {
            return parent::response("You don't have friends",200);
        }
        return response()->json([
            'leaders' => $leaders,
        ]);
    }


}
