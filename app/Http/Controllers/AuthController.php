<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('admin.property.index'));
        }

        return back()->withErrors([
            'email' => 'Identifiants Incorrect'
        ])->onlyInput('email');

    }

    public function logout()
    {
        Auth::logout();
        return to_route('login')->with('success', 'Vous ếtes maintenant déconnecté');
    }

}
