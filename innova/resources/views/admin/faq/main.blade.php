@extends('layouts.back')

@section('title-page')
    <h3>FAQ</h3>

@endsection

@section('content')
    @include('layouts.flash')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faqmodalcreate">
                Add an ask
            </button>
        </div>
        <div class="card-content">
            <div class="card-body">
                <!-- Table with outer spacing -->
                <div class="table-responsive">

                    <div class="container-fluid">
                        <div class="row respo-none">
                            <div class="col-sm-6 col-md-1">
                                <span class="fw-bold">Nbr</span>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <span class="fw-bold">ASK</span>

                            </div>
                            <div class="col-sm-6 col-md-5">
                                <span class="fw-bold">RESPONSE</span>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <span class="fw-bold">ACTION</span>
                            </div>
                        </div>
                        <hr class="my-3">
                        @forelse ($faq as $item)
                        <div class="row mb-5">
                                @include('partials.modal-faq')

                                @php
                                    $test = $item->reponse;
                                    $result = substr($test, 0, 50);
                                    $result2 = $result . ' ...';
                                @endphp
                                <div class="col-sm-12 col-md-1 ">
                                    <span>{{ $item->id }}.</span>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <span>{{ $item->ask }}</span>

                                </div>
                                <div class="col-sm-12 col-md-5">
                                    <span>{{ $result2 }}</span>

                                </div>

                                <div class="col-sm-12 col-md-2 d-flex align-items-start">

                                    <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal"
                                        data-bs-target="#large-{{ $item->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('faq.destroy', $item->id) }}" method="post"
                                        class="mx-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>


                                </div>
                            </div>
                        @empty 
                            <p class="text-center">Empty for the moment . ..</p>
                            @include('partials.modal-faq')

                        @endforelse
                    </div>
                </div>
                @if (!isset($value))
                    <div class="d-flex justify-content-center">
                        {{ $faq->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
