<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{

    public function follow(Request $request)
    {
        $followedUser = User::findOrFail($request->user_id);

        $follower = new Follower();
        $follower->follower_id = auth()->user()->id;
        $follower->followed_id = $followedUser->id;
        $follower->save();

        return response()->json(['message' => 'You are now following the user.']);
    }

    
    public function unFollow()
    {
        $followedUser = User::findOrFail($request->user_id);

        // Delete the follower relationship if it exists
        Follower::where('follower_id', auth()->user()->id)
                ->where('followed_id', $followedUser->id)
                ->delete();

        return response()->json(['message' => 'You have unfollowed the user.']);
    }

}

    