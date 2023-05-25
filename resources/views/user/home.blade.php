@extends('layouts.default')

@section("title", "User.index")

@include("layouts.menu.admin")

@section('content')
<div class="row mx-auto">
    <div class="col-md-5">
        <div class="list-group">
            @foreach($homeMenus as $text => $link)
                <a href="{{$link}}" class="list-group-item">{{$text}}</a>
            @endforeach
        </div>
    </div>
</div>
@endsection
