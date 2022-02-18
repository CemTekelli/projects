@extends('layouts.back')

@section('title-page')
    <h3>Products Indoor</h3>

@endsection
@section('content')
    @include('layouts.flash')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between flex-wrap">
                <a href="{{ route('product.create') }}"><button class="btn btn-primary">Add product</button></a>
                <form action="{{ route('search.back') }}"  class="form-group d-flex">
                    <input name="filter[name]" class="form-control w-auto" type="text" placeholder="product ?">
                    <button class="btn"><i class="bi bi-search"></i></button>
                </form>
                

            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr class="respo-tel">
                        <th><i class="bi bi-image"></i></th>
                        <th>NAME</th>
                        <th>PRIC€</th>
                        <th>COMMENTS</th>
                        <th>POPULAR</th>
                        <th>CATEGORIES</th>
                        <th>ACTION</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products->reverse()  as $item)
                    @if ($item->type == 'indoor')
                        <tr class="respo-body-tel">
                            @if (File::exists(public_path('img/productUpload/' . $item->images[0]->img)))
                                    <td ><img height="60px" src="{{ asset('img/productUpload/'.$item->images[0]->img ) }}" alt="a"></td>
                                @else
                                    
                                    <td ><img height="60px" src="{{ asset('img/innovaImg/'.$item->images[0]->img ) }}" alt="a"></td>
                                    
                                @endif
                            <td >{{ $item->name }}</td>
                            <td>{{ $item->price }}€</td>
                            <td>{{ count($item->comments) }}</td>
                            <td >{{ $item->popular ? "True" : "false" }}</td>
                            <td>
                                @foreach ($item->categories as $categ)
                                    {{ $categ->name }},
                                @endforeach
                            </td>
                            <td >
                                <a href="{{ route('product.show', $item->id) }}">
                                    <button class="btn btn-primary">show</button>
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#small">
                                    x
                                </button>
                            </td>
                        </tr>
                            {{-- -------------- DELETE THIS PRODUCT --}}
                            <div class="modal fade text-left" id="small" tabindex="-1" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body d-flex justify-content-center">
                                            <form action="{{ route('product.delete', $item->id) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-outline-danger" >Definitive</button>
                                            </form>

                                        </div>
                                
                                    </div>
                                </div>
                            </div>
                    @endif
                @endforeach
            
                </tbody>
            </table>
        </div>
        @if (!isset($value))
            <div class="mx-auto">
                {{ $products->links('vendor.pagination.bootstrap-4') }}
            </div>    
        @endif
    </div>

@endsection
