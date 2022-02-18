{{-- -------------- EDIT INFO --}}
<div class="modal fade text-left" id="informations" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Edit information</h4>
                <button type="button" class="close text-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">X</i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.update', $product->id) }}" class="form" method="POST">
                    @csrf
                    <input type="text" name="info" value="info" readonly style="display: none">
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Name Furniture</label>
                                <input required type="text" id="first-name-column" class="form-control"
                                    placeholder="Furniture" name="name"
                                    value="{{ $product->name }}">

                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="first-name-column">Type</label>
                            <fieldset class="form-group">
                                <select required class="form-select" id="basicSelect" name="type">
                                    <option value="indoor" {{ $product->type == 'indoor' ? "selected" : "" }}>
                                        indoor</option>
                                    <option  value="outdoor" {{ $product->type == 'outdoor' ? "selected" : "" }}>
                                        outdoor</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="city-column">Pric€</label>
                                <input required type="number" id="city-column" class="form-control"
                                    placeholder="10k ?" name="price"
                                    value="{{ $product->price }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="first-name-column">Popular</label>
                            <fieldset class="form-group">
                                <select required class="form-select" id="basicSelect" name="popular">
                                    <option {{ $product->popular == true ? "selected" : "" }}
                                        
                                        value="1">true</option>
                                    <option {{ $product->popular == false ? "selected" : "" }}
                                        
                                        value="0">false</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <select required class="form-select" multiple aria-label="multiple select example" name="cat[]" required>
                                @php
                                    //LOGIQUE pour récuperer les cat selectionné dans un tab
                                    $selected = [];
                                    foreach ($product->categories as $item) {
                                        foreach ($cat as $value) {
                                            if ($item->name == $value->name) {
                                                array_push($selected, $item->name);
                                            }
                                        }
                                    }
                                @endphp
                                @foreach ($cat as $iteem)
                                        {{-- verifie si une cat de la list exist dans le tableau qui comporte nos cat à nous --}}
                                    @if (in_array($iteem->name, $selected)) 
                                                {{-- si oui, on l'affiche avec le select --}}
                                        <option selected value="{{ $iteem->id }}">{{ $iteem->name }}</option>    
                                    @else  
                                                {{-- si non, on l'affiche le reste de la list sans le select --}}
                                        <option value="{{ $iteem->id }}">{{ $iteem->name }}</option>  
                                    @endif
                             
        
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-12 mt-2">
                            <div class="form-group mb-3">
                                <label for="arearoduct"
                                    class="form-label">Description</label>
                                <textarea name="description" class="form-control"
                                    id="arearoduct"
                                    rows="8">{{$product->description }}</textarea>
                            </div>
                        </div> --}}
                        <div class="col-12 mt-4">
                            <div class="accordion" id="accordionExample">
                                <div class="d-flex justify-content center">
                                    <button class="btn btn-primary mx-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Description NL
                                      </button>
                                      <button class="btn btn-primary mx-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                         Description FR
    
                                      </button>
                                      <button class="btn btn-primary mx-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                         Description EN
                                      </button>

                                </div>
                                <p class="text-center my-1">Si tu souhaites faire un  retour à la ligne, utilise la syntaxe suivante : <strong>< br /></strong></p>

                                {{-- DESCRIPTION NL --}}
                                <div class="accordion-item">
                
                                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-3">
                                            <label for="arearoduct"
                                                class="form-label">Description</label>
                                            <textarea required name="description" class="form-control"
                                                id="editor"
                                                rows="8">{{$product->description }}</textarea>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                {{-- DESCRIPTION FR --}}
                                <div class="accordion-item">
                                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-3">
                                            <label for="arearoduct"
                                                class="form-label">Description</label>
                                            <textarea required name="description_fr" class="form-control"
                                                id="editor2"
                                                rows="8">{{$product->description_fr }}</textarea>
                                        </div>                                    
                                    </div>
                                  </div>
                                </div>

                                {{-- DESCRIPTION EN --}}
                                <div class="accordion-item">
                                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-group mb-3">
                                            <label for="arearoduct"
                                                class="form-label">Description</label>
                                            <textarea required name="description_en" class="form-control"
                                                id="editor3"
                                                rows="8">{{$product->description_en }}</textarea>
                                        </div>                                     
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="collapsed btn btn-primary fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                      Price reduce ?
                                    </button>
                                    <span class="fs-6 fw-light fst-italic">Si tu ne souhaites pas de réduction, laisse le champ vide</span>
                                  </h2>
                                  <div id="flush-collapseOne" class="accordion-collapse collapse {{ $product->price_reduce == null? "" : "show" }}" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <input type="number" id="city-column" class="form-control"
                                        placeholder="reduce ?" name="reduce"
                                        value="{{ $product->price_reduce }}">
                                  </div>
                                </div>
                            </div>
                        </div>
              
                        <div class="col-12 d-flex justify-content-end my-3">
                            <button type="submit" class="btn btn-primary ml-1">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        
        </div>
    </div>
</div>
           

{{-- -------------- EDIT IMAGE --}}
<div class="modal fade text-left" id="image" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Edit image</h4>
                <button type="button" class="close text-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">X</i>
                </button>
            </div>
            <div class="modal-body ">
                <form class="d-flex align-items-center justify-content-center cbx-ciblig" action="{{ route('image.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input required class="form-control w-50 mx-4 my-3 image-add-store " type="file" name="image">
                    <button class="btn btn-primary">Add</button>
                </form>
                <div class="modal-body d-flex flex-wrap modal-img-edit h-100 justify-content-around">
                    @foreach ($product->images as $item)
                        @if (File::exists(public_path('img/productUpload/' .$item->img )))
                            <div class="div-img-show test mx-1 d-flex flex-column align-items-center my-1">
                                <img  src="{{ asset('img/productUpload/' .$item->img) }}" class=" w-100" alt="{{ $loop->index }}"> 
                                <form class="py-1" action="{{ route('product.update', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="editImage" value="editImage" style="display: none">
                                    @method("PUT")
                                    <button class="btn btn-danger">X</button>
                                </form>
                            </div>
                                            
                        @else 
                            <div class="div-img-show mx-1 d-flex flex-column align-items-center my-1">
                                <img  src="{{ asset("img/innovaImg/" . $item->img) }}" class=" w-100" alt="{{ $loop->index }}">
                                <form class="py-1" action="{{ route('product.update', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="editImage" value="editImage" style="display: none">
                                    @method("PUT")
                                    <button class="btn btn-danger">X</button>
                                </form>
                            </div>
                        @endif
                    @endforeach

                </div>
                <script>
                    let nbrImg = document.querySelectorAll('.img-js').length
                    let imgInput = document.querySelector('.image-add-store')
                    if (nbrImg) {
                        if (nbrImg === 5) {
                            imgInput.setAttribute("disabled", "")
                        }
                    }
                </script>
            </div>
      
        </div>
    </div>
</div>
{{-- -------------- EDIT SPECI --}}
<div class="modal fade text-left" id="speci" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-start ">
                <h4 class="modal-title" id="myModalLabel17">Edit specification</h4>
                <button class="btn add-speci mx-1  "><i style="font-size: 25px" class="bi bi-plus-circle-fill"></i></button>

               
            </div>
            <div class="modal-body">
                <form class="row p-2 form-speci" action="{{ route('product.update', $product->specification->id) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="specifi" value="specifi">
                    @foreach (json_decode($product->specification->data) as $key => $value)

                        <div class="group-speci">
                                <div class="from-group">
                                    <label for="">Détails</label>
                                    <input  placeholder="Color ?" value="{{ $key }}" class="form-control" type="text" name="speci{{ $loop->iteration }}">
                                </div>
                                <div class="from-group">
                                    <label for="">Reponse</label>
                                    <input  placeholder="red, blue, orange, ..." value="{{ $value }}" class="form-control" type="text" name="rep{{ $loop->iteration }}">
                                </div>
                        </div>
                            <hr class="hr-speci">


                    @endforeach
                    {{-- <div class="group-speci">
                            <div class="from-group">
                                <label for="">Détails</label>
                                <input required class="form-control" type="text" name="speci2">
                            </div>
                            <div class="from-group">
                                <label for="">Reponse</label>
                                <input required class="form-control" type="text" name="rep2">
                            </div>
                            <i class="bi bi-dash-circle-fill minus-speci"></i>
                    </div> --}}
                    <div class="col-12 d-flex justify-content-end my-4" id="action-speci">
                        <button type="submit" class="btn btn-primary ml-1">
                            Update
                        </button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>
</div>
{{-- -------------- EDIT COMMENT NO VALIDE --}}
<div class="modal fade text-left" id="commentnocheck" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17"> comments not yet validated</h4>
                <button type="button" class="close text-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">X</i>
                </button>
            </div>
            <div class="modal-body">
              @forelse ($product->comments->reverse()  as $item)
                    @if ($item->validate == 0)
                        <div class="row">
                            <div class="col-1">{{ $loop->iteration }}. </div>
                            <div class="col">
                                <p class="m-0">{{ $item->user }} - {{ $item->email }}</p>
                                <p class="m-0">MSG : {{ $item->commentaire }}</p>

                            </div>
                            <div class="col">
                                <p class="m-0">Number : {{ $item->number ? $item->number: "not specified" }}</p>
                                <p class="m-0">Date : {{ $item->created_at->format("d M Y") }}</p>
                            </div>
                            <div class="col-2 d-flex">
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
                            </div>
                        </div>

                        <hr>
      

                    @endif
                @empty
                    <p>no comments</p>
              @endforelse

            </div>
        
        </div>
    </div>
</div>
{{-- -------------- EDIT COMMENT ALL --}}
<div class="modal fade text-left" id="commentall" tabindex="-1" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">comment validate</h4>
                <button type="button" class="close text-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">X</i>
                </button>
            </div>
            <div class="modal-body">
          

                @forelse ($product->comments->reverse()  as $item)
                    @if ($item->validate == 1)
                        <div class="row">
                            <div class="col-1">{{ $loop->iteration }}. </div>
                            <div class="col">
                                <p class="m-0">{{ $item->user }} - {{ $item->email }}</p>
                                <p class="m-0">MSG : {{ $item->commentaire }}</p>

                            </div>
                            <div class="col">
                                <p class="m-0">Number : {{ $item->number }}</p>
                                <p class="m-0">Date : {{ $item->created_at->format("d M Y") }}</p>
                            </div>
                            <div class="col-2 d-flex">
                            <form action="{{ route('product.update', $item->id) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <input type="text" name="delnocheck" value="delnocheck" style="display: none"> 
                                <button class="btn btn-danger mx-1">X</button>
                            </form>
                            </div>
                        </div>

                        <hr>
                    
                    @endif
                    @empty
                        <p>no comments</p>
                @endforelse
              </div>
        </div>
    </div>
</div>

{{-- -------------- DELETE THIS PRODUCT --}}
<div class="modal fade text-left" id="small" tabindex="-1" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex justify-content-center">
                <form action="{{ route('product.delete', $product->id) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-outline-danger" >Definitive</button>
                </form>

            </div>
      
        </div>
    </div>
</div>


   {{-- Script details  --}}
   <script>
        // let nbr = document.querySelectorAll('.group-speci')
        let btn_add_speci = document.querySelector('.add-speci');
        let form = document.querySelector('.form-speci')
        let action = document.querySelector('#action-speci')
        // console.log(btn_add_speci);

        //Count qui va counter le nbr de input créer et mettre a jour le name de chaque input
        let count = 3
        btn_add_speci.addEventListener('click', () => {
            //création minus
            let minus = document.createElement('i')
            minus.className = 'bi bi-dash-circle-fill minus-speci'
            let hr = document.createElement('hr');
            hr.classList.add('hr-speci')

            let divGroup = document.createElement('div')

            //Boucle pour les labets + input en auto
            divGroup.classList.add('group-speci');
            countGroup = document.querySelectorAll('.group-speci').length + 1
            // console.log(countGroup);
            for (let i = 3; i < 5; i++) {
                let one_div_form = document.createElement('div');
                one_div_form.classList.add('from-group')
                let one_label = document.createElement('label')
                //condition pour innerText inpur
                i % 2 == 1 ? one_label.innerText = "Détails" : one_label.innerText = "Reponse" ;

                let one_input = document.createElement('input')
                one_input.classList.add('form-control')
                one_input.setAttribute('type', "text")
                //condition pour fournir le name
                i % 2 == 1 ? one_input.setAttribute('name', `speci${countGroup}`) : one_input.setAttribute('name', `rep${countGroup}`) ;
                

                one_div_form.append(one_label, one_input)
                divGroup.append(one_div_form)
                
            }
            divGroup.append(minus)
            form.insertBefore(divGroup,action )
            form.insertBefore(hr,divGroup )
            // console.log(form, action);
            // select all minus + fonctionnalité remove
            let minusAll = document.querySelectorAll('.minus-speci')
            minusAll.forEach(el => {
                el.addEventListener('click', (e) => {
                    e.target.parentNode.previousElementSibling.remove();
                    e.target.parentNode.remove();
                })    
            });
            // console.log(minusAll);
            count++
        })

    </script>