@extends('layouts.base')

@section('contents')

<form class="cont_a" method="POST" action="{{ route('admin.addresses.store') }}">
    @csrf

    <div class="mb-3">
        <label for="comune" class="form-label">Comune</label>
        <input
            type="text"
            class="form-control @error('comune') is-invalid @enderror"
            id="comune"
            name="comune"
            value="{{ old('comune') }}"
        >
        <div class="invalid-feedback">
            @error('name') {{ $message }} @enderror
        </div>
    </div>
    <div class="mb-3">
        <label for="provincia" class="form-label">Provincia</label>
        <input
            type="text"
            class="form-control @error('provincia') is-invalid @enderror"
            id="provincia"
            name="provincia"
            value="{{ old('provincia') }}"
        >
        <div class="invalid-feedback">
            @error('provincia') {{ $message }} @enderror
        </div>
    </div>

    

    <button class="btn btn-primary">Salva</button>
</form>

@endsection