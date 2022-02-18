<div class="modal fade text-left w-100" id="xlarge" tabindex="-1" aria-labelledby="myModalLabel16" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel16">Extra Large
                    Modal</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($comments as $item)
                        @if (!$item->validate)
                            <div class="col-sm-12 col-md-6 ">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <p class="my-0"><b>User :</b> {{ $item->user }} </p>
                                        <p class="my-0"><b>Email :</b> {{ $item->email }} </p>
                                        <p class="my-0"><b>Num :</b> {{ $item->number ? $item->number : "number not given" }} </p>
                                        <p class="my-0"><b>Product :</b> {{ $item->product->name }} </p>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <p><b>Message :</b></p>
                                        <p>{{ $item->commentaire}}</p>
                
                                    </div>
                                    <div class="col-sm-12 col-md-4 d-flex align-items-start">
                                        <form action="{{ route('product.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method("PUT")
                                            <input type="text" name="delnocheck" value="delnocheck" style="display: none"> 
                                            <button class="btn btn-danger mx-1">X</button>
                                        </form>
                                        <form action="{{ route('product.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method("PUT")
                                            <input type="text" name="validate" value="validate" style="display: none"> 
                                            <button class="btn btn-success">V</button>
                                        </form>
                            
                                        <a class="btn btn-primary mx-1"href="{{ route('product.show', $item->product->id) }}">prod ?</a>
                                    </div>

                                </div>
                                <hr class="my-3">
                            </div>
                            
                        @endif
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
</div>