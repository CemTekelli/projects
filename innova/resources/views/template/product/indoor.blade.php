
<div id="portfolio" class="portfolio section-bg">
    <div class="container">
        
        <div class="row other-one" data-aos="fade-up">
            <div class="filter-parent col-lg-12 d-flex justify-content-center">
                
              
                <ul id="portfolio-flters">
                    <li class="event-product" data-filter="*" class="filter-active">All</li>
                    {{-- LANG LOGIQUE --}}
                    @if (App::getLocale() === "fr")
                        @foreach ($cat_fr as $item)
                            @if ($loop->iteration <= 6)
                                <li  data-filter=".filter-{{ $item->name }}" class="event-product">{{ $item->name }}</li>
                                
                            @endif
                        @endforeach
                    @elseif (App::getLocale() === "en")
                        @foreach ($cat_en as $item)
                            @if ($loop->iteration <= 6)
                                <li  data-filter=".filter-{{ $item->name }}" class="event-product">{{ $item->name }}</li>
                                
                            @endif
                        @endforeach
                    @else 
                        @foreach ($cat as $item)
                            @if ($loop->iteration <= 6)
                                <li  data-filter=".filter-{{ $item->name }}" class="event-product">{{ $item->name }}</li>
                                
                            @endif
                        @endforeach

                    @endif

                </ul>
                {{-- <div class="category-listing mb-50 X"> --}}
                {{-- </div> --}}
            </div>
        </div>
        <div style={{ $count_product  == 0 ? "" : "height:80px;" }} class="row portfolio-container parent_child" data-aos="fade-up" data-aos-delay="100" >
            @forelse ($products->reverse() as $item)
                @php
                    //LOGIQUE pour récuperer les cat selectionné dans un tab
                    $selected = [];
                    foreach ($item->categories as $pro) {
                        foreach ($cat as $value) {
                            if ($pro->name == $value->name) {
                                array_push($selected, $pro->id);
                            }
                        }
                    }

                    //LOGIQUE pour analyser et chooper les cat qui sont à la meme plce via l'id et le push. Pour mettre les cat en bonne langue 
                    $cat_lang = [];
                    if (App::getLocale() === "fr") {
                        foreach ($cat_fr as $key => $value) {
                            foreach ($selected as $key => $sel) {
                                if ($sel == $value->id) {
                                    array_push($cat_lang, $value->name);
                                }
                                
                            }
                        }
                    } else if (App::getLocale() === "en") {
                        foreach ($cat_en as $key => $value) {
                            foreach ($selected as $key => $sel) {
                                if ($sel == $value->id) {
                                    array_push($cat_lang, $value->name);
                                }
                                
                            }
                        }
                    }
                
                @endphp
                @if ($item->type == "indoor")
                @if (App::getLocale() === "nl")
                <div id="product_child" class="col-lg-3 col-md-6 portfolio-item @foreach ($item->categories as $fil) filter-{{ $fil->name }} @endforeach">
                @else 
                <div id="product_child" class="col-lg-3 col-md-6 portfolio-item @foreach ($cat_lang as $fil) filter-{{ $fil }} @endforeach">
                @endif
                        <div class="portfolio-wrap img-parent">
                            @if (isset($item->images[0]->img))
                                @if (File::exists(public_path('img/productUpload/' . $item->images[0]->img)))
                                    <a href="{{ asset('img/productUpload/' . $item->images[0]->img) }}" data-gall="portfolioGallery" class="venobox" title="{{ $item->name }}">
                                        <img  src="{{ asset('img/productUpload/' . $item->images[0]->img) }}" alt="{{ $item->name }}">
                                    </a>
                                @else
                                    <a href="{{ asset('img/innovaImg/' . $item->images[0]->img) }}" ata-gall="portfolioGallery" class="venobox" title="{{ $item->name }}">
                                        <img  src="{{ asset('img/innovaImg/' . $item->images[0]->img) }}" alt="{{ $item->name }}">
                                    </a>
                                @endif
                                
                            @else
                                <p>photo does not exist</p>
                            @endif

                            <div class="portfolio-links">
                                <a  href="{{ route('product', $item->name) }}" title="More Details"><i
                                    class="bx bx-plus"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

            @empty
            <div class="col-12 py-5 my-5">
                <h1 class="text-center">is not available</h1>

            </div>
            @endforelse

        </div>


    </div>
</div>
