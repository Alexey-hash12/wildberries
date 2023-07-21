<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function loginPage()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['error' => 'Неверный пароль или почта']);
        }

        return redirect()->route('index');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
