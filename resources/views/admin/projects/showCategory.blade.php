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

    <a href="{{ route('admin.projects.index') }}" class="btn btn-dark my-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/></svg>
    </a>
    
    
    <h1 class="m-3">Gestione prodotti -
        @if ($category_id == 0)
            TUTTI
        @else
            {{$category->name}}
        @endif
        </h1>
    <div class="d-md-flex align-items-center justify-content-between gap-4 py-3">


        <div>
                 {{-- FILTRA  --}}
        <a class="btn btn-primary my-1 flex-grow-1" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
            </svg>  FILTRA
        </a>

        {{-- RIMUOVI FILTRI  --}}
        <a class="btn btn-success my-1 flex-grow-1" href="{{ route('admin.projects.showCategory', $category_id)}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
            </svg> RIMUOVI FILTRI
        </a>   
        </div>
        <div>
            <a class="btn my-btn btn-success m-1 w-auto" href="{{ route('admin.projects.create') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
              </svg></a>
            <a class="btn my-btn btn-danger m-1 w-auto" href="{{ route('admin.projects.trashed') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
              </svg></a>
        </div>

       
    </div>

    {{-- INPUT FILTRI  --}}
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form action="{{ route('admin.projects.filter')}}" class="filter mb-2" method="GET">

                {{-- ID CATEGORIA --}}
                <input hidden type="number" name="category_id" value="{{ $category_id }}">

                {{-- NOME --}}
                <div>
                    <label for="name" class="form-label fw-semibold">Nome Prodotto</label>
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

                {{-- VISIBILITà  --}}
                <div>
                    <label for="visible" class="form-label fw-semibold">Visibilità</label>
                    <select
                        class="form-select w-auto"
                        id="visible"
                        name="visible"
                    >
                        <option 
                            @if (isset($visible) && $visible == '0')
                                selected
                            @endif
                            value="0"
                        >Tutti</option>
                        <option 
                            @if (isset($visible) && $visible == '1')
                                selected
                            @endif
                            value="1"
                        >Visibili</option>
                        <option 
                            @if (isset($visible) && $visible == '2')
                                selected
                            @endif
                            value="2"
                        >Non visibili</option>
                    </select>
                </div>

                <button class="btn btn-primary w-100" type="submit">APPLICA FILTRI</button>
            </form>
        </div>
    </div>

    {{-- CONTAINER PRODOTTI  --}}
    <div class="d-flex flex-wrap justify-content-center gap-4 py-4">

        @foreach ($projects as $project)

            {{-- CARD PRODOTTO  --}}
            <div 
                class="product border rounded p-4 shadow <?= $project->visible ? 'opacity-50 bg-secondary-subtle' : '' ?>" 
                style="flex: 1 1 300px"
            >
                <div class="fs-4 fw-bold">{{ $project->name }}</div>
                <div class="fs-2 fw-bold">€{{ $project->price / 100 }}</div>

                <div class="fs-6 text-secondary">{{ $project->category->name }}</div>
                @if ($project->image)                
                <img class="my-image" src="{{ asset('public/storage/' . $project->image) }}" alt="img di {{ $project->name }}">
                @else
                <img class="my-image" src="https://db.dashboardristorante.it/public/images/or.png" alt="{{ $project->name }}">
                @endif
                <div class="fs-6 text-primary fw-bold mb-2 pointer" data-bs-toggle="modal" data-bs-target="#modalIngrendient-{{ $project->id }}">Dettagli</div>

                <div class="actions d-flex flex-wrap gap-2">
                    {{-- MODIFICA  --}}
                    <a class="btn btn-sm btn-warning" href="{{ route('admin.projects.edit', $project->id) }}">
                        <svg style="vertical-align: sub" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                        Modifica
                    </a>
                    {{-- ELIMINA  --}}
                    <form action="{{ route('admin.projects.destroy', ['project' =>$project])}}" method="post">
                        @method('delete')
                        @csrf
                        <button class="btn btn-sm btn-danger">
                            <svg style="vertical-align: sub" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                            <span class="align-items-end">Elimina</span>
                        </button>
                    </form>
                    {{-- MOSTRA/NASCONDI  --}}
                    <form action="{{ route('admin.projects.updatestatus', $project->id)}}" method="post">
                        @csrf
                        <button 
                            class="btn btn-sm <?= !$project->visible ? 'btn-success' : 'btn-dark' ?>"
                            title="<?= !$project->visible ? 'Nascondi' : 'Mostra' ?>"
                        >
                            @if (!$project->visible)
                                <svg style="vertical-align: sub" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                </svg>
                            @else
                                <svg style="vertical-align: sub" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>  
                            @endif
                        </button>
                    </form>
                </div>
            </div>

            <!-- MODALE DETTAGLI -->
            <div class="modal" id="modalIngrendient-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Dettagli</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       
                        <p>
                            <span class="fw-semibold">Ingredienti descrittivi: </span>
                            @foreach ($project->tags as $tag)
                                @if ($tag->price == 0)
                                    <span>{{ $tag->name }}</span>
                                    {{ !$loop->last ? ', ' : '.' }}
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <span class="fw-semibold">Ingredienti: </span>
                            @foreach ($project->tags as $tag)
                                @if ($tag->price)
                                    <span>{{ $tag->name }}</span>
                                @endif
                                {{ !$loop->last ? ', ' : '.' }}
                            @endforeach
                        </p>
                    </div>
                </div>
                </div>
            </div>        
        @endforeach
    </div>


    {{-- {{ $projects->links() }} --}}
@endsection

