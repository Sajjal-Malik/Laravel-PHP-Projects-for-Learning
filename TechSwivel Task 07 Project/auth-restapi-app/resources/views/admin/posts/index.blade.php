@extends('layouts.app')

@section('title', 'Posts')

@section('content_header')
    <h1>Posts</h1>
@stop

@section('content')
    {!! $dataTable->table(['class' => 'table table-bordered table-striped']) !!}
@stop

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush