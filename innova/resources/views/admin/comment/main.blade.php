@extends('layouts.back')

@section('title-page')
    <h3>All comments</h3>

@endsection

@section('content')
    @include('layouts.flash')
    <div class="card">
        <div class="card-header">
            @php
            use App\Models\Comment;
                $comment = DB::table('comments')->where('validate', 0)->get();
            @endphp
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#xlarge">
                comment not validated ({{ count($comment) }})
            </button>

        </div>
        <div class="card-content">
            <div class="card-body container-fluid">
                <h3 class="text-center">Comments validated : </h3>
                <div class="row">
                    @forelse ($comments as $item)
                        @if ($item->validate)
                        <div class="col-sm-12 col-md-6 ">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <p class="my-0"><b>User :</b> {{ $item->user }} </p>
                                    <p class="my-0"><b>Email :</b> {{ $item->email }} </p>
                                    <p class="my-0"><b>Num :</b> {{ $item->number ? $item->number : "number not given" }} </p>
                                    <p class="my-0"><b>Product :</b> {{ $item->product->name }} </p>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <p><b>Message :</b></p>
                                    <p>{{ $item->commentaire}}</p>
            
                                </div>
                                <div class="col-sm-12 col-md-4 d-flex align-items-start">
                                    <form action="{{ route('product.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method("PUT")
                                        <input type="text" name="delnocheck" value="delnocheck" style="display: none"> 
                                        <button class="btn btn-danger mx-1">X</button>
                                    </form>
                        
                                    <a class="btn btn-primary" href="{{ route('product.show', $item->product->id) }}">product ?</a>
                                </div>

                            </div>
                            <hr class="my-3">
                        </div>
                        @endif
                    @empty 
                        <p class="text-center">no comment available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @include('partials.modal-comment')
@endsection
