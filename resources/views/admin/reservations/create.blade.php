@extends('layouts.base')

@section('contents')
    @php
    $days_name = [' ','lunedì', 'martedi', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
    @endphp


    <div class="container py-2">
        
        @if (session('reserv_success'))
            <div class="alert alert-success">
                Prenotazione avvenuta correttamente!
            </div>
        @endif

        @if (session('max_res_check'))
            <div class="alert alert-danger">
            <h3 for="max_check">Stai superando il limite di posti disponibili per questa data!</h3>
            <h4 for="max_check">Vuoi continuare comunque?</h4>
            
            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                <input type="checkbox" class="btn-check" id="btncheck1" name="max_check" autocomplete="off">
                <label class="btn btn-outline-danger" for="btncheck1">Continua</label>
            </div>
            
            <button class="btn  w-75 m-auto btn-primary d-block">Salva</button>
            </div>
        @endif

        <h1 class="py-4">Nuova Prenotazione Tavolo</h1>

        <form 
            action="{{ route('admin.reservations.store') }}" 
            enctype="multipart/form-data" 
            method="POST" 
            class="px-2 py-5 s4a rounded c-white"
        >
            @csrf
    
            <div class="mb-5 text-center">
                <label for="name" class="form-label fw-semibold">Nome</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['name'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>
    
            <div class="mb-5 text-center">
                <label for="phone" class="form-label fw-semibold">Telefono</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('phone') is-invalid @enderror"
                    id="phone"
                    name="phone"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['phone'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('phone') {{ $message }} @enderror
                </div>
            </div>
    
            <div class="mb-5 text-center">
                <label for="email" class="form-label fw-semibold">Email * opzionale</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    @if (session('inputValues.email'))
                        value="{{ session('inputValues')['email'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('email') {{ $message }} @enderror
                </div>
            </div>
    
            <div class="mb-5 text-center">
                <label for="n_person" class="form-label fw-semibold">N° di posti</label>
                <input
                    type="number"
                    class="form-control w-75 m-auto text-center @error('n_person') is-invalid @enderror"
                    id="n_person"
                    name="n_person"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['n_person'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('n_person') {{ $message }} @enderror
                </div>
            </div>
    
            <div class="mb-5 text-center">
                <label for="message" class="form-label fw-semibold">Messaggio</label>
                <textarea 
                    class="form-control w-75 m-auto text-center" 
                    name="message" 
                    id="message" 
                    cols="30" 
                    rows="10"
                > 
                    @if (isset(session('inputValues')['message']))
                        {{ session('inputValues')['message'] }}
                    @endif
                </textarea>
                <div class="invalid-feedback fw-semibold ">
                    @error('message') {{ $message }} @enderror
                </div>
            </div>
    
            <button class="btn mb-5 w-75 m-auto btn-light d-block">Salva</button>

            <div class="mb-5 m-auto w-50 btn-group specialradio" role="group" aria-label="Basic radio toggle button group"> 
    
                @foreach ($dates as $date)
                
                    <input 
                        type="radio" 
                        class="btn-check" 
                        name="date_id[]" 
                        value="{{$date->id}}" 
                        id="btnradio{{$date->id}}"
                        @if (session()->has('inputValues.date_id') && in_array($date->id, session('inputValues.date_id')))
                            checked
                        @endif
                    >
                    <label class="btn btn-outline-light rounded" for="btnradio{{$date->id}}">
                        {{$date->time}} | {{$date->day}}/{{$date->month}}/{{$date->year}} | <strong>{{$date->reserved}}</strong> | max: {{$date->max_res}}
                    </label>
    
                @endforeach
            </div>
         
      
            <button class="btn w-75 m-auto btn-light d-block">Salva</button>
    
        </form>
    </div>
    
@endsection