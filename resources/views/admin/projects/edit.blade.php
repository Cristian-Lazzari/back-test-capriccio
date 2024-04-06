@extends('layouts.base')

@section('contents')


<form class="cont_a" method="POST" action="{{ route('admin.projects.update', ['project' => $project]) }}" enctype="multipart/form-data" >
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Titolo</label>
        <input
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            name="name"
            value="{{ old('name',$project->name) }}"
        >
        <div class="invalid-feedback">
            @error('name') {{ $message }} @enderror
        </div>
    </div>


    <div class="input-group mb-3">
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <label class="input-group-text  @error('image') is-invalid @enderror" for="image">Upload</label>
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Prezzo in centesimi</label>
        <input
            type="text"
            class="form-control @error('price') is-invalid @enderror"
            id="price"
            name="price"
            value="{{ old('price',$project->price) }}"
        >
        <div class="invalid-feedback">
            @error('price') {{ $message }} @enderror
        </div>
    </div>



    <div class="mb-3">
        <label for="category" class="form-label">Categoria</label>
        <select
            class="form-select @error('category_id') is-invalid @enderror"
            id="category"
            name="category_id"
        >
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @if (old('category_id', $project->category->id) == $category->id) selected @endif
                >{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
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
                    @if (in_array($description->id, old('tags', $project->tags->pluck('id')->all()))) checked @endif
        
                >
                <label class="btn btn-outline-dark" for="description-{{ $description->id }}">{{ $description->name }}</label>

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
                    @if (in_array($tag->id, old('tags', $project->tags->pluck('id')->all()))) checked @endif
        
                >
                <label class="btn btn-outline-dark shadow-sm" for="tag{{ $tag->id }}">{{ $tag->name }}</label>

                @error('tags') 
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            
            @endforeach

        </div>
    </div>





    <button class="btn btn-primary">Salva</button>
</form>

@endsection