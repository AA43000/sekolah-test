<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $req) {
        return view('login');
    }

    public function prosesLogin(Request $req) {
        $user = DB::table('users')->where('email', $req->email)->first();

        if($user) {
            if(Hash::check($req->password, $user->password)) {
                Auth::loginUsingId($user->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Login'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah, coba lagi!!'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan'
            ]);
        }
    }

    public function logout() {
        Auth::logout();

        return redirect('login');
    }
}
