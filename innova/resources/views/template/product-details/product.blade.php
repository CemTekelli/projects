<div class="product_image_area section-padding40">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-5">
                <div class="product_slider_img">
                    <div id="vertical">
                        {{-- <div data-thumb="{{ asset("img/innovaImg/" . $product->images[0]->img) }}">
                            @if (File::exists(public_path('img/productUpload/' . $product->images[0]->img)))
                                <a href="{{ asset("img/productUpload/" . $product->images[0]->img) }}" data-gall="portfolioGallery" class="venobox" title="">
                                    <img src="{{ asset("img/productUpload/" . $product->images[0]->img) }}"  class="w-100">
                                </a>
                            @else
                                <a href="{{ asset("img/innovaImg/" . $product->images[0]->img) }}" data-gall="portfolioGallery" class="venobox" title="">
                                    <img src="{{ asset("img/innovaImg/" . $product->images[0]->img) }}"  class="w-100">
                                </a>
                            @endif
                        </div> --}}

                        @for ($i = 0; $i < count($product->images); $i++)
                            @if (File::exists(public_path('img/productUpload/' . $product->images[$i]->img)))
                                <div data-thumb="{{ asset("img/productUpload/" . $product->images[$i]->img) }}">
                                    <a href="{{ asset("img/productUpload/" . $product->images[$i]->img) }}" data-gall="portfolioGallery" class="venobox" title="">
                                        <img src={{ asset("img/productUpload/" . $product->images[$i]->img) }}  class="w-100" >
                                    </a>
                                </div>
                            @else
                                <div data-thumb="{{ asset("img/innovaImg/" . $product->images[$i]->img) }}">
                                    <a href="{{ asset("img/innovaImg/" . $product->images[$i]->img) }}" data-gall="portfolioGallery" class="venobox" title="">
                                        <img src={{ asset("img/innovaImg/" . $product->images[$i]->img) }}  class="w-100">
                                    </a>
                                </div>
                                
                            @endif
                            {{-- @dump("test") --}}
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3>{{ $product->name }}</h3>
                    @if ($product->price_reduce == null)
                        <h2>{{ $product->price }} €</h2>
                        @else 
                        
                        <h2>
                            <span class="price-previous">{{ $product->price }}€ </span>
                                 
                            <span class="new-price">{{ $product->price_reduce }}€</span>
                        </h2>
                        
                    @endif
                    <ul class="list" style="border-bottom: 1px dotted #d5d5d5;padding: 10px 0;margin: 10px 0 ">
                        <li>
                            <a class="active" href="#">
                                <span style="width: max-content">{{ __('messages.cat') }} :</span> 
                                @php
                                    //LOGIQUE pour récuperer les cat selectionné dans un tab
                                    $selected = [];
                                    foreach ($product->categories as $item) {
                                        foreach ($cat as $value) {
                                            if ($item->name == $value->name) {
                                                array_push($selected, $item->id);
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
                                @if (App::getLocale() === "nl")
                                    @foreach ($product->categories as $item)
                                        {{ $item->name }},&nbsp;
                                    @endforeach
                                    
                                @else
                                    @foreach ($cat_lang as $item)
                                        {{ $item }},&nbsp;
                                    @endforeach
                                @endif
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#"> <span>Availibility</span> : In Stock</a>
                        </li> --}}
                    </ul>
                    {{-- <p> --}}
                        @php
                            if (App::getLocale() === "fr") {
                                $descri = $product->description_fr;
                            } else if (App::getLocale() === "en") {
                                $descri = $product->description_en;
                            } else {
                                $descri = $product->description;

                            }
                            if (strlen($descri) > 750) {
                                $coup = substr($descri, 0, 750 );
                                $coup = $coup . ' ...';
                            }else{
                                $coup = $descri;
                            }
                        @endphp
                        {!! $coup !!}
                    {{-- </p> --}}
                {{-- @auth
                    
                <div class="card_area">
                    <div class="product_count d-inline-block">
                        <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                        <input class="input-number" type="text" value="1" min="0" max="10">
                        <span class="number-increment"> <i class="ti-plus"></i></span>
                    </div>
                    <div class="add_to_cart">
                        <a href="#" class="btn">Click And Collect</a>
                        <a href="#" class="like_us"> <i class="ti-heart"></i> </a>
                    </div>
                    <div class="social_icon">
                        <a href="https://fr-fr.facebook.com/innovafurnituremerchtem/" class="fb" target="_blank"><i class="ti-facebook"></i></a>
                        <a href="https://www.instagram.com/innovafurnituremerchtem/" class="li" target="_blank"><i class="ti-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/innovafurnituremerchtem/" class="li" target="_blank"><i class="ti-linkedin"></i></a>
                    </div>
                </div>
                @else 
                <div class="card_area">
                    <div class="add_to_cart">
                        <p>Pour ajouter au panier, veuillez vous connectez</p>
                        <a href="{{ route('login') }}" class="btn" >Login</a>                        
                    </div>
                    <div class="social_icon">
                        <a href="https://fr-fr.facebook.com/innovafurnituremerchtem/" class="fb" target="_blank"><i class="ti-facebook"></i></a>
                        <a href="https://www.instagram.com/innovafurnituremerchtem/" class="li" target="_blank"><i class="ti-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/innovafurnituremerchtem/" class="li" target="_blank"><i class="ti-linkedin"></i></a>
                    </div>
                </div>
                @endauth --}}
                <div class="card_area" style="padding-top: 20px;border-top: 1px dotted #d5d5d5;margin: 20px 0">
                    <div class="social_icon mt-1">
                        <a href="https://fr-fr.facebook.com/innovafurnituremerchtem/" class="fb" target="_blank"><i class="ti-facebook"></i></a>
                        <a href="https://www.instagram.com/innovafurnituremerchtem/" class="li" target="_blank"><i class="ti-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/innovafurnituremerchtem/" class="li" target="_blank"><i class="ti-linkedin"></i></a>
                    </div>
                </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
