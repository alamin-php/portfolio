<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

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
            'user_id' => 'required',
            'title' => 'required|min:4|max:100',
            'details' => 'required|min:10',
        ]);

        $post = new Post();
        $post->category_id = $request->category_id;
        $post->tag_id = $request->tag_id;
        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->details = $request->details;
        $post->photo = $request->photo;
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
            'user_id' => 'required',
            'title' => 'required|min:4|max:100',
            'details' => 'required|min:10',
        ]);

        $post->category_id = $request->category_id;
        $post->tag_id = $request->tag_id;
        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->details = $request->details;
        $post->photo = $request->photo;
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
        //
    }
}
