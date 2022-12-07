@extends('layouts.mainlayout')

@section('title','Deleted Book')
@section('content')
    <h1>Deleted Book List</h1>
    <div class="mt-5 d-flex justify-content-end">
        <a href="/books" class="btn btn-primary me-3">Back</a>
    </div>
    <div class="mt-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
    </div>
    <div class="my-5">
        <table class="table">
            <thead>
                <th>No.</th>
                <th>Code</th>
                <th>Title</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($deletedBooks as $item)
                    <tr>
                       <td>{{$loop ->iteration}}</td> 
                       <td>{{$item ->book_code}}</td>
                       <td>{{$item ->title}}</td>
                       <td>
                            {{-- <a href="category-edit/{{$item->name}}">Edit</a> --}}
                            <a href="/book-restore/{{$item->book_code}}">Restore</a>
                       </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
    