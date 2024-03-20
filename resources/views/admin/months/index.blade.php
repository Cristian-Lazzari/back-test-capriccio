@extends('layouts.base')

@section('contents')

    <?php 
        // '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '16:30', '17:00', '17:30', '18:00', '18:30',
        $times = [
            1 => ['time' => '19:00', 'set' => ''] ,
            2 => ['time' => '19:15', 'set' => ''] ,
            3 => ['time' => '19:30', 'set' => ''] ,
            4 => ['time' => '19:45', 'set' => ''] ,
            5 => ['time' => '20:00', 'set' => ''] ,
            6 => ['time' => '20:15', 'set' => ''] ,
            7 => ['time' => '20:30', 'set' => ''] ,
        ]; 
        $days = [1, 2, 3, 4, 5, 6, 7];
        $days_name = [' ','lunedì', 'martedi', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
    ?>

<a href="{{ route('admin.setting') }}" class="btn btn-dark m-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/></svg>
</a>
    <div class="row ">
        <h1 class="text-center m-3" >GESTIONE DATE</h1>
        
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="m-2">SCEGLI UN MESE</h2>    
    <div class="container row gap-2 row-gap-3 p-3">
        @foreach ($months as $month)
            <a href="{{ route('admin.days.index', ['month' =>$month->n, 'year' =>$month->y ,'month_id' =>$month->id])  }}" class="col-auto shadow fw-semibold text-white a-notlink s2a px-4 py-1 rounded-5"  > {{$month->month}} {{$month->y}}</a >
        @endforeach
    </div>

    <hr>
    <div class="container w-75 m-auto w-small-100">
        <form class="d-flex flex-column py-5"  action="{{ route('admin.dates.runSeeder') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>GENERA NUOVE DATE</h3>
            <h5 class="pt-4 ">Indica il numero di posti a sedere per fascia oraria</h5>
            <div class="input-group w-auto flex-nowrap py-2 ">
                <label for="max_reservations" class="input-group-text" >N° di posti a sedere</label>
                <input name="max_reservations" id="max_reservations" type="number" class="form-control" placeholder="N° di posti a sedere" aria-label="N° di posti a sedere" aria-describedby="addon-wrapping" value="0">
            </div>
            <div>
            <h5 class="pt-4 ">Indica il numero massimo di pezzi al taglio per l'asporto</h5>
            <div class="input-group w-auto flex-nowrap py-2 ">
                <label for="max_pz_q" class="input-group-text" >N° di pezzi</label>
                <input name="max_pz_q" id="max_pz_q" type="number" class="form-control" placeholder="N° di pezzi" aria-label="N° di pezzi" aria-describedby="addon-wrapping" value="0">
            </div>
            <div>
            <h5 class="pt-4 ">Indica il numero massimo di pizze al piatto per l'asporto</h5>
            <div class="input-group w-auto flex-nowrap py-2 ">
                <label for="max_pz_t" class="input-group-text" >N° di pizze</label>
                <input name="max_pz_t" id="max_pz_t" type="number" class="form-control" placeholder="N° di pezzi" aria-label="N° di pezzi" aria-describedby="addon-wrapping" value="0">
            </div>
            <div>
            <h5 class="pt-4 ">Indica il numero massimo di ordini con la consegna a domicilio</h5>
            <div class="input-group w-auto flex-nowrap py-2 ">
                <label for="max_domicilio" class="input-group-text" >N° di oridini a domicilio</label>
                <input name="max_domicilio" id="max_domicilio" type="number" class="form-control" placeholder="N° di pezzi" aria-label="N° di pezzi" aria-describedby="addon-wrapping" value="0">
            </div>
            <div>
                <h5 class="pt-4">Seleziona i giorni in cui sei attivo</h5>
                <div class="btn-group py-1 w-100 row g-2 " role="group" aria-label="Basic checkbox toggle button group">
    
                    @foreach ($days as $day)
                    
                        <input class="btn-check "  name="day_off[]" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample{{$day}}" aria-expanded="false" aria-controls="multiCollapseExample{{$day}}" id="day_off_{{ $day }}" value="{{ $day }}">
                        <label class="btn btn-dark radius col w-100" for="day_off_{{ $day }}">{{ $days_name[$day] }}
                            <div class="collapse multi-collapse" id="multiCollapseExample{{$day}}">
                                <div class="card card-body">
                                    <input
                                        type="checkbox"
                                        class="btn-check @error ('tags') is-invalid @enderror"
                                        id="days_off_{{ $day }}"
                                        name="days_off[]"
                                        value="{{ $day }}">
                                    
                        
                                    
                                    <label class="btn btn-outline-dark" for="days_off_{{ $day }}">Attiva</label>
                                    
                                    
                                    <h5 class="p-3">Seleziona le fasce orarie disponibili</h5>
                                    @foreach ($times as $time)                            
                                    
                                    <select  class="form-select col" name="times_slot_{{$day}}[]" id="">
                                        <option value="0">{{ $time['time'] }} - ND</option>
                                        <option value="1">{{ $time['time'] }} - asporto</option>
                                        <option value="2">{{ $time['time'] }} - tavoli</option>
                                        <option value="3">{{ $time['time'] }} - asporto/tavoli</option>
                                        <option value="4">{{ $time['time'] }} - domicilio</option>
                                        <option value="5">{{ $time['time'] }} - domicilio/asporto</option>
                                        <option value="6">{{ $time['time'] }} - domicilio/tavoli</option>
                                        <option value="7">{{ $time['time'] }} - tutti</option>
                                    </select>
                                    
                                    @endforeach                    
                                
                                </div>
                            </div>
                        
                    
                        </label>
    
                    @endforeach
                </div>
            </div>
            
    
            <button class="btn btn-outline-dark mt-4 w-100">Modifica</button>
        </form>
    </div>
   
@endsection

