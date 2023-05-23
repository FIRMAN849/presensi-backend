@extends('dashboard.layouts.main')

@section('container')
 <h6>Welcome, {{ auth()->user()->nama }}</h6>   
@endsection