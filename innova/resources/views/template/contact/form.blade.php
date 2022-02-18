<div class="row" >
    <div class="col-12">
        <h2 class="contact-title">{{ __("messages.page_contact_name") }}</h2>
        
    </div>
    <div class="w-50 ">
        @include('layouts.flash')

    </div>
    <div class="col-lg-8">
        <form class="form-contact contact_form" action="{{ route('contact.store') }}" method="post"  >
            @csrf
            <input style="display: none" type="text" name="type" value="furniture" readonly>
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
    <div class="col-lg-3 offset-lg-1">
        <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
                <h3> Krekelendries 11, 1785</h3>
                <p>Merchtem, Belgique.</p>
            </div>
        </div>
        <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
            <div class="media-body">
                <h3><a href="tel:+3252518712">+32 (0) 52 51 87 12</a></h3>
                <p><a style="color: #8a8a8a !important" href="tel:+32468040237">+32 (0) 468 04 02 37</a></p>
            </div>
        </div>
        <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
                <h3><a href="mailto:info@innovafurniture.be">info@innovafurniture.be</a></h3>
                <p>{{ __('messages.mail_contact') }}</p>
            </div>
        </div>
        <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-timer"></i></span>
            <div class="media-body">
                {{-- <h3>innova@info.be</h3> --}}
                <h3>{{ __('messages.opening.monday') }}</h3>
                <p class="m-0">{{ __('messages.opening.tuesday') }}</p>
                <p >{{ __('messages.opening.hour') }}</p>
                <p class="mb-1">{{ __('messages.opening.sunday') }}</p> 
                <p>{{ __('messages.opening.hour_sund') }}</p> 
            </div>
        </div>
    </div>
</div>