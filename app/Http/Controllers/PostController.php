<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
   
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

   
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post = (new FileService)->updateFile($post, $request, 'post');

        $post->user_id = auth()->user()->id;
        $post->text = $request->input('text');

        $post->save();

        return redirect('/');
    }


  
    public function edit(Post $post)
    {
        //
    }


    public function destroy($id)
    {
       $post = Post::find($id);

       if(!empty($post ->file)){
            $currentFile = public_path() . $post ->file;

            if(file_exists($currentFile)){
                unlink($currentFile);
            }
        }
        $post->delete();
    }
}
