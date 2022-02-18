<div class="new-arrival new-arrival2">
    <div class="container">
        <!-- Section tittle -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="section-tittle mb-60 text-center wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
                    <h2>Products you may like</h2>
                    <P>Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros
                        dolor interdum nulla.</P>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $item)
                @if ($item->like)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s"
                            data-wow-delay=".1s">
                            <div class="popular-img">
                                @foreach ($item->images as $img)
                                @if ($loop->first)
                                    {{-- @dump($img->img) --}}
                                    <img src="{{ asset('img/innovaImg/' . $img->img) }}" alt="">

                                @endif
                            @endforeach

                            </div>
                            <div class="popular-caption">
                                <h3><a href="product_details.html">Bly Microfiber / Microsuede 56" Armless Loveseat</a>
                                </h3>
                                <span>$367</span>
                            </div>
                        </div>
                    </div>

                @endif

            @endforeach
            {{-- <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <div class="popular-img">
                        <img src={{ asset("img/gallery/popular5.png") }} alt="">
                    </div>
                    <div class="popular-caption">
                        <h3><a href="product_details.html">Bly Microfiber / Microsuede 56" Armless Loveseat</a></h3>
                        <span>$367</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-new-arrival mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="popular-img">
                        <img src={{ asset("img/gallery/popular6.png") }} alt="">
                    </div>
                    <div class="popular-caption">
                        <h3><a href="product_details.html">Bly Microfiber / Microsuede 56" Armless Loveseat</a></h3>
                        <span>$367</span>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- Button -->
        <div class="row justify-content-center">
            <div class="room-btn">
                <a href="product.html" class="border-btn">Discover More</a>
            </div>
        </div>
    </div>
</div>
