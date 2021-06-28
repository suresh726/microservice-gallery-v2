<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CustomAuthentication
{

    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!$request->cookie('api_token')) {
            return redirect('/admin/login');
        }
        $token = $request->cookie('api_token');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ])->get('http://auth-app:8000/api/auth/current-user', $request->all())->json();

        if (!$response) {
            return redirect('/admin/login');
        }

        $request->merge(array("auth_user" => $response, 'api_token' => $token));
        return $next($request);
    }
}
