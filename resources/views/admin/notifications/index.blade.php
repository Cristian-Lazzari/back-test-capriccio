<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title" id="offcanvasExampleLabel">Gestione Notifiche</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if (count($notifications) !== 0)
            <div>
                @foreach ($notifications as $item)

                    @php
                        $orderOrReservation = $item->source ? 'text-success' : 'text-primary'
                    @endphp

                    <div class="accordion accordion-flush " id="accordionFlushExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold {{ $orderOrReservation }}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{ $item->id }}" aria-expanded="false" aria-controls="flush-collapseOne-{{ $item->id }}">
                                    {{ $item->title }}
                                </button>
                                {{-- qui bisogna mettere un bottone per reindirizzare alla prenotazione o all'ordine --}}
                            </h2>

                            <div id="flush-collapseOne-{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="fs-5">{{ $item->message }}</div>
                                    <div class="mb-2">Effettuato/a il: {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</div>

                                    <form class="d-inline" action="{{ route('admin.notifications.showAndDestroy', $item->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="text-primary border-0" >Visualizza</button>
                                    </form>

                                    <form class="d-inline" action="{{ route('admin.notifications.destroy', $item->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="text-danger border-0" >Elimina</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <form class="delete-all" action="{{  route('admin.notifications.clearAll')}}">
                <button class="btn btn-danger">Cancella tutto</button>
            </form>
        @else
            <h6>Non ci sono nuove notifiche</h6>
        @endif
    </div>
</div>

