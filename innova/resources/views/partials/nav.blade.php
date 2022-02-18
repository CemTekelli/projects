<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="{{ asset("img/innova/innovalogo.jpg") }}" alt="innova-logo" srcset="">Furniture  </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <form class="text-center" method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="btn btn-primary">Logout</button>
        </form>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ request()->path() == 'admin/dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->path() == 'admin/users' ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Users</span>
                    </a>
                </li>

    

                <li class="sidebar-title">Innova Web</li>

                @php
                    use App\Models\Comment;
                    $comment = DB::table('comments')->where('validate', 0)->get();
                    
            
                @endphp
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-pen-fill"></i>
                        <span>Products</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{ route('product.index') }}">Indoor</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('product.outdoor') }}">Outdoor</a>
                        </li>
                        <li class="submenu-item position-relative">
                            <a href="{{ route('comment.index') }}">Comments</a>
                            {{-- <span class="nbr-close">{{ count($count_close) }}</span> --}}
                            <span class="nbr-close">{{ count($comment) }}</span>

                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  {{ request()->path() == 'admin/testimonial' ? 'active' : '' }}">
                    <a href="{{ route('testimonial.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-ppt-fill"></i>
                        <span>Testimonials</span>
                    </a>
                </li>
    
                <li class="sidebar-item  {{ request()->path() == 'admin/faq' ? 'active' : '' }}">
                    <a href="{{ route('faq.index') }}" class='sidebar-link'>
                        <i class="bi bi-question-square-fill"></i>
                        <span>FAQ</span>
                    </a>
                </li>
                <li class="sidebar-item  {{ request()->path() == 'admin/instagram' ? 'active' : '' }}">
                    <a href="{{ route('instagram.index') }}" class='sidebar-link'>
                        <i class="bi bi-instagram"></i>
                        <span>Instagram</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->path() == 'admin/parteners' ? 'active' : '' }}">
                    <a href="{{ route('parteners.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-ppt-fill"></i>
                        <span>Parteners</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item {{ request()->path() == 'admin/about' ? 'active' : '' }}">
                    <a href="{{ route('about.index') }}" class='sidebar-link'>
                        <i class="bi bi-info-circle-fill"></i>
                        <span>About</span>
                    </a>
                </li> --}}
                    {{-- @php
                        use App\Models\Contact;
                        $contact = Contact::all();
                        $count_close = [];
                        foreach ($contact as $value) {
                            if ($value->open === 0) {
                                array_push($count_close, $value);
                                # code...
                            }
                        }
                    @endphp --}}

                <li class="sidebar-item {{ request()->path() == 'admin/contact' ? 'active' : '' }} nbr-close-parent">
                    <a href="{{ route('contact.index') }}" class='sidebar-link'>
                        <i class="bi bi-envelope-fill"></i>
                        <span>Contact</span>
                    </a>
                    {{-- <span class="nbr-close">{{ count($count_close) }}</span> --}}
                </li>
              
          




                <li class="sidebar-title">Click and Collect</li>
                <li class="sidebar-item  ">
                    <a href="ui-file-uploader.html" class='sidebar-link'>
                        <i class="bi bi-bag-check-fill"></i>                        
                        <span>General</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="ui-file-uploader.html" class='sidebar-link'>
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Stat</span>
                    </a>
                </li>



            </ul>
        </div>
   
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>