@extends('layouts.base')

@section('contents')

<form class="px-2 py-5 s3a rounded c-white" method="POST" action="{{ route('admin.hashtags.store') }} " enctype="multipart/form-data">
    @csrf

    <div class="mb-3 nome_">
        <h2>

            Crea un nuovo hashtag
        </h2>
        <label for="tag" class="form-label">Nome hashtag</label>
        <input
            type="text"
            class="form-control @error('tag') is-invalid @enderror"
            id="tag"
            name="tag"
            value="{{ old('tag') }}"
        >
        <div class="invalid-feedback">
            @error('tag') {{ $message }} @enderror
        </div>
    </div>





    <button class="btn btn-light">Salva</button>
</form>

@endsection