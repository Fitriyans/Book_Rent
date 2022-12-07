@extends('layouts.mainlayout')

@section('title','Delete Category')
@section('content')
<h2>Are sure to delete this category {{$category->name}}?</h2>
<div class="mt-5">
    <a href="/category-destroy/{{$category->name}}" class="btn btn-danger me-3">Sure</a>
    <a href="/categories" class="btn btn-primary">Cancel</a>
</div>
@endsection
    
{{-- 
@extends ('layout.mainlayout')
@section('title', 'Delete-Category')

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
<h4>Are you Sure delete <span style="color: red; text-decoration: underline;">{{$categories->name}}</span> ?</h4>
<div class="mt-4">
    <a href="/categories-destroy/{{$categories->slug}}" type="button" class="btn btn-primary">Sure</a>
    <a type="button" class="btn btn-danger">Cancel</a>
</div>
@endsection --}}