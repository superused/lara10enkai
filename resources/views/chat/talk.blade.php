@extends('layouts.default')

@section('title','Chat.talk')

@include('layouts.menu.admin')

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
<h1 class="page-header">{{$event->name}}</h1>
@foreach($chats as $chat)
@if($event->id == $chat->event_id)
@if($chat->user_id == Auth::user()->id)
<div class="p-2 container w-75">
    <div class="p-1 ms-auto w-50 text-white rounded-1" style="background-color: limegreen;">
        {{$chat->name}}<br>
        {{$chat->body}}<br>
        {{$chat->updated_at}}<br>
    </div>
</div>
@else($chat->user_id != Auth::user()->id)
<div class="p-2 container w-75">
    <div class="p-1 me-auto w-50 rounded-1" style="background-color: white;">
        {{$chat->name}}<br>
        {{$chat->body}}<br>
        {{$chat->updated_at}}<br>
    </div>
</div>
@endif
@endif
@endforeach

<div class="p-2 container w-75 rounded-top border-bottom-0 border border-secondary" style="background-color: gainsboro;">投稿</div>
<div class="p-2 container w-75 border border-secondary" style="background-color: white;">
    <form action="{{route('admin.chat.store')}}" method="post">
        @csrf
        <label for="chat">投稿</label>
        <input type="text" class="form-control" name="body"><br>
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <input type="hidden" name="event_id" value="{{$event->id}}">
        <input type="submit" value="投稿">
</div>
</form>
@endsection