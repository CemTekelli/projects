<div class="about-area section-padding40">
    <div class="container">
        @foreach ($abouts as $item)
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-tittle mb-60 text-center pt-10">
                        @if ($loop->iteration == 1)
                            <h2>{{ __('messages.mission') }}</h2>
                        
                        @elseif ($loop->iteration == 2)
                        <h2>{{ __('messages.vision') }}</h2>

                        @else
                            <h2>{{ __('messages.value') }}</h2>

                        @endif
                        {{-- <p class="pera">{{ $item->data }}</p> --}}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="about-img pb-bottom">
                        @if ($loop->iteration == 1)
                            <img src={{ asset("img/gallery/about1.png") }} alt="Mission" class="w-100">
                    
                        @elseif ($loop->iteration == 2)
                            <img src={{ asset("img/gallery/about2.png") }} alt="Vision" class="w-100">
                        @endif
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>
</div>