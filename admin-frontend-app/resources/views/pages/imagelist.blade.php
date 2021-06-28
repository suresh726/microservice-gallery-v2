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
                <!-- Page Content -->
                <div class="container">

                    <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">Thumbnail Gallery of {{$selected_category['title']}}</h1>

                    <hr class="mt-2 mb-5">

                    <div class="row text-center text-lg-left">
                        @foreach($images as $key => $image)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="/image-detail/{{$image['id']}}" class="d-block mb-4 h-100">
                                <img class="img-fluid img-thumbnail" src={{$image['thumbnail_url']}} alt="">
                            </a>
                        </div>
                        @endforeach

                    </div>

                </div>
                <!-- /.container -->
            </div>
        </div>
    </div>
@endsection
