@extends('layouts.base')

@section('contents')

<div class="d-flex flex-column gap-3 my-3 align-items-center card p-5 ">
    <h1 style="white-space: nowrap" class="">IMPOSTAZIONI DEL TUO SITO</h1>
    <h4>Disponibilità servizi</h4>

    <form class="setting" method="POST" action="{{ route('admin.settings.allupdate')}}">
        @csrf
        @method('PUT')

        @foreach ($settings as $setting)
            <div class="set">
                <span>{{$setting->name}}</span>
                @if($setting->name == 'Periodo di Ferie') 
                    <div class="scelta ferie">
                        <div>
                            <input type="text" id="from" name="from" value="{{ $setting->from }}" placeholder=" ...da ??/??/20??">
                        </div>
                        <div>

                            <input type="text" id="to" name="to" value="{{ $setting->to }}" placeholder=" ...a ??/??/20??">
                        </div>
                    </div>

                @endif
                <div class="scelta">
                    <div class="toggle-border">
                        <input id="status{{$setting->id}}" type="checkbox" name="status{{$setting->id}}"
                        @if($setting->status == true)
                        checked
                        @endif
                        >
                        <label for="status{{$setting->id}}">
                            <div class="handle"></div>
                        </label>
                    </div>
                </div>

            </div>
            @endforeach
            
        <button class="btn btn-danger">Aggiorna Modifiche</button>
    </form>
    <hr class="p-3">
    
    
    <a class="btn c-white w-75 btn-warning" href="{{ route('admin.months.index') }}">Gestisci Date</a>
    <a class="btn c-white w-75 btn-warning" href="{{ route('admin.addresses.index') }}">Gestisci Area di consegna</a>

  

</div>




@endsection
