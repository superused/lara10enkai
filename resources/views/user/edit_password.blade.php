@extends('layouts.default')

@section('title','User.editPassword')

@include('layouts.menu.admin')

@section("content")
<h1 class="page-header">ユーザ編集</h1>
<form action="{{route('admin.user.update.password')}}" method="post">
    @method("PUT")
    @csrf
    <div class="form-group row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __("現在のパスワード")}}</label>
        <div class="col-md-6">
            <input type="password" id="password" class="form-control @error('current-password')is-invalid @enderror" name="current-password" required>
            @error("current-password")
            <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-group row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __("新しいパスワード")}}</label>
        <div class="col-md-6">
            <input type="password" id="password" class="form-control @error('password')is-invalid @enderror" name="password" required autocomplete="new-password">
            @error("password")
            <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-group row mb-3">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __("新しいパスワード（確認）")}}</label>
        <div class="col-md-6">
            <input type="password" id="password-confirm" class="form-control @error('password')is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>
    <div class="form-group row mb-3">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">{{__("更新")}}</button>
        </div>
    </div>
</form>
@endsection