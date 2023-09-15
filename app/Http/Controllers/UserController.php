<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
    //     $username = $request->username;
    //     $password = $request->password;

    //     $user = User::where('username', $username)->first();
    //     if ($user) {
    //         dd(Hash::check($password, $user->$password));
    //         if (Hash::check($password, $user->$password)) {
    //             return view('home');
    //         } else {
    //             Session::flash('error', 'Password salah');
    //             return redirect('/login');
    //         }
    //     } else {
    //         Session::flash('error', 'Username tidak ditemukan');
    //         return redirect('/login');
    //     }
        if(Auth::attempt($request->only('username', 'password'))){
            return view('home');
        }
        Session::flash('error', 'Email atau Password salah');
        return redirect('/login');
    }
    

    public function register(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        if ($password != $password_confirmation) {
            Session::flash('error', 'Pastikan password konfirmasi benar!');
            return redirect('/register');
        }

        $user = new User;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->save();

        Session::flash('success', 'Registrasi berhasil!');
        return redirect('/login');
    }
}
