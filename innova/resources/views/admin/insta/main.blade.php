@extends('layouts.back')

@section('title-page')
    <h3>Gallery insta</h3>

@endsection

@section('content')
    @include('layouts.flash')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#largeCreate">
                Add
            </button>

        </div>
        <div class="card-content">
            <div class="card-body">
               @foreach ($instas as $item)
                   <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#Large{{ $item->id }}">
                        post : {{ $item->id }}
                    </button>
                @include('partials.modal-insta')
               @endforeach
            </div>
        </div>
    </div>
@endsection
