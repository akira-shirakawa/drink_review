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
    public function index()
    {
        $data = Post::latest()->take(6)->get();
        $ranking = Post::withCount('likes')->orderBy('likes_count','desc')->take(6)->get();
        $category = Category::withCount('posts')->orderBy('posts_count','desc')->take(6)->get();
       
        return view('index',['data'=>$data,'ranking'=>$ranking,'category'=>$category]);
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
        $search = $post->tags->first()->name;
        $data = Post::whereHas('tags', function($query) use($search){              
            $query->where('name', $search);
        })->get();
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
        $unique = uniqid().'.jpeg';
        $post = Post::find($request->post_id);
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
        $post->tags->each(function($tags){
            $tags->delete();
        });
        foreach($category as $value){
            
            $tag = Category::firstOrCreate(['name' => $value]);
            $post->tags()->attach($tag->id);
        }
       
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
        if($search == ""){
            return redirect('/');
        }
        if($search == "#sorting" || $search == "%23sorting"){
           
            $post = Post::withCount('likes')->orderBy('likes_count','desc')->paginate(10);
           
            return view('search',['data'=>$post,'search'=>$search]);
        }elseif($search == "#new" || $search == "%23new"){
            $post = Post::paginate(10);
            return view('search',['data'=>$post,'search'=>$search]);
        }
        if(substr($search,0,1) == '#' || substr($search,0,1) == '%23'){
           
            $category = Post::whereHas('tags', function($query) use($search){              
                $query->where('name', substr($search,1));
            })->paginate(10);
            
           
            return view('search',['data'=>$category,'search'=>$search]);

        }else{
            $post = Post::where('name','like',"%$search%")->paginate(2);
           
            return view('search',['data'=>$post,'search'=>$search]);
        }
    }
}
