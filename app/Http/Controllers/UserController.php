<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AllPostsCollection;
use App\Services\FileService;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;
use Inertia\Inertia;

class UserController extends Controller
{
   
    public function show(string $username)
{
    $username = Str::lower($username);
    $user = User::where('username', $username)->first();
    if (!$user) {
        return redirect()->route('home.index');
    }
    $posts = $user->posts()->orderByDesc('created_at')->get();

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
