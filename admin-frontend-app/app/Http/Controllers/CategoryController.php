<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->api_token;
        $categories_response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ])->get('http://category-app:8000/api/categories')->json();
        $categories = [];
        if ($categories_response && count($categories_response) > 0) {
            $categories = $categories_response;
        }
        $view_elements = ['current_user' => $request->auth_user, 'categories' => $categories];
        return view('category.index', $view_elements);
    }

    public function create(Request $request)
    {
        $view_elements = ['current_user' => $request->auth_user];
        return view('category.create', $view_elements);
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$request->api_token
        ])->post('http://category-app:8000/api/categories', $request->all())->json();

        $view_elements = ['current_user' => $request->auth_user];
        return redirect('admin');
    }

    public function destroy(Request $request, $category_id)
    {
        $token = $request->api_token;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ])->delete('http://category-app:8000/api/categories/'.$category_id)->json();
        return redirect('admin');
    }
}
