@extends('layouts.default')

@section("title","Home.index")

@include("layouts.menu.default")

@section('content')
<h1 class="page-header">イベント一覧</h1>
<table class="table table-striped" cellpadding="0" cellspaceing="0">
    <tr>
    <th scope="col">id</th>
    <th scope="col">イベント名</th>
    <th scope="col">最大参加人数</th>
    <th scope="col">現在の参加者数</th>
    <th scope="col">カテゴリ</th>
    <th scope="col">登録ユーザー名</th>
    <th scope="col">{{__('updated_at')}}</th>
    <th scope="col">アクション</th>
    </tr>
@foreach ($events as $event)
@if(!isset($event->deleted_at))
<tr>
<td>{{$event->id}}</td>
<td>{{$event->name}}</td>
<td>{{$event->max_participant}}</td>
@if($event->count==null)
<td>{{0}}</td>
@else
<td>{{$event->count}}</td>
@endif
<td>{{$event->category_name}}</td>
<td>{{$event->user_name}}</td>
<td>{{$event->updated_at}}</td>
<td class="actions text-nowrap">
<a class="btn btn-primary" href="{{route('show', $event->id)}}">表示</a>
</td>
</tr>
@endif
@endforeach
</table>
<div class="paginator">
    <ul class="pagination justify-content-center">
    {{$events->links()}}
</ul>
</div>
@endsection