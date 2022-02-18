<!-- Header Start -->
<div class="header-area">
    <div class="main-header header-sticky">
        <div class="container-fluid">
            <div class="row menu-wrapper align-items-center justify-content-between">
                <div class="header-left d-flex align-items-center">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('home') }}"><img  src="{{ asset('img/innovaImg/logo-hd.png') }}"
                                alt="logo-hd"></a>
                    </div>
                    <!-- Logo-2 -->
                    <div class="logo2">
                        <a href="{{ route('home') }}"><img height="80px" src="{{ asset('img/innovaImg/logo-hd.png') }}"
                                alt="logo-hd"></a>
                    </div>
                    <!-- Main-menu -->
                    <div class="main-menu  d-none d-lg-block">
                        <nav>
                            <ul id="navigation">
                                <li><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                                {{-- <li><a href="{{ route('product') }}">Product</a></li> --}}
                                <li><a href="###">{{ __('messages.products') }}</a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('indoor') }}">indoor</a></li>
                                        <li><a href={{ route('outdoor') }}>outdoor</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                                <li><a href="{{ route('faq') }}">F.A.Q</a></li>
                                {{-- <li><a href="{{ route('catalogue') }}">Catalogue</a></li> --}}
                                <li><a href="{{ route('moving') }}">Moving</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                                <li class="ml-2">
                                    <a href="#">
                                        <img class="mr-1" height="18px" src="{{ asset('img/flag/'. Config::get('languages')[App::getLocale()]['flag-icon'] . ".png") }}" alt="lang-{{ Config::get('languages')[App::getLocale()]['flag-icon'] }}">
                                        {{ Config::get('languages')[App::getLocale()]['display'] }}
                                    </a>
                                    <ul class="submenu">
                                        @foreach (Config::get('languages') as $lang => $language)
                                            @if ($lang != App::getLocale())
                                                <li>
                                                    <a href="{{ route('lang.switch', $lang) }}" class="d-flex align-items-center">
                                                        <img class="mr-1" height="18px" src="{{ asset('img/flag/'. $language['flag-icon'] . ".png") }}" alt="lang-{{ $language['flag-icon'] }}">
                                                        {{$language['display']}}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                       
                                    </ul>
                                    {{-- <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        @foreach (Config::get('languages') as $lang => $language)
                                            @if ($lang != App::getLocale())
                                                    <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
                                            @endif
                                        @endforeach
                                        </div>
                                    </li> --}}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="header-right1 d-flex align-items-center">
                 
                    <div class="search">
                        <ul class="d-flex align-items-center">
                            <li>
                                <!-- Search Box -->
                                {{-- <form action="{{ route('search') . "?filter[name]=" . "mys"  }}" class="form-box f-right " method="POST"> --}}
                                <form action="{{ route('search') }}" class="form-box f-right " method="GET">
                                    <input type="text" name="filter[name]" placeholder="Search products" 
                                    @if ($message = Session::get('warning'))
                                    class="is-invalid"
                                    @endif>
                                    @if ($message = Session::get('warning'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @endif
                                    <div class="search-icon">
                                        <button class="icon-search p-3 m-0">
                                            <i class="ti-search"></i>
                                        </button>
                                    </div>
                                </form>
                                {{-- <form action="{{ request()->fullUrl() }}" class="widget-search" method="GET">
                                    <input type="search" name="filter[name]" placeholder="">
                                    <button class="btn-search" id="searchsubmit" type="submit">
                                      <i class="fa "></i>
                                    </button>
                                  </form> --}}
                            </li>
                            {{-- PARTIE LOGIN --}}
                            {{-- <li>
                                @if (Auth::user())
                                    <a href="{{ route('admin') }}" class="account-btn">My Account</a>
                                @else
                                    <a href="{{ route('login') }}" class="account-btn">Login</a>
                                @endif
                            </li>
                            @if (Auth::user())
                                <li>
                                    <div class="card-stor">
                                        <img src={{ asset('img/icon/card.svg') }} alt="">
                                        <span>0</span>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </div>
                </div>
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->
