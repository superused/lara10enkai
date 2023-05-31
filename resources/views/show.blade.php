@extends('layouts.default')

@section("title","Home.show")

@include("layouts.menu.default")

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
<h1 class="page-header">イベント表示</h1>
<table class="table table-striped" cellpadding="0" cellspaceing="0">
    <tr>
        <th scope="col">id</th>
        <th scope="col">イベント名</th>
        <th scope="col">最大参加人数</th>
        <th scope="col">カテゴリ</th>
        <th scope="col">登録ユーザー名</th>
        <th scope="col">{{__('updated_at')}}</th>
    </tr>
    @foreach ($events as $event)
    <tr>
        <td>{{$event->id}}</td>
        <td>{{$event->name}}</td>
        <td>{{$event->max_participant}}</td>
        <td>{{$event->category_name}}</td>
        <td>{{$event->user_name}}</td>
        <td>{{$event->updated_at}}</td>
    </tr>
</table>
<table class="table table-bordered border-primary">
    <tr>
        <th class="bg-primary text-white">現在の参加者数</th>
    </tr>
    <tr>
        <td>
            @if($event->count==null)
            {{0}}
            @else
            {{$event->count}}
            @endif
        </td>
    </tr>
    @endforeach
</table>

<div style="text-align: center;">
<a class="btn btn-primary" href="{{route('login')}}">ログインする</a>
</div>
@endsection