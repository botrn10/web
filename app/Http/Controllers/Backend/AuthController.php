<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAdminRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function login()
    {

        return view('backend.auth.login');
    }

    public function postLogin(LoginAdminRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' =>  $request->password,
        ];
        if (Auth::attempt($credentials)) {

            return redirect()->route('get_admin.home');
        }
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('get_admin.login');
    }
}
