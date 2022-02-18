{{-- ----------------- edit ----------------- --}}

<div class="modal fade text-left" id="large{{ $item->id }}" tabindex="-1" aria-labelledby="myModalLabel17"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($item->id ==1 )
                    <h4 class="modal-title" id="myModalLabel17"> Edit Mission :</h4>
                @elseif($item->id ==2)
                    <h4 class="modal-title" id="myModalLabel17">Edit Vision :</h4>
                @else
                    <h4 class="modal-title" id="myModalLabel17">Edit Valeur :</h4>
                @endif
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form class="modal-body" action="{{ route('about.update', $item->id) }}" method="post">
                @csrf
                @method("PUT")
                <div class="row">


                    <div class="col-sm-12">
                        <div class="form-group with-title mb-3">
                            <label>Data</label>
                            <textarea name="data" class="form-control" required id="data" rows="6" placeholder="Lorem lorem ?">{{ $item->data }}</textarea>
                        </div>
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

