<?php
namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        
        $post = $post->index_data();
        return view('index',$post);
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
        $post = new Post();
        $post->storeData($request,$post);
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {             
        $data = $post->show_post($post);
        return view('show_post',['post'=>$post,'data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $post = new Post();
        $post->edit_post($request); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $post = Post::find($id);
        return view('edit',['post'=>$post]);
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
        $users->like_post($request);
        return back();      

    }
    public function show_like($id)
    {
        $user = User::findOrFail($id);
        return view('like',['user'=>$user]);
    }
    public function search(Request $request)
    {
        $post = new Post();
        $post = $post->search_data($request);
        return $post ? view('search',$post) : back();
    }
}
