@extends('layouts.back')

@section('title-page')
    <h3>Parteners</h3>

@endsection

@section('content')
    @include('layouts.flash')
    
    <div class="card">
        <div class="card-header">
            <form class="d-flex align-items-center justify-content-center cbx-ciblig" action="{{ route("parteners.store") }}" method="post" enctype="multipart/form-data">
                @csrf                    
                <input required class="form-control w-50 mx-4 my-3 image-add-store " type="file" name="image">
                <button class="btn btn-primary">Add</button>
            </form>
            <p class="text-center">Avant d'upload, compresse tes images sur <a target="_blank" class="d-inline" style="color: blue" href="https://tinypng.com/">tinypng.com</a></p>

        </div>
        <div class="card-content">
            <div class="card-body">
               <div class="row">
                   @foreach ($parteners as $item)
                    <div class="col-sm-12 col-md-3 block-image text-center">
                        <img width="150" src={{ asset('img/partners/' . $item->img) }}  alt="{{ $item->img }}"/>
                        <div class="block-overlay rounded">
                            <div class="block-btn-addcart">
                                <a href="{{ route('parteners.destroy', $item->id) }}">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                       
                   @endforeach
               </div>
           
            </div>
        </div>
    </div>

@endsection
