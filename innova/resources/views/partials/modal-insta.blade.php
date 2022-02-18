{{-- CREATE --}}
<div class="modal fade text-left" id="largeCreate" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Add a post in your web site</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('instagram.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="first-name-column">blockquote post</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" name="feed" placeholder="blockquote ?"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary">Add</button>

                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
{{-- show --}}
<div class="modal fade text-left" id="Large{{ $item->id }}" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body d-flex justify-content-center">
                {!! $item->feed !!}
            </div>
            <div class="modal-footer">
                <form action="{{ route('instagram.destroy', $item->id) }}" method="post">
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
           
            </div>
        </div>
    </div>
</div>