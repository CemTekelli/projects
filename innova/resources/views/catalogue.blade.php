@extends('layouts.index')

@section('title-page')
    <title>Innova - Catalogue</title>
@endsection


@section('content')
    <header>
        @include('template.loader')
        @include('template.header')
    </header>
    <main>
        @include('template.banner')
   
        <h1 class="text-center">coming soon</h1>
    </main>
    @include('template.footer')
@endsection
