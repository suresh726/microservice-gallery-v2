<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ImageList;
use App\Jobs\ImageEntryCreated;

class ImageListController extends Controller
{
    public function testAction()
    {
        $flickr_base_url = "https://www.flickr.com/services/rest/";
        $query_params = [
            'method' => 'flickr.photos.search',
            'api_key' => config('services.flickr.api_key'),
            'format' => 'json',
            'nojsoncallback' => 1,
            'tags'  => 'cat',
            'extras' => 'url_m,description,url_l,date_upload,date_taken,tags,views',
            'page' => 1,
            'per_page' => 15
        ];
        $results = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get($flickr_base_url, $query_params);

        $result = $results->json();
        // dd($result);
        if ($result && $result['photos'] && $photos = $result['photos']['photo']) {
            foreach($photos as $key => $photo) {
                $image_entry = ImageList::create([
                    'flickr_image_id' => $photo['id'],
                    'title' => $photo['title'],
                    'thumbnail_url' => $photo['url_m'],
                    'category_id' => '1'
                ]);

                ImageEntryCreated::dispatch($image_entry->toArray())->onQueue('image-detail');
            }
         }

        return response()->json($result);
    }
    public function listImages(Request $request, $category_id)
    {
        $images = \App\Models\ImageList::where('category_id', '=', $category_id)->get();
        return response()->json($images);
    }

    public function getCategory(Request $request, $category_id)
    {
        $category = \App\Models\Category::find($category_id);
        return response()->json($category);
    }

    public function getCategoryByImage(Request $request, $image_id)
    {
        $image = \App\Models\ImageList::find($image_id);
        $category = \App\Models\Category::find($image->category_id);
        return response()->json($category);
    }
}
