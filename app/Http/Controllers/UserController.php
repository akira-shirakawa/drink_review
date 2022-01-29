<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Auth;
class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrfail($id);
        return view('mypage',['user'=>$user]);
    }
    public function edit(Request $request)
    {
        Log::debug($request->file('file'));

        $unique = uniqid().'.jpeg';
        $user = User::find(Auth::id());
        if($request->file){
            $request->file->move(public_path('uploads/'),$unique);       
            $user->file_path = $unique;
        }
        
        $user->name = $request->name;
        $user->save();

    }
}
