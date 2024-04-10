@extends('layouts.base')

@section('contents')

<form class="px-2 py-5 s3b rounded c-white" method="POST" action="{{ route('admin.posts.store') }} " enctype="multipart/form-data" >
    @csrf
    <h2>Crea un nuovo Post</h2>
    <div class="mb-5 nome_">
        <label for="title" class="form-label">Titolo del Post</label>
        <input
            type="text"
            class="form-control @error('title') is-invalid @enderror"
            id="title"
            name="title"
            value="{{ old('title') }}"
        >
        <div class="invalid-feedback">
            @error('title') {{ $message }} @enderror
        </div>
    </div>

    <div class="mb-5 link_">
        <label for="link" class="form-label">Instagram LINK</label>
        <input
            type="text"
            class="form-control @error('link') is-invalid @enderror"
            id="link"
            name="link"
            value="{{ old('link') }}"
        >
        <div class="invalid-feedback">
            @error('link') {{ $message }} @enderror
        </div>
    </div>
    <div class="mb-5">
        <label for="type" class="form-label fw-semibold">Tipologia</label>
        <select
            class="form-select @error('type_id') is-invalid @enderror"
            id="type"
            name="type"
        >
            <option value="1">Scegli un opzione</option>
            <option value="1">In viaggio con leo</option>
            <option value="2">La nostra Storia</option>
            
        </select>

        @error('type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-5 descrizione_">
        <label for="description" class="form-label">Descrizione</label>
        <textarea
            type="text"
            class="form-control @error('description') is-invalid @enderror"
            id="description"
            name="description"
            value=""
            cols="30" rows="10">{{ old('description') }}</textarea>
        <div class="invalid-feedback">
            @error('description') {{ $message }} @enderror
        </div>
    </div>

    <div class="input-group mb-5">
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <label class="input-group-text  @error('image') is-invalid @enderror" for="image">Immagine</label>
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="mb-5 ingredienti_ ">
        <h3>Hashtags</h3>
        @foreach($hashtags as $tag)
            <div class="mb-3 form-check">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="tag{{ $tag->id }}"
                    name="tags[]"
                    value="{{ $tag->id }}"
                    @if (in_array($tag->id, old('tags', []))) checked @endif
                >
                <label class="form-check-label" for="tag{{ $tag->id }}">#{{ $tag->tag }}</label>
            </div>
        @endforeach
    </div>





    <button class="btn btn-light">Salva</button>
</form>

@endsection