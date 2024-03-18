@extends('layouts.base')

@section('contents')
    {{-- <img src="{{ Vite::asset('resources/img/picsum30.jpg') }}" alt=""> --}}
   

    
    <h1 class="my-5">ORDINI D'ASPORTO</h1>

    @if (session('confirm_success'))
        <div class="alert alert-success">
            Ordine confermato correttamente
        </div>
    @endif

    @if (session('reject_success'))
        <div class="alert alert-success">
            Ordine annullato correttamente
        </div>
    @endif

    @if (session('error_confirm'))
        <div class="alert alert-danger">
            Quest'ordine è già confermato
        </div>
    @endif

    @if (session('error_reject'))
        <div class="alert alert-danger">
            Quest'ordine è già annullato
        </div>
    @endif

    @if (session('email_error'))
        <div class="alert alert-danger">
            Non è stato possibile inviare l'email
        </div>
    @endif

    <a  href="{{ route('admin.months.index') }}" class="btn btn-warning w-50 m-auto my-3 d-block">Gestione date</a>
    <a  href="{{ route('admin.orders.create') }}" class="btn btn-success w-50 m-auto my-3 d-block">Nuovo Ordine</a>
    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
        </svg>  FILTRA
    </a>
    <div class="collapse mt-2" id="collapseExample">
        <div class="card card-body">

            {{-- FILTRI  --}}
            <form action="{{ route('admin.orders.filters')}}" class="filter mb-2" method="GET">

                <h3 class="w-100">Filtri</h3>
                
                <div>
                    <label for="name" class="form-label">Nome Cliente</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        @if (isset($name))
                            value="{{ $name }}"  
                        @endif
                    >
                </div>
        
                <div>
                    <label for="status" class="form-label">Stato</label>
                    <select
                        class="form-select w-auto"
                        id="status"
                        name="status"
                    >
                        <option 
                            @if (!isset($status))
                                selected
                            @endif
                            value="" 
                        >Tutti</option>
                        <option 
                            @if (isset($status) && $status == '0')
                                selected
                            @endif value="0"
                        >In Elaborazione</option>
                        <option 
                            @if (isset($status) && $status == '1')
                                selected
                            @endif value="1"
                        >Confermati</option>
                        <option 
                            @if (isset($status) && $status == '2')
                                selected
                            @endif value="2"
                        >Annullati</option>
                    </select>
                </div>
                <div>

                    <label for="date_order" class="form-label">Ordina per data</label>
                    <select
                        class="form-select w-auto"
                        id="date_order"
                        name="date_order"
                    >
                        <option 
                            @if (isset($date_order) && $date_order == '0')
                                selected
                            @endif
                            value="0"
                        >Ordina per data di creazione</option>
                        <option 
                            @if (isset($date_order) && $date_order == '1')
                                selected
                            @endif
                            value="1"
                        >Ordina per data di prenotazione</option>
                    </select>
                </div>
                <div>

                    <label for="delivery" class="form-label">Filtra per domicilio</label>
                    <select
                        class="form-select"
                        id="delivery"
                        name="delivery"
                    >
                        <option 
                            @if (isset($delivery) && $delivery == '0')
                                selected
                            @endif
                            value="nul"
                        >tutti</option>
                        <option 
                            @if (isset($delivery) && $delivery == '0')
                                selected
                            @endif
                            value="0"
                        >Ritiro in negozio</option>
                        <option 
                            @if (isset($delivery) && $delivery == '1')
                                selected
                            @endif
                            value="1"
                        >Domicilio</option>
                    </select>
                </div>
                <div>
            
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="true" aria-controls="collapseWidthExample">
                        <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off" name="dateok">
                        <label class="btn btn-outline-primary" for="btncheck1">Filtra per data</label>
                    </div>
    
            
                    <div style="min-height: 100px;">
                    <div class="collapse collapse-horizontal" id="collapseWidthExample">
                        <div class="card card-body mt-2" style="width: 150px;">
                            
                            <input 
                                type="date" 
                                name="selected_date" 
                                id="selected_date" 
                                class="form-control w-auto" 
                                @if (isset($selected_date))
                                    value="{{ $selected_date }}"  
                                @endif
                            >
                        
                        </div>
                    </div>
                    </div>
                </div>
        
                <button class="btn btn-primary w-100" type="submit">APPLICA FILTRI</button>
            </form>
        </div>
    </div>
    

    <a class="btn btn-success m-2" href="{{ route('admin.orders.index')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
    </svg> RIMUOVI FILTRI</a>

    {{-- Legenda  --}}
    <div class="py-3">
        <?php 
        $statuses = ['In Elaborazione', 'Confermato', 'Annullato'];
        ?>
        @foreach ($statuses as $status)
            @if ($status == 'In Elaborazione')
                <span class="text-warning">
                    <span>In Elaborazione</span>
            @elseif ($status == 'Confermato')
                <span class="text-success">
                    <span>Confermato</span>
            @else
                <span class="text-danger">
                    <span>Annullato</span>
            @endif
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill me-2" viewBox="0 0 16 16">
                    <circle cx="7" cy="7" r="7"/>
                </svg>
            </span>
        @endforeach
    </div>

    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Data</th>
            <th scope="col">Ora</th>
            <th scope="col">Nome</th>
            <th scope="col" class="d-none d-lg-table-cell">Telefono</th>
            <th scope="col" class="d-none d-lg-table-cell">Email</th>
            <th scope="col" class="d-none d-lg-table-cell">Creato il</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <?php
                $data_ora = DateTime::createFromFormat('d/m/Y H:i', $order->date_slot);
                $ora_formattata = $data_ora->format('H:i');
                $data_formattata = $data_ora->format('d/m');

                if ($order->status == 0) {
                    $dot_status = 'bg-warning';
                } else if ($order->status == 1) {
                    $dot_status = 'bg-success';
                } else {
                    $dot_status = 'bg-danger';
                }
                ?>
                <tr class="table_row">
                    {{-- DATA  --}}
                    <td 
                        class="{{ $dot_status }}" 
                        style="--bs-bg-opacity: .6;" 
                        onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                    >
                        {{ $data_formattata }}
                    </td>

                    {{-- ORA  --}}
                    <td 
                        class="{{ $dot_status }}" 
                        style="--bs-bg-opacity: .6;" 
                        onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                    >
                        {{ $ora_formattata }}
                    </td>

                    {{-- NOME  --}}
                    <td 
                        class="{{ $dot_status }}" 
                        style="--bs-bg-opacity: .6;" 
                        onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                    >
                        {{ $order->name }}
                    </td>

                    {{-- TELEFONO  --}}
                    <td 
                        class="text-truncate d-none d-lg-table-cell {{ $dot_status }}" style="--bs-bg-opacity: .6;" 
                        onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                    >
                        <a 
                            class="phone text-decoration-none" 
                            href="{{ "https://wa.me/" . '39' . $order->phone }}"
                        >
                            {{ $order->phone }}
                        </a>
                    </td>

                    {{-- EMAIL  --}}
                    <td 
                        class="text-truncate d-none d-lg-table-cell {{ $dot_status }}" style="--bs-bg-opacity: .6;" 
                        onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                    >
                        {{ $order->email }}
                    </td>

                    {{-- DATA CREAZIONE  --}}
                    <td 
                        class="d-none d-lg-table-cell {{ $dot_status }}" 
                        style="--bs-bg-opacity: .6;" 
                        onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                    >
                        {{ date('d/m/Y H:i', strtotime($order->created_at)) }}
                    </td>

                    {{-- BOTTONI  --}}
                    <td class="{{ $dot_status }}" style="--bs-bg-opacity: .6;">
                        {{-- CONFERMA ORDINE  --}}
                        @if ($order->status !== 1)
                            <button 
                                title="Conferma Ordine" 
                                class="btn btn-success" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmModal-{{ $order->id }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-white" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $order->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  action="{{ route('admin.orders.confirmOrder', $order->id) }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="confirmModalLabel">Conferma: vuoi inviare una notifica al cliente?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="no">No
                                                    <input class="me-2" type="radio" name="confirm" id="no" value="no">
                                                </label>
                                                <label for="w_app">WhatsApp
                                                    <input class="me-2" type="radio" name="confirm" id="w_app" value="wa">
                                                </label>
                                                <label for="email">Email
                                                    <input class="me-2" type="radio" name="confirm" id="email" value="em">
                                                </label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                <button type="submit" class="btn btn-primary">Procedi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- ANNULLA ORDINE  --}}
                        @if ($order->status !== 2)
                            <button 
                                title="Annulla Ordine" 
                                class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#rejectModal-{{ $order->id }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                </svg>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="rejectModal-{{ $order->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <form  action="{{ route('admin.orders.rejectOrder', $order->id) }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="rejectModalLabel">Annullamento: vuoi inviare una notifica al cliente?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="no">No
                                                <input class="me-2" type="radio" name="confirm" id="no" value="no">
                                            </label>
                                            <label for="w_app">WhatsApp
                                                <input class="me-2" type="radio" name="confirm" id="w_app" value="wa">
                                            </label>
                                            <label for="email">Email
                                                <input class="me-2" type="radio" name="confirm" id="email" value="em">
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <button type="submit" class="btn btn-primary">Procedi</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>

    {{ $orders->links() }}
@endsection
