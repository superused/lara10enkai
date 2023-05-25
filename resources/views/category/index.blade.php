@extends('layouts.default')

@section('title','Category.index')

@include('layouts.menu.admin')

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
<h1 class="page-header">カテゴリ一覧</h1>
<table class="table table-striped" cellpadding="0" cellspaceing="0">
    <tr>
    <th scope="col">ID</th>
    <th scope="col">カテゴリ名</th>
    <th scope="col">{{__('updated_at')}}</th>
    <th scope="col">アクション</th>
    </tr>
@foreach ($categories as $category)
<tr>
<td>{{$category->id}}</td>
<td>{{$category->name}}</td>
<td>{{$category->updated_at->format("Y年m月H時i分")}}</td>
<td class="actions text-nowrap">
<a class="btn btn-primary" href="{{route('admin.category.edit', $category->id)}}">編集</a>
<a class="btn btn-primary btn-danger" href="{{route('admin.category.delete', $category->id)}}">削除</a>
</td>
</tr>
@endforeach
</table>
<div class="paginator">
    <ul class="pagination justify-content-center">
        {{$categories->links()}}
    </ul>
</div>
@endsection