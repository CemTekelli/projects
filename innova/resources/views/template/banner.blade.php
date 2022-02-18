<div class="slider-area ">
    <div class="slider-active">
        <div class="single-slider hero-overly2  slider-height2 d-flex align-items-center slider-bg2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8 col-md-8">
                        <div class="hero__caption hero__caption2">
                            {{-- <h1 data-animation="fadeInUp" data-delay=".4s" >{{ Request::url() }}</h1> --}}
                            @if (Route::current()->getName() == "about")
                                <h1 data-animation="fadeInUp" data-delay=".4s" >{{__('messages.about') }}</h1>
                            @elseif(Route::current()->getName() == "product")
                                <h1 data-animation="fadeInUp" data-delay=".4s" >{{__('messages.products') }}</h1>
                                
                            @else 
                                <h1 data-animation="fadeInUp" data-delay=".4s" >{{ Route::current()->getName() }}</h1>

                            @endif
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">{{ __('messages.home') }}</a></li>
                                    @if (Route::current()->getName() == "about")
                                        <li class="breadcrumb-item"><a href="">{{__('messages.about') }}</a></li> 
                                        @elseif(Route::current()->getName() == "product")
                                        <li class="breadcrumb-item"><a href="">{{__('messages.products') }}</a></li> 
        
                                    @else 
                                        <li class="breadcrumb-item"><a href="">{{ Route::current()->getName() }}</a></li> 
                                    @endif

                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>