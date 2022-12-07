@extends ('layout.mainlayout')
@section('title', 'User Deleted')

@section('content')
    <h3>User Deleted List</h3>
    <div class="mt-3 d-flex justify-content-end">
        <a href="user" class="btn btn-primary">Back</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success mt-3">
            {{ session('status') }}
        </div>
    @endif
    <div class="mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($user as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->username}}</td>
                    <td>
                        @if($item->phone != "")
                        {{$item->phone}}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        <a href="/user-restore/{{$item->username}}">Restore</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection