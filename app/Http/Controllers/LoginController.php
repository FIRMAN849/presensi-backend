<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        /* if ($user = Auth::user()) {
            if ($user->role == 'admin') {
                // return redirect()->intended('/dashboard');
                dd('berhasil login');
            }
        } */
        return view('login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');
        // $nis = Auth::user()->nis;
        // $password = Auth::user()->password;

        if (Auth::attempt($credentials)) {
            $user = User::where('username', $request->username)->first();
            if ($user->role == 'admin') {
                // return redirect()->route('admin.home');
                // $request->session->regenerate();
                return redirect()->intended('/dashboard');
            } else {
                // return redirect()->back()->with('error', 'Oppes! You have no permission to access this');
                return back()->with('loginError', 'Login Failed!');
            }
            //dd('bbb');
            // if (Auth::user()->nis == 'admin') {
            // }


            // dd($request);
        } else {
            return back()->with('loginError', 'Username / Password Salah');
        }
        // return back()->with('loginError', 'Login Failed!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
}
