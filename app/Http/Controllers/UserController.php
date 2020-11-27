<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showFormLogin()
    {
        return view('frontend.login.login');
    }

    public function showFormRegister()
    {
        return view('frontend.login.register');
    }

    public function login(LoginRequest $request)
    {
        $data = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if (!Auth::attempt($data)){
            return back();
        }

        if (Auth::user()->is_amin == 1) {
            return redirect()->route('admin.index');
        }

        return redirect()->route('index');
    }
}
