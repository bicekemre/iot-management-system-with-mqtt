<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $rules = [
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::class]
    ];


    public function auth()
    {
        if (\auth()->attempt()){
            return view('home.index');
        }
        return view('home.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->input('remember-me', false))) {
            return redirect()->route('home',['locale' => app()->getLocale()]);
        }else{
            return redirect()->route('auth')->withErrors(['email' => 'Invalid credentials', 'password' => 'Invalid credentials']);
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth');
    }
}
