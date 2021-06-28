<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('custom.auth', ['except' => ['loginGet', 'loginPost', 'registerGet', 'registerPost']]);
    }

    public function loginGet()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://auth-app:8000/api/auth/signin', $request->all())->json();
        if ($response && $response['status'] && $response['data']) {

            $cookie = cookie('api_token', $response['data']['token'], 20);

            return redirect('admin')->withCookie($cookie);
        } else {
            return view('auth.login');
        }
        return view('auth.login');
    }

    public function registerGet()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://auth-app:8000/api/auth/signup', $request->all())->json();

        if ($response && $response['status'] && $response['data']) {
            $cookie = cookie('api_token', $response['data']['token'], 20);
            return redirect('admin')->withCookie($cookie);
        } else {
            return view('auth.register');
        }
    }

    public function logout(Request $request)
    {
        $token = $request->api_token;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ])->delete('http://auth-app:8000/api/auth/signout')->json();
        Cookie::expire('api_token');

        return view('auth.login');
    }
}
