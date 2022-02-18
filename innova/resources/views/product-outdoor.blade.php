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

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-10">
                        <div class="section-tittle mb-60 text-center wow fadeInUp respo-title-cat" data-wow-duration="1s"
                            data-wow-delay=".2s">
                            <h2>{{ __('messages.title_outdoor') }}</h2>
                            <p id="countProduct">{{ $count_product }} {{ __('messages.found') }}</p>
                        </div>
                    </div>
                </div>

                {{-- ---- btn cat GSM ---- --}}
                <div class="categories-wrapper  translate-middle-y other-two d-sm-block d-md-none" id="rangeSearch">
                    <div class="select-categories cat-other d-flex justify-content-center">

                        <div class="dropdown">
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
                            <ul class="dropdown-menu" id="portfolio-flters" aria-expanded="false">
                                @if (App::getLocale() === "fr")
                                    @foreach ($cat_fr as $item)
                                        @if ($loop->iteration >=14)
                                            <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                            </li>
                                            
                                        @endif

                                    @endforeach
                                @elseif (App::getLocale() === "en")
                                    @foreach ($cat_en as $item)
                                        @if ($loop->iteration >=14)
                                            <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                            </li>
                                            
                                        @endif

                                    @endforeach
                                @else 
                                    @foreach ($cat as $item)
                                        @if ($loop->iteration >=14)
                                            <li class="dropdown-item event-product" data-filter=".filter-{{ $item->name }}">{{ $item->name }}
                                            </li>
                                            
                                        @endif

                                    @endforeach
                                @endif
                                
                            </ul>

                        </div>
                    </div>
                </div>

                {{-- ---- PARTI body du outdoor ---- --}}
                @include('template.product.outdoor')
                
            </div>
        </section>
    </main>
    @include('template.footer')
@endsection
