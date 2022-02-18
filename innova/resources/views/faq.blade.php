@extends('layouts.index')

@section('title-page')
    <title>Innova - FAQ</title>
@endsection


@section('content')
    <header>
        @include('template.loader')
        @include('template.header')
    </header>
    <main>
        @include('template.banner')
        <div class="section-faq">
            @forelse ($faqs as $item)   
            @if (App::getLocale() == "fr")
                <div class="faq">
                    <div class="faq-question">
                        <!-- ICON svg -->
                        <svg class="faq-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg " width="30"
                            height="20" x="0px" y="0px" viewBox="0 0 1792 1792" style="enable-background:new 0 0 1792 1792;"
                            xml:space="preserve">
                            <path
                                d="M983.3,1532.1c-23.2,23.6-55.6,35.9-88.6,33.6c-31.9,2.4-63-10-84.6-33.6L261.8,985.8c-45.4-45.4-45.4-119,0-164.4
                                    s119-45.4,164.4,0l354.4,354.4V342.1c-0.4-63.8,51-115.8,114.8-116.1c0.2,0,0.4,0,0.7,0c64,0.4,115.8,52.1,116.1,116.1v833.6
                                    l353.7-354.4c45.4-45.4,119-45.4,164.4,0c45.4,45.4,45.4,119,0,164.4l0,0L983.3,1532.1z" />
                        </svg>

                        <h3>{{ $item->ask_fr }}</h3>
                    </div>

                    <div class="faq-anwser pb-0">
                        <p class="m-0 py-4">{{ $item->reponse_fr }}
                        </p>
                    </div>
                </div>
            @elseif (App::getLocale() == "en")
            <div class="faq">
                <div class="faq-question">
                    <!-- ICON svg -->
                    <svg class="faq-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg " width="30"
                        height="20" x="0px" y="0px" viewBox="0 0 1792 1792" style="enable-background:new 0 0 1792 1792;"
                        xml:space="preserve">
                        <path
                            d="M983.3,1532.1c-23.2,23.6-55.6,35.9-88.6,33.6c-31.9,2.4-63-10-84.6-33.6L261.8,985.8c-45.4-45.4-45.4-119,0-164.4
                                s119-45.4,164.4,0l354.4,354.4V342.1c-0.4-63.8,51-115.8,114.8-116.1c0.2,0,0.4,0,0.7,0c64,0.4,115.8,52.1,116.1,116.1v833.6
                                l353.7-354.4c45.4-45.4,119-45.4,164.4,0c45.4,45.4,45.4,119,0,164.4l0,0L983.3,1532.1z" />
                    </svg>

                    <h3>{{ $item->ask_en }}</h3>
                </div>

                <div class="faq-anwser pb-0">
                    <p class="m-0 py-4">{{ $item->reponse_en }}
                    </p>
                </div>
            </div>
            @else
                <div class="faq">
                    <div class="faq-question">
                        <!-- ICON svg -->
                        <svg class="faq-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg " width="30"
                            height="20" x="0px" y="0px" viewBox="0 0 1792 1792" style="enable-background:new 0 0 1792 1792;"
                            xml:space="preserve">
                            <path
                                d="M983.3,1532.1c-23.2,23.6-55.6,35.9-88.6,33.6c-31.9,2.4-63-10-84.6-33.6L261.8,985.8c-45.4-45.4-45.4-119,0-164.4
                                    s119-45.4,164.4,0l354.4,354.4V342.1c-0.4-63.8,51-115.8,114.8-116.1c0.2,0,0.4,0,0.7,0c64,0.4,115.8,52.1,116.1,116.1v833.6
                                    l353.7-354.4c45.4-45.4,119-45.4,164.4,0c45.4,45.4,45.4,119,0,164.4l0,0L983.3,1532.1z" />
                        </svg>

                        <h3>{{ $item->ask }}</h3>
                    </div>

                    <div class="faq-anwser pb-0">
                        <p class="m-0 py-4">{{ $item->reponse }}
                        </p>
                    </div>
                </div>

            @endif
            
            @empty
                <h1>COMING SOON..</h1>
            @endforelse


        </div>
        <div class="text-center">
            <p class="h1 py-5 my-5 blue-central">
                {{ __('messages.faq.ask') }}
                <br>
                {{ __('messages.faq.call') }}

                <a class="a-perso" href="tel:+32468040237">+32 468 04 02 37</a>
                {{ __('messages.faq.send') }}

                <a class="a-perso" href="{{ route('contact') . '#contact' }}">e-mail</a>.
            </p>
        </div>

    </main>
    @include('template.footer')
@endsection
