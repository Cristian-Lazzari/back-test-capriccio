@extends('layouts.base')

@section('contents')

<form class="px-2 py-5 s2c rounded c-white" method="POST" action="{{ route('admin.tags.store') }}">
    @csrf
    <h2>

        Crea un nuovo ingrediente
    </h2>
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
    <p><span class="fw-semibold">Attenzione:</span> Gli ingredienti con prezzo uguale a 0 saranno considerati una descrizione del prodotto</p>
    <div class="mb-3">
        <label for="price" class="form-label">Prezzo in centesimi</label>
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



    <button class="btn btn-light">Salva</button>
</form>

@endsection