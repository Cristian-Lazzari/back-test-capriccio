@extends('layouts.base')

@section('contents')

<form class="px-2 py-5 s2b rounded c-white" method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <h2>Crea una nuova Categoria</h2>
    <div class="mb-3">
        <label for="name" class="form-label">Titolo</label>
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
    <div class="mb-3">
        <label for="type" class="form-label">Tipologia (pezzi al taglio (t), pizza al piatto (q) o altro (0))</label>
        <input
            type="text"
            class="form-control @error('type') is-invalid @enderror"
            id="type"
            name="type"
            value="{{ old('type') }}"
        >
        <div class="invalid-feedback">
            @error('type') {{ $message }} @enderror
        </div>
    </div>
    <div class="mb-3">
        <label for="slot" class="form-label">Slot</label>
        <input
            type="number"
            class="form-control @error('slot') is-invalid @enderror"
            id="slot"
            name="slot"
            value="{{ old('slot') }}"
        >
        <div class="invalid-feedback">
            @error('slot') {{ $message }} @enderror
        </div>
    </div>

    

    <button class="btn btn-light">Salva</button>
</form>

@endsection