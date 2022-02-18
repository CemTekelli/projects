<div class="instagram-area">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="instra-tittle mb-40">
                    <div class="section-tittle">
                        <img src={{ asset("img/gallery/insta.png") }} alt="instagram-icon">
                        <h2>{{ __('messages.insta') }}</h2>
                        {{-- <P class="mb-35">{{__('messages.insta_into')}}.</P> --}}
                        <a target="_blank" href="https://www.instagram.com/innovafurnituremerchtem" class="border-btn">{{ __('messages.insta_btn') }}</a>
                    </div>
                </div>
            </div>
            {{-- FAIRE des relations --}}
            <div class="col-xl-9 col-lg-8">
                <div class="row no-gutters">
                    @foreach ($instas->shuffle() as $item)
                        @if ($loop->iteration <= 2)
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 insta-none">
                        
                                {!! $item->feed !!}
                            </div>
                            
                        @endif
                        
                    @endforeach
                  
                </div>
            </div>
        </div>
    </div>
</div>