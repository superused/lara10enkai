@extends('layouts.default')

@section('title','Category.edit')

@include('layouts.menu.admin')

@section("content")
<h1 class="page-header row mb-2">カテゴリ編集</h1>
@if (count($errors) > 0)
<ul class="alert alert-danger" role="alert">
@foreach($errors->all() as $errror)
<li>{{$error}}</li>
@endforeach
</ul>
@endif

<form action="{{route('admin.category.update',$category->id)}}" method="post">
    @method("PUT")
    @csrf
    <div class="form-group row mb-2">
        <label for="name" class="row mb-2">カテゴリ名</label>
        <input class="form-control" type="text" name="name" value="{{old('name',$category->name)}}" required>
    </div>
    <input class="btn btn-primary row mb-2" type="submit" value="登録">
</form>
@endsection