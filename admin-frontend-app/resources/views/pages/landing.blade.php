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
                <div class="tab-content" id="nav-tabContent">
                    <h3>Select a category from the left to see images here</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
