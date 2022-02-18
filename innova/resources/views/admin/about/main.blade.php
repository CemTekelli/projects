@extends('layouts.back')

@section('title-page')
    <h3>MISSION, VISION, VALEUR</h3>

@endsection

@section('content')
    @include('layouts.flash')
    @foreach ($abouts as $item)
    <div class="card w-75 mx-auto">
            @include('partials.modal-about')
            <div class="card-content">
                <div class="card-body">
                    @if ($loop->iteration == 1)
                        <h4 class="card-title">Mission :</h4>
                        
                    @elseif ($loop->iteration == 2)
                        <h4 class="card-title">Vision :</h4>
                    @else
                        <h4 class="card-title">Valeur :</h4>
                        
                    @endif
                    <p class="card-text">
                        {{$item->data}}
                    </p>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal"
                    data-bs-target="#large{{ $item->id }}">
                    Edit
                </button>
            </div>
        </div>
        
    @endforeach

@endsection
