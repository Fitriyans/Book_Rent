@extends('layouts.mainlayout')

@section('title','Delete User')
@section('content')
<h2>Are sure to delete this category {{$user->username}}?</h2>
<div class="mt-5">
    <a href="/user-destroy/{{$user->username}}" class="btn btn-danger me-3">Sure</a>
    <a href="/users" class="btn btn-primary">Cancel</a>
</div>
@endsection
    

{{-- @extends ('layout.mainlayout')
@section('title', 'Delete-User')

@section('content')
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h4>Are you Sure delete <span style="color: red; text-decoration: underline;">{{$user->username}}</span> ?</h4>
<div class="mt-4">
    <a href="/user-destroy/{{$user->slug}}" type="button" class="btn btn-primary">Sure</a>
    <a href="/users" type="button" class="btn btn-danger">Cancel</a>
</div>
@endsection --}}