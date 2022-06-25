<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return  view('login');
    }

    public function store(Request $request, Response $response)
    {
         $msg = ' اسم المستخدم أو كلمة السر غير صحيح ';
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required'
        ]);
        
      
        if(!auth()->attempt($request->only('username', 'password'),'on')){
            return response($msg, 422 );
        }

        //Redis::set('username',$request->username);
        //Redis::set('password', $request->password);
        return  true;
    }
}