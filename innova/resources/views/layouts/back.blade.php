<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Innova</title>
    <link rel="icon" href="{{ url('img/innovaImg/logo-hd.png') }}">

    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/email.css') }}">

    <link rel="stylesheet" href={{ asset('vendors-admin/iconly/bold.css') }}>
    
    {{-- CSS croper image --}}
    <link rel="stylesheet" href={{ asset('css/croper/ijaboCropTool.min.css') }}>

    <link rel="stylesheet" href={{ asset('vendors-admin/perfect-scrollbar/perfect-scrollbar.css') }}>
    <link rel="stylesheet" href={{ asset('vendors-admin/bootstrap-icons/bootstrap-icons.css') }}>
    <link rel="stylesheet" href={{ asset('css/admin/app.css') }}>
    <link rel="stylesheet" href={{ asset('css/back.css') }}>

    {{-- <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon"> --}}


</head>

<body>
    @if (auth()->user()->role_id === 1)
        <main id="app">
            @include('partials.nav')
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    @yield('title-page')
                </div>
                <div class="page-content">
                    @yield('content')
                </div>

            </div>
        </main>
    @else 
        @include('partials.page-client')
    @endif
    

    {{-- JS croper image --}}
    <script src={{ asset('js/croper/jquery-3.5.1.min.js') }}></script>
    <script src={{ asset('js/croper/ijaboCropTool.min.js') }}></script>

    <script src={{ asset('vendors-admin/perfect-scrollbar/perfect-scrollbar.min.js') }}></script>
    <script src={{ asset('js/admin/bootstrap.bundle.min.js') }}></script>
    {{-- <script src={{ asset("vendors-admin/apexcharts/apexcharts.js") }}></script> --}}
    <script src={{ asset('js/admin/pages/dashboard.js') }}></script>
    <script src={{ asset('js/admin/main.js') }}></script>


    {{-- Script qui lance le crop --}}
    <script>
        // let select = document.querySelector("#ratio-cropper")
        // let ratio = 16/9;
        // // select.addEventListener("change", function() {
        // // });
        $('#image-crop').ijaboCropTool({
           preview : '.image-previewer',
           setRatio: 16/9,
        //    allowedExtensions: ['jpg', 'jpeg','png'],
        //    buttonsText:['CROP','QUIT'],
        //    buttonsColor:['#30bf7d','#ee5155', -15],
           processUrl:'{{ route("crop.store") }}',
           withCSRF:['_token','{{ csrf_token() }}'],
           onSuccess:function(message, element, status){
            //   alert(message);
              getallimage()
              optimizeImg()
            //   console.log(ratio);
           },
           onError:function(message, element, status){
             alert(message);
           }
        });
    </script>   
    {{-- Scrip qui affiche les images add --}}
    <script>
        function getallimage() {
            // let tab = []; 
            $.get("/img-all", function(data){
                if (data.length > 0) {
                    let div = document.querySelector('#div-all-img')
                    if (div) {
                        div.innerHTML = ""
                    }
                    // console.log(data);
                    const {img1, img2, img3, img4, img5} = data[0];
                    let myImg = [img1, img2, img3, img4, img5]
                    // console.log(myImg);
                    myImg.forEach((el,i) => {
                        // console.log(el);
                        if (el != null) {
                            //création card structure + btn delete
                            let col = document.createElement('div')
                            col.className = 'col-4 my-4'
                            let block = document.createElement('div')
                            block.classList.add('block-image')
                            let block_img = document.createElement('div')
                            block_img.classList.add('block-img')

                            let overlay = document.createElement('div')
                            overlay.classList.add('block-overlay')
                            let btn_add_cart = document.createElement('div')
                            btn_add_cart.classList.add('block-btn-addcart')
                            let btn = document.createElement('a')
                            btn.setAttribute('href', `/remove-img/${i}`)
                           
                            let icon_trash = document.createElement('i')
                            icon_trash.className = "bi bi-trash-fill"

                            //création image
                            let img = document.createElement('img')
                            img.setAttribute('src', `{{ asset('img/productUpload/${el}') }}`) 

                            //logique append de chaque element
                            btn.append(icon_trash)
                            btn_add_cart.append(btn)
                            overlay.append(btn_add_cart)
                            block_img.append(img)
                            block_img.append(overlay)
                            block.append(block_img)
                            col.append(block)
                            if (div) {
                                div.append(col)
                            }

                            
                        }
                    });
                    let nbrImg = document.querySelectorAll('.block-overlay').length
                    let imgCount = document.querySelector('.img-count')
                    let imgInput = document.querySelectorAll('.image-add-store')
                    if (nbrImg) {
                        if (nbrImg === 5) {
                            imgCount.textContent = "Vous avez atteint le maximum ! "
                            imgInput[0].setAttribute("disabled", "")
                            imgInput[1].setAttribute("disabled", "")
                        }else{
                            imgCount.textContent = `${nbrImg} / 5 images`
                        }
                    }
                    
                }
                // console.log(data);
            });       
        }
        window.onload = getallimage();
    </script>
    {{-- script oui ou non crop image --}}
    <script>
        let cbx = document.querySelector('#cbx')
        let cibling = document.querySelectorAll('.cbx-ciblig')
        // console.log(cbx);
        if (cbx) {
            cbx.addEventListener('change', function () {
                if (this.checked) {
                    cibling[0].classList.add('d-none')
                    cibling[1].classList.remove('d-none')
                    cibling[1].classList.add('d-block')
                } else {
                    cibling[0].classList.remove('d-none')
                    cibling[0].classList.add('d-block')
                    cibling[1].classList.add('d-none')
                    cibling[1].classList.remove('d-block')
    
                }
            })
        }
    </script>
    {{-- script qui active l'active dans la page contact ADMIN --}}
     <script>
        let btn_contact = document.querySelectorAll('.accordion-button')
        btn_contact.forEach(el => {
            el.addEventListener('click', () => {
                btn_contact.forEach(ele => {
                    ele.classList.remove('activeContact')
                });

                el.classList.add('activeContact')

            })
        });
    </script>


</body>

</html>
