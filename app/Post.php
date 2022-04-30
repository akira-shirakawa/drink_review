<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use Auth;
use Illuminate\Support\Facades\Log;
class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Category');
    }
    public function likes()
    {
        return $this->belongsToMany('App\User');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function storeData($request,$post)
    {
        $unique = uniqid().'.jpeg';
       
       
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
        Log::debug('hoge');
    }
    public function index_data()
    {

        $data = Post::latest()->take(6)->get();
        $ranking = Post::withCount('likes')->orderBy('likes_count','desc')->take(6)->get();
        $category = Category::withCount('posts')->orderBy('posts_count','desc')->take(6)->get();
        return ['data'=>$data,'ranking'=>$ranking,'category'=>$category];
        
    }
    public function show_post($post)
    {
        $search = $post->tags->first()->name;
        $data = Post::whereHas('tags', function($query) use($search){              
            $query->where('name', $search);
        })->get();
        return $data;
    }
    public function edit_post($request)
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
    
    public function search_data($request)
    {
        $search = $request->q;
        if($search == ""){
            return false;
        }
        if($search == "#sorting" || $search == "%23sorting"){
           
            $post = Post::withCount('likes')->orderBy('likes_count','desc')->paginate(10);
           
            return ['data'=>$post,'search'=>$search];
        }elseif($search == "#new" || $search == "%23new"){
            $post = Post::paginate(10);
            return ['data'=>$post,'search'=>$search];
        }
        if(substr($search,0,1) == '#' || substr($search,0,1) == '%23'){
           
            $category = Post::whereHas('tags', function($query) use($search){              
                $query->where('name', substr($search,1));
            })->paginate(10);
            
           
            return ['data'=>$category,'search'=>$search];

        }else{
            $post = Post::where('name','like',"%$search%")->paginate(2);
           
            return   ['data'=>$post,'search'=>$search];
        }
    }
   
    
}
