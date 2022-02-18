{{-- ----------------- edit ----------------- --}}
@if (isset($item))
<div class="modal fade text-left" id="large-{{ $item->id }}" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Testimonial nbr {{ $item->id }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form class="modal-body" action="{{ route('testimonial.update', $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="row">
                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user">User :</label>
                            <input type="text" id="user" name="user" value="{{ $item->user }}" required class="form-control round" placeholder="Emilie Uslu ?">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="etoile">Rating :</label>
                            <input type="number" max="5" id="etoile" value="{{ $item->etoile }}" required name="etoile" class="form-control square" placeholder="5 ?">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group with-title mb-3">
                            <textarea name="avis" class="form-control" required id="avis" rows="6">{{ $item->avis }}</textarea>
                            <label>Avis</label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Edit or add an image ?</label>
                            <input class="form-control" name="img"  type="file" id="formFile">
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        @if ($item->img !== null)
                        
                            @if (File::exists(public_path('img/testi-img/' . $item->img)))
                                <img src="{{ asset('img/testi-img/' . $item->img) }}" alt="testi-img" class="img-fluid">
                            @else
                                <img src="{{ asset('img/innovaImg/' . $item->img) }}" alt="testi-img" class="img-fluid">
                            @endif
                            <div class="form-check">
                                <div class="custom-control custom-checkbox text-start">
                                    <input type="checkbox" class="form-check-input form-check-danger"  name="cbxTesti" id="cbx-testi">
                                    <label class="form-check-label" for="cbx-testi">Just remove ?</label>
                                </div>
                            </div>
                        @else
                            <span>no pics available</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end my-2">
                    <button class="btn btn-primary ml-1">Validate ?</button>
                </div>
           
            </form>
        </div>
    </div>
</div> 
@endif

{{-- ----------------- CREATE ----------------- --}}
<div class="modal fade text-left" id="largeCreate" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">new testimonial</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form class="modal-body" action="{{ route('testimonial.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user">User :</label>
                            <input type="text" id="user" name="user"  required class="form-control round" placeholder="Emilie Uslu ?">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="etoile">Rating :</label>
                            <input type="number" max="5" id="etoile"  required name="etoile" class="form-control square" placeholder="5 ?">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group with-title mb-3">
                            <textarea name="avis" class="form-control" required id="avis" rows="6" placeholder="Avis ?"></textarea>
                            <label>Avis</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Add an image ? (optional)</label>
                            <input class="form-control" name="img"  type="file" id="formFile" >
                        </div>
                        <p class="text-center">Avant d'upload, compresse tes images sur <a target="_blank" class="d-inline" style="color: blue" href="https://tinypng.com/">tinypng.com</a></p>

                    </div>
               
                </div>
                <hr>
                <div class="d-flex justify-content-end my-2">
                    <button class="btn btn-primary ml-1">Create</button>
                </div>
           
            </form>
        </div>
    </div>
</div>