@extends('layouts.base')

@section('contents')
<a href="{{ route('admin.orders.index') }}" class="btn btn-dark my-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/></svg>
</a>

    {{-- <img src="{{ Vite::asset('resources/img/picsum30.jpg') }}" alt=""> --}}
    <div class="myres-c">

        <?php

        $data_ora = DateTime::createFromFormat('d/m/Y H:i', $order->date_slot);

        $ora_formatata = $data_ora->format('H:i');
        $data_formatata = $data_ora->format('d/m/Y');
        $giorno_settimana = $data_ora->format('l');
        ?>



        @if ($order->status == 0)
                            
        <div class="myres el">
        @elseif ($order->status == 1)
        <div class="myres co">

        @elseif ($order->status == 2)

        <div class="myres an">
        @endif

            <div class="mail-tel">
                <div class="mail">{{$order->email}}</div>
                <div class="tel">{{$order->phone}}</div>
            </div>
            <div class="body">
                <section class="myres-left">
                    <div class="name">{{$order->name}}</div>
                    <div  class="myres-left-c">
                        <div class="time">{{$ora_formatata}}</div>

                        <div class="day_w">{{$giorno_settimana}}</div>
                        <div class="date">{{$data_formatata}}</div>
                    </div>
                    <div class="c_a">inviato alle: {{$order->created_at}}</div>
                </section>
                <section class="myres-center">
                    <h5>Prodotti</h5>

                    @foreach ($orderProject as $i)
                    
                    @if ($order->id == $i->order_id)
                    @foreach ($order->projects as $o)
                    
                        @if ($o->id == $i->project_id)
                        <?php $name= $o->name ?>
                        @endif
                        
                    @endforeach
                    <?php
                        $arrA= json_decode($i->addicted); 
                        $arrD= json_decode($i->deselected); 
                    ?>
                    <div class="product">
                        <div class="counter">* {{$i->quantity_item}}</div>              
                        <div class="name">{{$name}}</div>
                        <div class="variations">
                            <div class="add">
                          
                                @foreach ($arrA as $a)
                                <span>+ {{$a}}</span>
                                @endforeach
                               
                            </div>
                            <div class="removed">
                                
                             
                                @foreach ($arrD as $a)
                                <span>- {{$a}}</span>
                                @endforeach       
                                
                            </div>
                        </div>
                        
                    </div>
                    @endif
                    @endforeach
                    <div class="t_price">€{{$order->total_price / 100}}</div>
                    <div class="t_price">{{$order->total_pz_q}} pezzi taglio</div>
                    <div class="t_price">{{$order->total_pz_t}} pizze piatte</div>
                    
                </section>
                <section class="myres-right">

                    <form class="d-inline w-100 " action="{{ route('admin.orders.confirmOrder', $order->id) }}" method="post">
                        @csrf
                        <button value="1" class="w-100 btn btn-warning">
                            Conferma
                        </button>
                    </form>
                    <form class="d-inline w-100" action="{{ route('admin.orders.rejectOrder', $order->id) }}" method="post">
                        @csrf
                        <button value="2" class="w-100 btn btn-danger">
                            Annulla
                        </button>
                    </form>
                    @if ($order->indirizzo !== '0')
                    <h3>
                        Consegnare a domicilio
                        <p>{{$order->comune}}, {{$order->indirizzo}}, {{$order->civico}}</p>
                    </h3>
                    @else
                    <h3>
                        Ritiro d'asporto
                    </h3>
                    @endif
                </section>
            </div>
            <div class="visible">
                @if ($order->status == 0)
                    
                <span>in elaborazione</span>
                @elseif ($order->status == 1)
                <span>confermato</span>
                
                @elseif ($order->status == 2)
                
                <span>annullato</span>
                @endif

            </div>
        </div>

        
    </div>

@endsection