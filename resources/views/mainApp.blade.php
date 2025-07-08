
@extends('layout')

@section('title', config('app.name') . "-Home Page")

@section('content')
    <image src="{{ asset('images/main.jpeg') }}" alt="photo view" class="centered-img">
@endsection