<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\ImageList;
use App\Jobs\ImageEntryCreated;

class CategoryCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $category = \App\Models\Category::create([
            'id' => $this->data['id'],
            'title' => $this->data['title']
        ]);

        // now fetch photos of this category from flickr

        $flickr_base_url = "https://www.flickr.com/services/rest/";
        $query_params = [
            'method' => 'flickr.photos.search',
            'api_key' => config('services.flickr.api_key'),
            'format' => 'json',
            'nojsoncallback' => 1,
            'tags'  => $category->title,
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
                    'thumbnail_url' => $photo['url_m'],
                    'category_id' => $category->id
                ]);

                ImageEntryCreated::dispatch($image_entry->toArray())->onQueue('image-detail');
            }
        }
    }
}
