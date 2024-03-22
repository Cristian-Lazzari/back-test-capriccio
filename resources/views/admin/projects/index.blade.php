@extends('layouts.base')

@section('contents')
    {{-- <img src="{{ Vite::asset('resources/img/picsum30.jpg') }}" alt=""> --}}

    @if (session('delete_success'))
        @php
            $project = session('delete_success')
        @endphp
        <div class="alert alert-danger">
            "{{ $project->name }}" è stato correttamente spostato nel cestino!
    
        </div>
    @endif

    @if (session('restore_success'))
        @php
            $project = session('restore_success')
        @endphp
        <div class="alert alert-success">
            "{{ $project->name }}" è stato correttamente ripristinato!
            
        </div>
    @endif


    
    <h1 class="m-3">Scegli la categoria</h1>
        <div class="row ">

            <a class="btn my-btn btn-success my-1 w-25 m-auto" href="{{ route('admin.projects.create') }}">Nuovo</a>
            <a class="btn my-btn btn-danger my-1 w-25 m-auto" href="{{ route('admin.projects.trashed') }}">Cestino</a>
        </div>
        <div class="mycontainerc ">

            <a href="{{ route('admin.projects.showCategory', ['category_id' => 0]) }}" class="c-white s1b"> TUTTI </a>
            @foreach ($categories as $item)
                <a href="{{ route('admin.projects.showCategory', ['category_id' => $item->id]) }}" class="s2b c-white">
                    @if ($item->id == 1)
                        (non categorizzati) - {{$item->name}}
                    @else
                    {{$item->name}}</a>              
                    @endif
            @endforeach        
          
        </div>

@endsection

