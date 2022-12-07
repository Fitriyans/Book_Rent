@extends('layouts.mainlayout')

@section('title','Registered Users')
@section('content')
    <h1>New Registered User List</h1>
    <div class="mt-5 d-flex justify-content-end">
        <a href="/users" class="btn btn-primary me-3">Approved User List</a>
        <a href="" class="btn btn-secondary">View Banned User</a>
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
                <th>Username</th>
                <th>Phone</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach($registeredUser as $item)
                <tr>
                    <td>{{$loop ->iteration}}</td> 
                    <td>{{$item ->username}}</td>
                    <td>
                     @if ($item ->phone)
                         {{$item ->phone}}   
                     @else
                         -
                     @endif
                    </td>
                    <td>
                         <a href="/user-detail/{{$item->username}}">Detail</a>
                    </td>
                 </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
    