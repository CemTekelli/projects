@extends('layouts.index')

@section('title-page')
    <title>Innova - Product</title>
@endsection

@section('content')
<header>
    @include('template.loader')
    @include('template.header')
</header>
<main>
    @include('template.banner')
    <section class="properties new-arrival fix">

        <div class="container" id="remonteHaut">
            <div class="row justify-content-center position-relative">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="section-tittle mb-60 text-center wow fadeInUp respo-title-cat" data-wow-duration="1s"
                        data-wow-delay=".2s">
                        <h2>{{ __('messages.title_product') }}</h2>
                        <p id="countProduct">{{ $count_product }} {{ __('messages.found') }}</p>
                    </div>

                </div>

                {{-- BARRE de recherche --}}
                {{-- <div class="header-right1 d-flex align-items-center position-absolute">
                            <div class="search">
                            <ul class="d-flex align-items-center">
                                <li>
                                    <form action="#" class="form-box f-right ">
                                        <input type="text" name="Search" placeholder="Search products">
                                        <div class="search-icon">
                                            <i class="ti-search"></i>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                            </div>
                        </div> --}}
            </div>
            {{-- @php
            $price = ["50-100", "100-250", "250-500", "1000-2000", "2000-5000"];
            @endphp
            <div class="categories-wrapper  translate-middle-y " id="rangeSearch">
                <div class="row justify-content-sm-center  justify-content-md-end">
                    <div class="col-4">
                        <div class="select-categories">
                            <form class="range-form" action="{{ route('ayhan') }}" method="post">
                                @csrf
                                <select name="select">
                                    <option value="">Price range </option>
                                    @foreach ($price as $item)
                                    <option {{ $data == $item ? "selected" : "" }} value="{{ $item }}">
                                        {{ $item}} €
                                    </option>
                                    @endforeach

                                </select>
                                <button class="btn-range"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}

            
            {{-- BTN AUTRE PAGE PC avec ce qu'il manque --}}
            <div class="categories-wrapper  translate-middle-y other-one d-md-block" id="rangeSearch">
                <div class="row justify-content-sm-center">
                    <div class="col-12">
                        <div class="select-categories cat-other">

                            <div class="dropdown">
                                <button class="dropdown-toggle " type="button" id="dropdownMenu2" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    {{ __('messages.other') }}
                                </button>
                                <ul class="dropdown-menu" id="portfolio-flters">

                                    {{-- LANG LOGIQUE --}}
                                    @if (App::getLocale() === "fr")
                                        @foreach ($cat_fr as $item)
                                            @if ($loop->iteration > 6 & $loop->iteration < 14)
                                                <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                                </li>

                                            @endif
                                        @endforeach

                                    @elseif (App::getLocale() === "en")
                                        @foreach ($cat_en as $item)
                                            @if ($loop->iteration > 6 & $loop->iteration < 14)
                                                <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                                </li>

                                            @endif
                                        @endforeach
                                    @else 
                                        @foreach ($cat as $item)
                                            @if ($loop->iteration > 6 & $loop->iteration < 14)
                                                <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                                </li>

                                            @endif
                                        @endforeach
                                    @endif
                                    
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- BTN AUTRE GSM avec tous --}}
            <div class="categories-wrapper  translate-middle-y other-two d-sm-block d-md-none" id="rangeSearch">
                {{-- <div class="row justify-content-sm-center"> --}}
                    {{-- <div class="col-3 mx-auto"> --}}
                        <div class="select-categories cat-other d-flex justify-content-center">

                            <div class="dropdown">
                                {{-- <a href="#remonteHaut"> --}}
                                    <button class="dropdown-toggle ayhan" type="button" id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        {{ __('messages.cat') }}
                                    </button>
                                    <span class="cat-scrool d-none">scrool</span>
                                    <script>
                                        
                                        let test = document.querySelector('.ayhan')
                                        let catScrool = document.querySelector('.cat-scrool')
                                        test.addEventListener('click', () => {
                                            catScrool.click()
                                            // document.body.scrollTop='0px'
                                        })
                                    </script>
                                {{-- </a> --}}
                                <ul class="dropdown-menu" id="portfolio-flters" aria-expanded="false">
                                    @if (App::getLocale() === "fr")
                                        @foreach ($cat_fr as $item)
                                            @if ($loop->iteration < 14)
                                                <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                                </li>
                                                
                                            @endif

                                        @endforeach
                                    @elseif (App::getLocale() === "en")
                                        @foreach ($cat_en as $item)
                                            @if ($loop->iteration < 14)
                                                <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                                </li>
                                                
                                            @endif

                                        @endforeach
                                    @else 
                                        @foreach ($cat as $item)
                                            @if ($loop->iteration < 14)
                                                <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                                </li>
                                                
                                            @endif

                                        @endforeach
                                    @endif
                                    
                                </ul>

                            </div>
                        </div>
                    {{-- </div> --}}
                {{-- </div> --}}
            </div>

            @include('template.product.indoor')
        </div>
    </section>
</main>
@include('template.footer')
@endsection
