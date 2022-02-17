<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Log;
use App\Category;
use Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::all();
        $ranking = Post::withCount('likes')->orderBy('likes_count','desc')->get();
       
        return view('index',['data'=>$data,'ranking'=>$ranking]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unique = uniqid().'.jpeg';
        $post = new Post;
        if($request->file){
            $request->file->move(public_path('uploads/'),$unique);       
            $post->file_path = $unique;
        }
        
        $post->name = $request->name;
        $post->good = $request->good ?? '特になし';
        $post->bad = $request->bad ?? '特になし';
        $post->user_id = Auth::id();
        $post->save();

        $category = $request->tags;
        $category = explode(',',$category);

        foreach($category as $value){
            
            $tag = Category::firstOrCreate(['name' => $value]);
            $post->tags()->attach($tag->id);
        }
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('show_post',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->post_id);
        $post->delete();
        return back();

    }
    public function like(Request $request)
    {
        $users = User::find(Auth::id());
        $user = $users->likes
        ->where('id',$request->post_id)->count();      
        $user = !$user ? $users->likes()->attach($request->post_id) : $users->likes()->detach($request->post_id);
        return back();      

    }
    public function show_like($id)
    {
        $user = User::findOrFail($id);
        return view('like',['user'=>$user]);
    }
    public function search(Request $request)
    {
        $search = $request->q;
        if(substr($search,0,1) == '#'){
            $category = Category::where('name',$search)->get();
           
            return view('search',['data'=>$category]);

        }else{
            $post = Post::where('name',$search)->get();
           
            return view('search',['data'=>$post]);
        }
    }
}
