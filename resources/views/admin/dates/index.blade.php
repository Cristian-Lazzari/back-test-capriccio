@extends('layouts.base')

@section('contents')
@php
        $days_name = [' ','lunedì', 'martedi', 'mercoledì', 'giovedì', 'venerd', 'sabato', 'domenica'];
        @endphp


    
<h1 class="m-5">GESTISCI IL IL GIORNO</h1>    



        <div class="mydata">
            
            @foreach ($dates as $date)
            
            
          @php
              $status = ['','asporto','tavoli','asporto/tavoli','domicilio','domicilio/asporto','domicilio/tavoli','tutti']
          @endphp
                
                <div class="mycard">
                    <div class="left-c">
                        <div class="data">
                            <span>{{$status[$date['status']]}}</span>

                            <h2>{{$date->time}}</h2>
                            <span class="day_w">{{$days_name[$date->day_w]}}</span>
                            <span>{{$date->day}}/{{$date->month}}/{{$date->year}}</span>
                        </div>
                        <div class="res">
                            <h3>Pezzi al taglio Prenotati</h3>
                            <div class="n_res">{{$date->reserved_pz_q}}</div>    
                        </div>
                        <div class="res">
                            <h3>Pizze al piatto Prenotate</h3>
                            <div class="n_res">{{$date->reserved_pz_t}}</div>    
                        </div>
                        <div class="res">
                            <h3>Posti Prenotati</h3>
                            <div class="n_res">{{$date->reserved}}</div>
                        </div>
                        <div class="res">
                            <h3>Ordini a domicilio</h3>
                            <div class="n_res">{{$date->reserved_domicilio}}</div>
                        </div>
                    </div>
                    <div class="right-c">
                        <div class="max">
                            <h3>Max Posti</h3>
                            <form action="{{ route('admin.dates.updateMax') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$date->id}}">
                                <input type="hidden" name="v" value="1">
                                <input type="number" class="form-control m-1 w-50" name="max" value="{{$date->max_res}}">
                                <button  class="btn btn-dark">Modifica</button>
                            </form>
                        </div>
                        <div class="max">
                            <h3>Max Pizze al piatto</h3>
                            <form action="{{ route('admin.dates.updateMax') }}" method="post">
                                @csrf
                                <input type="hidden" name="v" value="2">
                                <input type="number" class="form-control m-1 w-50" name="max" value="{{$date->max_pz_t}}">
                                <input type="hidden" name="id" value="{{$date->id}}">
                                <button  class="btn btn-dark">Modifica</button>
                            </form>
                            
                        </div>
                        <div class="max">
                            <h3>Max Pezzi al taglio</h3>
                            <form action="{{ route('admin.dates.updateMax') }}" method="post">
                                @csrf
                                <input type="hidden" name="v" value="3">
                                <input type="number" class="form-control m-1 w-50" name="max" value="{{$date->max_pz_q}}">
                                <input type="hidden" name="id" value="{{$date->id}}">
                                <button  class="btn btn-dark">Modifica</button>
                            </form>
                            
                        </div>
                        <div class="max">
                            <h3>Max ordini dom.</h3>
                            <form action="{{ route('admin.dates.updateMax') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$date->id}}">
                                <input type="hidden" name="v" value="4">
                                <input type="number" class="form-control m-1 w-50" name="max" value="{{$date->max_domicilio}}">
                                <button  class="btn btn-dark">Modifica</button>
                            </form>

                        </div>
                        
                    </div>
                    
                      
                    <div class="visible-on">
                        <form action="{{route('admin.dates.updatestatus')}}" method="post">
                            @csrf
                            <button @if (!$date->visible_fq) class="off" @endif type="submit">{{ 'taglio' . '-' . ($date->visible_fq ? 'si' : 'no')}}</button>
                            <input type="hidden" name="v" value="1">
                            <input type="hidden" name="id" value="{{$date->id}}">
                        </form> 
                        <form action="{{route('admin.dates.updatestatus')}}" method="post">
                            @csrf
                            <button @if (!$date->visible_ft) class="off" @endif type="submit">{{ 'piatto' . '-' . ($date->visible_ft ? 'si' : 'no')}}</button>
                            <input type="hidden" name="v" value="2">
                            <input type="hidden" name="id" value="{{$date->id}}">
                        </form> 
                        <form action="{{route('admin.dates.updatestatus')}}" method="post">
                            @csrf
                            <button @if (!$date->visible_t) class="off" @endif type="submit">{{ 'tavoli' . '-' . ($date->visible_t ? 'si' : 'no')}}</button>
                            <input type="hidden" name="v" value="3">
                            <input type="hidden" name="id" value="{{$date->id}}">
                        </form> 
                        <form action="{{route('admin.dates.updatestatus')}}" method="post">
                            @csrf
                            <button @if (!$date->visible_d) class="off" @endif type="submit">{{ 'domiclio' . '-' . ($date->visible_d ? 'si' : 'no')}}</button>
                            <input type="hidden" name="v" value="4">
                            <input type="hidden" name="id" value="{{$date->id}}">
                        </form> 
                        
                      
                    </div>
               
{{--                         
                    <div class="visible">
                        <span class="">non visibile</span> 
                        
                        <form action="{{ route('admin.dates.updatestatus', $date->id) }}" method="post">
                            @csrf
                            <button class="btn btn-success">visibilità</button>
                        </form>
                        
                    </div> --}}
                  
                </div>
                        
                    
                    
                    
             
            @endforeach
     
        </div>

 

    
@endsection

