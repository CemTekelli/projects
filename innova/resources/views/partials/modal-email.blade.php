{{-- ----------------- VIEW ----------------- --}}
<div class="modal fade text-left" id="large{{ $item->id }}" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">{{ $loop->iteration }}. {{ $item->subject }} </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body py-4">
                <h5>from : {{ $item->name }} | {{ $item->email }}</h5>
                
                message : <br>{{$item->message}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>
