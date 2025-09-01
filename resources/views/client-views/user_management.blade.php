@extends('layouts.client.app')
@section('title',"Client Dashboard")

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')





@endsection
