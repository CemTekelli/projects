<!Doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @yield('title-page')
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('img/innovaImg/logo-hd.png') }}">

    {{-- CSS  Filter product --}}
    <link rel="stylesheet" href={{ asset('css/isotope/bootstrap.min.css') }}>
    <link href={{ asset('css/isotope/boxicons.min.css') }} rel="stylesheet">
    <link href={{ asset('css/isotope/venobox.css') }} rel="stylesheet">

    <link href={{ asset('css/isotope/isotope.css') }} rel="stylesheet">

    <!-- CSS TEMPLATE -->
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/progressbar_barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightslider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/price_rangs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">


</head>

<body>


    @yield('content')


    <!-- JS here -->
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ asset('js/vendor/modernizr.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Slick-slider , Owl-Carousel ,slick-nav -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>

    <!-- One Page, Animated-HeadLin, Date Picker , price, light-slider -->
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/animated.headline.js') }}"></script>
    {{-- <script src="{{ asset("js/jquery.magnificpopup.js") }}"></script> --}}
    <script src="{{ asset('js/gijgo.min.js') }}"></script>
    <script src="{{ asset('js/lightslider.min.js') }}"></script>
    <script src="{{ asset('js/price_rangs.js') }}"></script>

    <!-- Nice-select, sticky,Progress -->
    <script src="{{ asset('js/jquery.niceselect.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/jquery.barfiller.js') }}"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/hover-direction-snake.min.js') }}"></script>

    <!-- contact js -->
    {{-- <script src="{{ asset("js/contact.js") }}"></script>
    <script src="{{ asset("js/jquery.form.js") }}"></script>
    <script src="{{ asset("js/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("js/mail-script.js") }}"></script>
    <script src="{{ asset("js/jquery.ajaxchimp.min.js") }}"></script> --}}




    {{-- JS filter product --}}
    {{-- <script src={{ asset("js/isotope/jquery.min.js") }}></script> --}}
    <script src={{ asset('js/isotope/jquery.waypoints.min.js') }}></script>
    <script src={{ asset('js/isotope/counterup.min.js') }}></script>
    <script src={{ asset('js/isotope/isotope.pkgd.min.js') }}></script>
    <script src={{ asset('js/isotope/venobox.min.js') }}></script>
    <script src={{ asset('js/isotope/owl.carousel.min.js') }}></script>
    <script src={{ asset('js/isotope/aos.js') }}></script>
    <script src={{ asset('js/isotope/main.js') }}></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        document.cookie
        let links_tel = document.querySelectorAll('.portfolio-links')
        let btn_anim = document.querySelectorAll('.venobox')
        btn_anim.forEach((el, i) => {

            el.addEventListener('click', () => {
                // btn_anim.forEach((item, i) => {
                //     console.log('feux');
                //     links_tel[i].style.bottom = "-60px"
                //     links_tel[i].style.opacity = 0
                // });
                links_tel[i].style.bottom = 0
                links_tel[i].style.opacity = 1
            })
        });
        //////////////////////

        let parent_child = document.querySelector('.parent_child')
        let e = document.querySelectorAll('.event-product')
        e.forEach(el => {
            el.addEventListener('click', (e) => {
                let nbr_products = document.querySelector('#countProduct')
    
                let nombre = 0
                function resolveAfter2Seconds() {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let nbr_child = document.querySelectorAll('#product_child')
                            nbr_child.forEach(elem => {
                                if (elem.style.display !== "none") {
                                    nombre++
                                } 
                            })
                            nbr_products.innerText = `${nombre} product found`
                        }, 480);
                    });
                }
                async function asyncCall() {
                    await resolveAfter2Seconds();
                }
        
                asyncCall();
            })
            
        });
    </script>
</body>

</html>
