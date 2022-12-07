@extends('layouts.mainlayout')

@section('title','Profile')
@section('content')
<div class="mt-5">
    <h2>Your Rent Logs</h2>
    <x-rent-log-table :rentlog='$rentLogs'/>
</div>
@endsection
    