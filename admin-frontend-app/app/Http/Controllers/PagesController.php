<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{
    public function index(Request $request)
    {

        $view_elements = ['categories' => $this->getCategories()];
        return view('pages.landing', $view_elements);
    }

    public function imagesByCategory(Request $request, $category_id)
    {
        $image_list_response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('http://imagelist-app:8000/api/image-list/'.$category_id)->json();
        $images = [];
        if ($image_list_response && count($image_list_response) > 0) {
            $images = $image_list_response;
        }
//        dd($image_list_response);

        $view_elements = ['images' => $images, 'categories' => $this->getCategories(), 'selected_category' => $this->getCategoryDetailByCategoryID($category_id)];
        return view('pages.imagelist', $view_elements);
    }

    public function imageDetail(Request $request, $image_id)
    {
        $image_detail_response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('http://imagedetail-app:8000/api/image-detail/'.$image_id)->json();
        $image = [];
//        dd($image_detail_response);
        if ($image_detail_response && count($image_detail_response) > 0) {
            $image = $image_detail_response[0];
        }
        $view_elements = ['image' => $image, 'categories' => $this->getCategories(), 'selected_category' => $this->getCategoryDetailByImageId($image_id)];
        return view('pages.imagedetail', $view_elements);
    }

    private function getCategories()
    {
        $categories_response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('http://category-app:8000/api/categories')->json();
        $categories = [];
        if ($categories_response && count($categories_response) > 0) {
            $categories = $categories_response;
        }
        return $categories;
    }

    private function getCategoryDetailByCategoryID($category_id)
    {
        $categories_response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('http://imagelist-app:8000/api/category/'.$category_id)->json();
        $category = [];
        if ($categories_response && count($categories_response) > 0) {
            $category = $categories_response;
        }
        return $category;
    }

    private function getCategoryDetailByImageId($image_id)
    {
        $categories_response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get('http://imagelist-app:8000/api/category-by-image-id/'.$image_id)->json();
        $category = [];
        if ($categories_response && count($categories_response) > 0) {
            $category = $categories_response;
        }
        return $category;
    }


}
