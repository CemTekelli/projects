@extends('layouts.index')

@section('title-page')
    <title>Innova Moving</title>
@endsection


@section('content')
    <header>
        @include('template.loader')
        @include('template.header')
    </header>
    <main>
        @include('template.moving.banner')
        @include('template.moving.content')

    </main>
    @include('template.footer')
@endsection
