@extends('layouts.base')

@section('contents')

    {{-- <img src="{{ Vite::asset('resources/img/picsum30.jpg') }}" alt=""> --}}
    <?php 
        $month_name = ['gennaio','febbraio','marzo','aprile', 'maggio','giugno','luglio','agosto','settembre','ottobre','novrembre','dicembre'];
        $days_week  = ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"];
        ?>
        <a href="{{ route('admin.months.index') }}" class="btn btn-dark my-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/></svg>
        </a>

    <h1 class="m-3">SCEGLI UN GIORNO</h1>    

    
    <div class="date-top">
        <h3 class="m-2 upper">{{$month_name[$days[1]->m -1]}}</h3>
        @if ($month_id !== 1) 
            @if ($days[1]->m !== 1)
                
                <a href="{{ route('admin.days.index', ['month' =>$days[1]->m - 1, 'year' =>$days[1]->y, 'month_id' => $month_id - 1]) }}" class="mybtndate s2a c-white ">
                   < {{$month_name[$days[1]->m - 2]}}
                </a>
            @else
                <a href="{{ route('admin.days.index', ['month' =>12, 'year' =>$days[1]->y - 1, 'month_id' => $month_id - 1]) }}" class="mybtndate s2a c-white ">
                  < {{$month_name[$days[1]->m - 2]}}
                </a>
            @endif
            
            
        @endif
        @if ($month_id !== 12) 
            @if ($days[1]->m !== 12)   
                <a href="{{ route('admin.days.index', ['month' =>$days[1]->m + 1, 'year' =>$days[1]->y, 'month_id' => $month_id + 1]) }}" class="mybtndate s2a c-white ">
                    {{$month_name[$days[1]->m]}} >
                </a>
            @else
                <a href="{{ route('admin.days.index', ['month' => 1, 'year' =>$days[1]->y + 1, 'month_id' => $month_id + 1]) }}" class="mybtndate s2a c-white ">
                    {{$month_name[$days[1]->m]}} >
                </a>
            @endif

        @endif

    </div>
    
    <div class="container pt-3">
        <div class="days_w">
            @foreach ($days_week as $day_week)
                <div class="day_w">
                    {{ $day_week }}
                </div>
            @endforeach
        </div>
        <div class="day_grid">
            @foreach ($days as $day)
                <a 
                    class="day"
                    style="grid-column-start: {{ $day->day_w }} "
                    href="{{ route('admin.days.show', ['day' => $day->id])  }}"
                >
                    {{$day->day}}
                </a>
            @endforeach
        </div>
    </div>


    {{-- <table class="table table-striped">

        <tbody>
            @foreach ($days as $day)
                <tr>
                    <th class="expire-mobile">{{$day->id}}</th>
                    <td>
                        <a href="{{ route('admin.days.show', ['day' => $day->id])  }}" style="color:white" class="ts bs a-notlink badge bg-primary rounded-pill"  > {{$day->day}} / {{$day->m}} / {{$day->y}}</a >
                        
                    </td>
                
                    
                </tr>
            @endforeach
        </tbody>
    </table> --}}


@endsection

