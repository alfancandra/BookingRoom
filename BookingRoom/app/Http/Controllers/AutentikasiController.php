<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutentikasiController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginuser(Request $request)
    {
        // validasi data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try{
            $akun = $request->only('email','password');
            if(Auth::attempt($akun)){

                // Cek Status User
                if(Auth::user()->status == 1 && Auth::user()->role_id == 1){
                    return redirect() -> route('dashboard');
                }elseif(Auth::user()->status == 1 && Auth::user()->role_id == 2){
                    return redirect() -> route('dashboard');
                }else{
                    Auth::logout();
                    return redirect() -> route('login')-> with(['error' => 'Akun Nonaktif']);
                }

            }else{
                return redirect() -> route('login')-> with(['error' => 'Akun Nonaktif']);
            }
        }catch(QueryException $e){
            return redirect() -> route('login') -> with(['error' => $e->errorInfo]);
        }
        
    }
}
