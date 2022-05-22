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
        
        $user = new User();
        $user->edit($request);
       

    }
}
