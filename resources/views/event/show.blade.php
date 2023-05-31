@extends('layouts.default')

@section('title','Event.show')

@include('layouts.menu.admin')

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
@if (session('delete'))
<div class="alert alert-danger" role="alert">{{session('delete')}}</div>
@endif
@if((!session('delete')) && (empty($eventusers->all()) || (!in_array($currentuser, $participants))))
<div class="alert alert-success" role="alert">イベントに参加していません</div>
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
    @endforeach
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
</table>

<h1 class="page-header">イベント参加者</h1>
<table class="table table-striped" cellpadding="0" cellspaceing="0">
    <tr>
        <th scope="col">ユーザID</th>
        <th scope="col">ユーザ名</th>
        <th scope="col">登録日時</th>
    </tr>
    @foreach ($eventusers as $eventuser)
    @if(!isset($eventuser->deleted_at))
    <tr>
        <td>{{$eventuser->user_id}}</td>
        <td>{{$eventuser->name}}</td>
        <td>{{$eventuser->created_at}}</td>
    </tr>
    @endif
    @endforeach
</table>
@if(empty($eventusers->all()) || (!in_array($currentuser, $participants)))
<form action="{{route('admin.eventusers.store')}}" method="post">
        @csrf
        <div style="text-align: center;">
        <input type="hidden" name="event_id" value="{{$currentevent->id}}">
        <input type="hidden" name="user_id" value="{{$currentuser}}">
        <input class="btn btn-primary" type="submit" value="このイベントに参加する">
        </div>
        @else
        <form action="{{route('admin.eventusers.delete',$currentevent->id)}}" method="post">
            @csrf
            <div style="text-align: center;">
            <a class="btn btn-primary" href="{{route('admin.chat.talk',$currentevent->id)}}">チャットに参加する</a>
            <input type="hidden" name="user_id" value="{{$currentuser}}">
            <input class="btn btn-danger" type="submit" value="このイベントから辞退する">
            </div>
            <br>
@endif
@endsection