@extends('layouts.html')

@section('title', trans('titles.' . $text))

@section('content')
    @markdownFile($text)
@endsection
