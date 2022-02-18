<style>


</style>
<div class="visit-tailor-area fix">
    <div class="container-fluid">
        <div class="row">
            @forelse ($testi->shuffle() as $item)
                @if ($loop->iteration <=3 )
                    @if ($item->img)
                        <div class="col-lg-4 my-5">
                            <div class="card-best text-center shadow-lg p-1">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center card-testi-img ">
                                        @if (File::exists(public_path('img/testi-img/' . $item->img)))
                                            <img src="{{ asset('img/testi-img/' . $item->img) }}" alt="avis-img">
                                        @else
                                            <img src="{{ asset('img/innovaImg/' . $item->img) }}" alt="avis-img">
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="best-body p-0">
                                            <div class="p-3">
                                                <div class="my-3">
                                                
                                                    @for ($i = 0; $i < $item->etoile; $i++)
                                                        <i class="fas fa-star"></i>
                                                        
                                                    @endfor
                                                    
                                                </div>
                                                <p class="card-text my-3 h-body">"{{ $item->avis }}"</p>

                                            </div>
                                            <div class="fond-gris p-3">
                                                <h5>{{ $item->user }}</h5>
                                                <p class="card-text mb-0"><small class="text-muted">update : {{$item->created_at->format('d M Y')}}</small></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    @else 
                        <div class="col-lg-4 my-5">
                            <div class="card-best text-center shadow-lg">
                                <div class="row">
            
                                    <div class="col-12">
                                        <div class="best-body p-0">
                                            <div class="p-3">
                                                <div class="my-3">
                                                    @for ($i = 0; $i < $item->etoile; $i++)
                                                        <i class="fas fa-star"></i>
                                                        
                                                    @endfor
                                                </div>
                                                <p class="card-text my-3 px-5 h-body">"{{ $item->avis }}"</p>
            
                                            </div>
                                            <div class="fond-gris p-3">
                                                <h5>{{ $item->user }}</h5>
                                        
                                                <p class="card-text mb-0"><small class="text-muted">update : {{$item->created_at->format('d M Y')}}</small></p>
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    @endif
                    
                    
                @endif
            @empty
                <p class="text-center col-12 my-5">not avaibalve</p>
            @endforelse
            
        </div>

    </div>
</div>
