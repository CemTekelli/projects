<div id="collpaseFurniture" class="accordion-collapse collapse show" aria-labelledby="headingOne"
    data-bs-parent="#accordionExample">
    @forelse (array_reverse($mail_furniture) as $item)
        <li class="message open">
            <div class="user-action px-3">{{ $loop->iteration }}.</div>
            <form action="{{ route('contact.destroy', $item->id) }}">
                @csrf
                <button class="btn">X</button>
            </form>

            <button type="button" class="btn-msg" data-bs-toggle="modal" data-bs-target="#large{{ $item->id }}">
                <div class="media-body">
                    <div class="user-details">
                        <div class="mail-items">
                            <span class="list-group-item-text text-truncate ">{{$item->subject}} </span>
                        </div>
                        <div class="mail-meta-item">
                            <span class="float-right">
                                @php
                                    // dump(date('Y-m-d H:i:s'))
                                    $today = date('Y-m-d');
                                    $date_mail_send = $item->created_at->format('Y-m-d');
                                    if ($today == $date_mail_send){
                                        $date = $item->created_at->format('H:i');
                                    }else {
                                        $date = $item->created_at->format('d M.');
                                    }
                                @endphp
                                <span class="mail-date">{{ $date }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="mail-message">
                        @php
                           $brico = $item->message;
                           $result = substr($brico, 0, 65);
                           $result2 = $result . " ...";
                       @endphp
                       <p class="list-group-item-text truncate mb-0">
                           {{$result2}}
                       </p>

                   </div>
                </div>
            </button>
    </li>
     {{-- ---- MODAL ---- --}}
     @include('partials.modal-email')
    @empty
            <p class="p-5">not mail available </p>
    @endforelse
</div>


<div id="collapseMoving" class="accordion-collapse collapse" aria-labelledby="headingTwo"
    data-bs-parent="#accordionExample">
    @forelse (array_reverse($mail_moving) as $item)
        <li class="message open">
            <div class="user-action px-3">{{ $loop->iteration }}.</div>
            <form action="{{ route('contact.destroy', $item->id) }}">
                @csrf
                <button class="btn">X</button>
            </form>
            <button type="button" class="btn-msg" data-bs-toggle="modal" data-bs-target="#large{{ $item->id }}">
                <div class="media-body">
                    <div class="user-details">
                        <div class="mail-items">
                            <span class="list-group-item-text text-truncate ">{{$item->subject}}</span>
                        </div>
                        <div class="mail-meta-item">
                            <span class="float-right">
                                @php
                                    $today = date('Y-m-d');
                                    $date_mail_send = $item->created_at->format('Y-m-d');
                                    if ($today == $date_mail_send){
                                        $date = $item->created_at->format('H:i');
                                    }else {
                                        $date = $item->created_at->format('d M.');
                                    }
                                @endphp
                                <span class="mail-date">{{$date}}</span>
                            </span>
                        </div>
                    </div>
                    <div class="mail-message">
                         @php
                            $brico = $item->message;
                            $result = substr($brico, 0, 65);
                            $result2 = $result . " ...";
                        @endphp
                        <p class="list-group-item-text truncate mb-0">
                            {{$result2}}
                        </p>

                    </div>
                </div>
            </button>
    </li>
     {{-- ---- MODAL ---- --}}
     @include('partials.modal-email')
    @empty
            <p class="p-5">not mail available </p>
    @endforelse


</div>
