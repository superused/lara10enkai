@extends('layouts.default')

@section('title','Event.create')

@include('layouts.menu.admin')

@section("content")
<h1 class="page-header">イベント新規登録</h1>
@if (count($errors)>0)
<ul class="alert alert-danger" role="alert">
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
@endforeach
</ul>
@endif
<form action="{{route('admin.event.store')}}" method="post">
    @csrf
    <div class="form-group row mb-3">
        <label for="name">名前</label>
        <input class="form-control" type="text" name="name" value="{{old('name')}}" required>
    </div>
    <div class="form-group row mb-3">
        <label for="detail">詳細</label>
        <textarea class="form-control" name="detail" cols="30" rows="2" required></textarea>
    </div>
    <div class="form-group row mb-3">
        <label for="max_participant">最大参加者</label>
        <input class="form-control" type="text" name="max_participant" value="{{old('max_participant')}}" required>
    </div>
    <div class="form-group row mb-3">
        <label for="category">カテゴリ</label>
        <select class="form-control" id="category" name="category_id">
            @foreach ($categories as $categories)
            <option value="{{$categories->id}}">{{$categories->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group row mb-3">
        <label for="user">ユーザ</label>
        <select class="form-control" id="user" name="user_id">
            @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
        </select>
    </div>
    <input class="btn btn-primary" type="submit" value="登録">
</form>
@endsection
