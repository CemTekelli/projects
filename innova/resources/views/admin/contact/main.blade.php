@extends('layouts.back')

@section('title-page')
    <h3>Mail</h3>

@endsection

@section('content')
    @include('layouts.flash')
    <div class="page-heading email-application">

        <section class="section content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content email-app-sidebar d-flex">
                        <!-- sidebar close icon -->
                        <span class="sidebar-close-icon">
                            <i class="bx bx-x"></i>
                        </span>
                        <!-- sidebar close icon -->
                        <div class="email-app-menu">
                            <div class="form-group form-group-compose">
                                <!-- compose button  -->
    
                                <span  class="email-title my-4 compose-btn">
                                    <i class="bx bx-plus"></i>
                                    MailBox
                                </span>
                            </div>
                            <div class="sidebar-menu-list ps">
                                <!-- sidebar menu  -->
                                <div class="list-group list-group-messages">
                                
                                    <button class="accordion-button btn-msg activeContact ps-2" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collpaseFurniture" aria-expanded="true"
                                        aria-controls="collpaseFurniture">
                                        Furniture
                                    </button>
                                 
                                    <button class="accordion-button collapsed btn-msg ps-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseMoving"
                                        aria-expanded="false" aria-controls="collapseMoving">
                                        Moving
                                    </button>


                                </div>

                               

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper">

                    <div class="content-body">
                        <div class="email-app-area">
                            <div class="email-app-list-wrapper">
                                <div class="email-app-list">
                                    <div class="email-action">
                                        
                                        <div
                                            class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                                          
                                            <span class="d-none d-sm-block">Total mail <strong>{{ count($contact) }}</strong> </span>
                                            {{-- <span class="d-none d-sm-block">Unread email <strong>{{ count($count_close) }}</strong> </span> --}}
                                        </div>
                                    </div>

                                    <div class="msg-parent-list">
                                        <ul class="msg-list">
                                            <div class="accordion" id="accordionExample">
                                                {{-- ---- COLLAPSE ---- --}}
                                                @include('partials.collapse-email')
                                            </div>

                                        </ul>
                                    </div>

                                   
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
