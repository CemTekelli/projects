@extends('layouts.back')

@section('title-page')
<h3>Testimonials</h3>

@endsection

@section('content')
@include('layouts.flash')
<div class="card">
    <div class="card-header">
            <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal"
            data-bs-target="#largeCreate">
            Add a review
        </button>

    </div>
    <div class="card-content">
        <div class="card-body">
            <!-- Table with outer spacing -->
            <div class="table-responsive">

                <div class="container-fluid">
                    <div class="row respo-none">
                        <div class="col-1">
                            <span class="fw-bold">Nbr</span>
                        </div>
                        <div class="col-5">
                            <span class="fw-bold">OPINION</span>

                        </div>
                        <div class="col-2">
                            <span class="fw-bold">USER</span>

                        </div>
                        <div class="col-2">
                            <span class="fw-bold">RATING </span>

                        </div>
                        <div class="col-2">
                            <span class="fw-bold">ACTION</span>

                        </div>
                    </div>
                    <hr class="my-3">
                    @forelse ($testi as $item)
                        <div class="row mb-5 ">
                            @include('partials.modal-testi')

                            @php
                                $test = $item->avis;
                                $result = substr($test, 0, 65);
                                $result2 = $result . " ...";
                            @endphp
                            <div class="col-sm-12 col-md-1 respo-none">
                                <span>{{ $item->id }}.</span>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <span>{{ $result2 }}</span>

                            </div>
                            <div class="col-sm-12 col-md-2">
                                <span>{{ $item->user }}</span>

                            </div>
                            <div class="col-sm-12 col-md-2 respo-none">
                                <span>{{ $item->etoile }}</span>

                            </div>
                            <div class="col-2 d-flex align-items-start">

                                <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal"
                                    data-bs-target="#large-{{ $item->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('testimonial.destroy', $item->id) }}" method="post" class="mx-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>


                            </div>
                        </div>
                    @empty 
                    <p class="text-center">Empty for the moment . ..</p>
                    @include('partials.modal-testi')
                        
                    @endforelse
                </div>
            </div>
            @if (!isset($value))
            <div class="d-flex justify-content-center">
                {{ $testi->links('vendor.pagination.bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
