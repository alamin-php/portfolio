<?php

namespace App\Http\Controllers\API;

use App\Post;
use Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::with('category', 'tag', 'user')->latest()->get();
        return $post;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'tag_id' => 'required',
            // 'user_id' => 'required',
            'title' => 'required|min:4|max:100',
            'details' => 'required|min:10',
        ]);

        $strpos = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . '.' . $ex;
        $img = Image::make($request->photo)->resize(500,333);
        $path = public_path() . '/assets/admin/image/post/';
        $img->save($path . $name);

        $post = new Post();
        $post->category_id = $request->category_id;
        $post->tag_id = $request->tag_id;
        $post->user_id = auth('api')->user()->id;
        $post->title = $request->title;
        $post->details = $request->details;
        $post->photo = $name;
        $post->save();
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $request->validate([
            'category_id' => 'required',
            'tag_id' => 'required',
            // 'user_id' => 'required',
            'title' => 'required|min:4|max:100',
            'details' => 'required|min:10',
        ]);

        if ($request->photo != $post->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time().'.'.$ex;
            $img = Image::make($request->photo)->resize(500,333);
            $path = public_path(). '/assets/admin/image/post/';
            $image = $path.$post->photo;
            $img->save($path.$name);

            if (file_exists($image)) {
            @unlink($image);
            }
        }else{
            $name = $post->photo;
        }

        $post->category_id = $request->category_id;
        $post->tag_id = $request->tag_id;
        $post->user_id = auth('api')->user()->id;
        $post->title = $request->title;
        $post->details = $request->details;
        $post->photo = $name;
        $post->save();
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $img_path = public_path(). '/assets/admin/image/post/';
        $image = $img_path.$post->photo;
        if (file_exists($image)) {
            @unlink($image);
        }
        $post->delete();
        return $post;
    }
}
