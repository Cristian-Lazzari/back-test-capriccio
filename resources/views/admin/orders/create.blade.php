@extends('layouts.base')

@section('contents')
    @php
    $days_name = [' ','lunedì', 'martedi', 'mercoledì', 'giovedì', 'venerd', 'sabato', 'domenica'];
    @endphp


<div class="container py-2">
        
    @if (session('reserv_success'))
        <div class="alert alert-success">
            Ordine avvenuto correttamente!
        </div>
        @endif
        
        @if (session('max_res_check'))
            <div class="alert alert-danger">
               <h3 for="max_check">Stai superando il limite di pezzi disponibili per questa data!</h3>
               <h4 for="max_check">Vuoi continuare comunque?</h4>
               
               <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                <input type="checkbox" class="btn-check" id="btncheck1" name="max_check" autocomplete="off">
                <label class="btn btn-outline-danger" for="btncheck1">Continua</label>
              
               
              </div>
             
              <button class="btn  w-75 m-auto btn-primary d-block">Salva</button>
            </div>
        @endif

        <h1 class="py-4">Nuovo Ordine D'Asporto</h1>

        <form 
            action="{{ route('admin.orders.store') }}" 
            enctype="multipart/form-data"
            method="POST"
            class="px-2 py-5 s5a rounded c-white"
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
                <label for="total_pz_q" class="form-label fw-semibold">N° di pezzi al taglio</label>
                <input
                    type="number"
                    class="form-control w-75 m-auto text-center @error('total_pz_q') is-invalid @enderror"
                    id="total_pz_q"
                    name="total_pz_q"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['total_pz_q'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('total_pz_q') {{ $message }} @enderror
                </div>
            </div>
            <div class="mb-5 text-center">
                <label for="total_pz_t" class="form-label fw-semibold">N° di pizze al piatto</label>
                <input
                    type="number"
                    class="form-control w-75 m-auto text-center @error('total_pz_t') is-invalid @enderror"
                    id="total_pz_t"
                    name="total_pz_t"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['total_pz_t'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('total_pz_t') {{ $message }} @enderror
                </div>
            </div>
    
            <div class="mb-5 text-center">
                <label for="total_price" class="form-label fw-semibold">Prezzo totale - in centesimi * opzionale</label>
                <input
                    type="number"
                    class="form-control w-75 m-auto text-center @error('total_price') is-invalid @enderror"
                    id="total_price"
                    name="total_price"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['total_price'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('total_price') {{ $message }} @enderror
                </div>
            </div>
            <div class="mb-5 text-center">
                <label for="address" class="form-label fw-semibold">Comune (se con consena a domicilio)</label>
                <select
                    class="form-select w-75 m-auto text-center @error('address_id') is-invalid @enderror"
                    id="address"
                    name="comune"
                >
                    <option value="0">Nessuno</option>
                    @foreach ($addresses as $address)
                        <option 
                            value="{{ $address->comune }}"
                            @if (isset(session('inputValues')['comune']))
                                selected
                            @endif
                        >
                            {{ $address->comune }}
                        </option>
                    @endforeach
                </select>
                @error('address_id')
                    <div class="invalid-feedback fw-semibold">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-5 text-center">
                <label for="indirizzo" class="form-label fw-semibold">Indirizzo (se con consena a domicilio)</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('indirizzo') is-invalid @enderror"
                    id="indirizzo"
                    name="indirizzo"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['indirizzo'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('indirizzo') {{ $message }} @enderror
                </div>
            </div>
    
            <div class="mb-5 text-center">
                <label for="civico" class="form-label fw-semibold">Civico (se con consena a domicilio)</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('civico') is-invalid @enderror"
                    id="civico"
                    name="civico"
                    @if (session('inputValues'))
                        value="{{ session('inputValues')['civico'] }}"
                    @endif
                >
                <div class="invalid-feedback fw-semibold">
                    @error('civico') {{ $message }} @enderror
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
                <div class="invalid-feedback fw-semibold">
                    @error('message') {{ $message }} @enderror
                </div>
            </div>
    
            <button class="btn mb-5 w-75 m-auto btn-dark d-block">Salva</button>
            
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
                <label class="btn btn-outline-dark" for="btnradio{{$date->id}}">
                    {{$date->time}} | {{$date->day}}/{{$date->month}}/{{$date->year}} | 
                    disp. taglio <strong>{{$date->max_pz_q - $date->reserved_pz_q}}</strong> |
                    disp. piatto <strong>{{$date->max_pz_t - $date->reserved_pz_t}}</strong> 
                </label>
    
                @endforeach
            </div>
         
      
            <button class="btn  w-75 m-auto btn-dark d-block">Salva</button>
    
        </form>
    </div>
    
@endsection