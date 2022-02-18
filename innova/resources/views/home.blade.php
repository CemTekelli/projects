@extends('layouts.index')

@section('title-page')
    <title>Innova Furniture</title>
@endsection


@section('content')
    <header>
        @include('template.loader')
        @include('template.header')
    </header>
    <main>
        {{-- @foreach ($spec as $item)
            @foreach (json_decode($item->data) as $key => $value)
                <p>{{ $key }} : {{ $value }}</p>
                @endforeach
                {{ $item->product }}
                @endforeach --}}
        @include('template.home.banner')
        @include('template.home.popular')
        @include('template.home.best')
        @include('template.home.arrival')
        {{-- @include('template.home.productslike') --}}
        @include('template.home.inspired')
        @include('template.home.categories')
    </main>
    @include('template.footer')
@endsection
