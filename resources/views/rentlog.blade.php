@extends('layouts.mainlayout')

@section('title', 'Rent-Logs')

@section('content')

    <h1>Rent Log List</h1>
    
    <div class="mt-5">
      <x-rent-log-table :rentlog='$rentLogs'/>
    </div>

@endsection

