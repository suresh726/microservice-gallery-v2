@extends('layouts.app-frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="list-group" id="list-tab" role="tablist">
                    @foreach($categories as $key => $cat)
                        <a class="list-group-item list-group-item-action" id="list-{{$cat['id']}}-list"  href="/image-list/{{$cat['id']}}">{{$cat['title']}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-10">
                @if($image)
                <div class=""row>
                    <div class="col-md-8">
                        <img src={{$image['full_image_url']}} />
                    </div>
                    <div class="col-md-4">
                        <h2>{{$image['title']}}</h2>
                        <a href="/image-list/{{$selected_category['id']}}">Gallery</a>
                    </div>
                </div>
                @else
                    <h3>Image Not Found</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
