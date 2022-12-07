@extends('layouts.mainlayout')

@section('title','Delete Book')
@section('content')
<h2>Are sure to delete this book {{$book->title}}?</h2>
<div class="mt-5">
    <a href="/book-destroy/{{$book->book_code}}" class="btn btn-danger me-3">Sure</a>
    <a href="/books" class="btn btn-primary">Cancel</a>
</div>
@endsection
    