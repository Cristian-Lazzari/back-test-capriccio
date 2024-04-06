@extends('layouts.base')

@section('contents')

    @if (session('tag_success'))
        <div class="alert alert-success">
            Ingrediente creato correttamente
        </div>
    @endif

    <form 
        method="POST" action="{{ route('admin.projects.store') }} "
        enctype="multipart/form-data" 
        class="px-2 py-5 s1b rounded c-white" 
    >
        @csrf

        <div class="mb-3 text-center w-50 m-auto">
            <label for="name" class="form-label fw-semibold">Nome Prodotto</label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name') }}"
            >
            <div class="invalid-feedback">
                @error('name') {{ $message }} @enderror
            </div>
        </div>

        <div class="mb-3 text-center w-50 m-auto">
            <label for="price" class="form-label fw-semibold">Prezzo in centesimi</label>
            <input
                type="text"
                class="form-control @error('price') is-invalid @enderror"
                id="price"
                name="price"
                value="{{ old('price') }}"
            >
            <div class="invalid-feedback">
                @error('price') {{ $message }} @enderror
            </div>
        </div>

        <div class="mb-3 text-center w-50 m-auto">
            <label for="category" class="form-label fw-semibold">Categoria</label>
            <select
                class="form-select @error('category_id') is-invalid @enderror"
                id="category"
                name="category_id"
            >
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group my-5 text-center w-50 m-auto">
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <label class="input-group-text  @error('image') is-invalid @enderror" for="image">Upload</label>
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-5 m-auto w-75 btn-group specialradio">

            <h3>Descrizione</h3>
            <div class="mytags mb-4">
                @foreach($tagDescription as $description)

                    <input
                        type="checkbox"
                        class="btn-check @error ('description') is-invalid @enderror"
                        id="description-{{ $description->id }}"
                        name="description[]"
                        value="{{ $description->id }}"
                        @if (old('description') == $description->id) checked @endif
            
                    >
                    <label class="btn btn-outline-light" for="description-{{ $description->id }}">{{ $description->name }}</label>

                    @error('description') 
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                
                @endforeach

            </div>

            <h3>Ingredienti</h3>
            <div class="mytags">
                @foreach($tags as $tag)

                    <input
                        type="checkbox"
                        class="btn-check @error ('tags') is-invalid @enderror"
                        id="tag{{ $tag->id }}"
                        name="tags[]"
                        value="{{ $tag->id }}"
                        @if (in_array($tag->id, old('tags', []))) checked @endif
            
                    >
                    <label class="btn btn-outline-light shadow-sm" for="tag{{ $tag->id }}">{{ $tag->name }}</label>

                    @error('tags') 
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                
                @endforeach

            </div>
        </div>

        <div class="text-center border border-black w-50 mx-auto mb-4 p-3 rounded shadow">
            <h4>Ingrediente mancante? Crealo ora!</h4>
            <p><span class="fw-semibold">Attenzione:</span> Gli ingredienti con prezzo uguale a 0 saranno considerati una descrizione del prodotto</p>
            <div class="mb-3 text-center">
                <label for="name_ing" class="form-label fw-semibold">Nome</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('name_ing') is-invalid @enderror"
                    id="name_ing"
                    name="name_ing"
                    value="{{ old('name_ing') }}"
                >
                <div class="invalid-feedback">
                    @error('name_ing') {{ $message }} @enderror
                </div>
            </div>
            <div class="mb-3 text-center">
                <label for="price_ing" class="form-label fw-semibold">Prezzo in centesimi</label>
                <input
                    type="text"
                    class="form-control w-75 m-auto text-center @error('price_ing') is-invalid @enderror"
                    id="price_ing"
                    name="price_ing"
                    value="{{ old('price_ing') }}"
                >
                <div class="invalid-feedback">
                    @error('price_ing') {{ $message }} @enderror
                </div>
            </div>
            <input
                type="checkbox"
                class="btn-check @error ('description') is-invalid @enderror"
                id="on-1"
                name="newi"
                value="1"
                
    
            >
            <label class="btn m-3 btn-outline-light" for="on-1">conferma</label>
            <button class="btn mb-5 w-auto m-auto btn-light d-block">Salva igrediente</button>
        </div>

        <button class="btn mb-5 w-75 m-auto btn-light d-block">Salva</button>
    </form>
@endsection