@extends('layouts.back')

@section('title-page')
    <h3>Products Search</h3>

@endsection
@section('content')
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
        <h4 class="text-center">{{ count($products) }} Product(s) found for : "{{ $value }}"</h4>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products->reverse()  as $item)
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
                        </tr>
                        
                @endforeach
            
                </tbody>
            </table>
        </div>
    
    </div>

@endsection
