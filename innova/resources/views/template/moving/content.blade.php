<div class="moving container">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 text-content">
            <h1 class="display-1">Transport</h1>
            <h2 class="display-3">Service</h2>
            <p>{{ __('messages.title_moving') }}</p>
            <ul>
                <li>{{ __('messages.pack.lift') }}</li>
                <li>{{ __('messages.pack.montage') }}</li>
                <li>{{ __('messages.pack.packaging') }}</li>
                <li>{{ __('messages.pack.cleaning') }}</li>
            </ul>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 div-img">
            <img  src="{{ asset('/img/moving/carton2.jpg') }}" alt="carton">
            <img class="respo-img-none"  src="{{ asset('/img/moving/humain.jpg') }}" alt="humain">
        </div>
    </div>
    <hr class="my-5 py-5" id="movingContact">
    <div class="row my-5 py-5" >
        <div class="col-12">
            <h2 class="contact-title text-center">{{ __('messages.contact_name') }}</h2>
            <div class="w-75 mx-auto text-center">
                @include('layouts.flash')
            </div>
        </div>
        <div class="col-lg-8 mx-auto">
            <form class="form-contact contact_form" action="{{ route('contact.store') }}" method="post" id="contactForm" >
                @csrf
                <input style="display: none" type="text" name="type" value="moving" readonly>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control valid" required name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="{{ __('messages.form.name') }}" 
                            value="{{ Auth::check() ? Auth::user()->name . ' ' . Auth::user()->firstname : '' }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input class="form-control valid" required name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="{{ __('messages.form.email') }}"
                            value="{{ Auth::check() ? Auth::user()->email : '' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input class="form-control" required name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="{{ __('messages.form.subject') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea class="form-control w-100" required name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder="{{ __('messages.form.message') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="button button-contactForm boxed-btn">{{ __('messages.form.btn') }}</button>
                </div>
            </form>
        </div>
    
    </div>
</div>