<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AllPostsCollection;
use App\Services\FileService;
use App\Models\User;
use App\Models\Post;
use Inertia\Inertia;

class UserController extends Controller
{
   
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user === null){ return redirect()->route('home.index');}

        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return Inertia::render('User', [
            'user' => $user,
            'postsByUser' => new AllPostsCollection($posts)
        ]);
    }


    public function update(Request $request)
    {
        $request->validate(['file' => 'required|mimes:jpeg,jpg,png']);
        $user = (new FileService)->updateFile(auth()->user(), $request, 'user');
        $user->save();

        return redirect()->route('users.show', ['id' => auth()->user()->id]);
    }

}
