<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ImageDetail;
use Illuminate\Support\Facades\Http;

class ImageEntryCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $flickr_base_url = "https://www.flickr.com/services/rest/";
        $query_params = [
            'method' => 'flickr.photos.getInfo',
            'api_key' => config('services.flickr.api_key'),
            'format' => 'json',
            'nojsoncallback' => 1,
            'photo_id' => $this->data['flickr_image_id']
        ];
        $results = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get($flickr_base_url, $query_params);

        $result = $results->json();
        $image_detail = [];

        if ($result && $payload = $result['photo'] ) {
            $image_detail = [
                'description' => $payload['description']['_content'],
                'views' => $payload['views'],
                'creation_date' => $payload['dates']['taken'],
                'upload_date' => $payload['dates']['posted'],
                'tags' => '',
                'full_image_url' =>  'https://live.staticflickr.com/'.$payload['server'].'/'.$payload['id'].'_'.$payload['secret'].'.'.$payload['originalformat'],
                'title' => $payload['title']['_content']
            ];
        }

        $db_payload = [
            'id' => $this->data['id'],
            'title' => $image_detail['title'],
            'description' => $image_detail['description'],
            'views' => $image_detail['views'],
            'creation_date' => $image_detail['creation_date'],
            'upload_date' =>  $image_detail['upload_date'],
            'tags' =>  $image_detail['tags'],
            'full_image_url' => $image_detail['full_image_url']
        ];

        $image_detail = ImageDetail::create($db_payload);

    }
}
