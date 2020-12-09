<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        if (Auth::user()->is_admin == 1) {
            return redirect()->route('admin.index');
        }

        return redirect()->route('index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.show');
    }

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->phone=$request->phone;
        $user->role=$request->role;
        $user->address=$request->address;
        if ($request->hasFile('avatar')) {
            $cover = $request->file('avatar');
            $newFileName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999)) . "." . $cover->getClientOriginalExtension();
            $cover->storeAs('public/images', $newFileName);
            $user->image = $newFileName;
        }
        $user->save();
        return redirect()->route('index');

    }
}
