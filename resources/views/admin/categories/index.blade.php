@extends('layouts.base')

@section('contents')
    {{-- <img src="{{ Vite::asset('resources/img/picsum30.jpg') }}" alt=""> --}}


        <h1>CATEGORIE</h1>
        <table class="table table-striped">
            <thead>
                <tr>

                    <th>NOME</th>
                    <th>Tipologia</th>
                    <th>SLOT</th>

                    <th>
                        <a class="btn btn-success" href="{{ route('admin.categories.create') }}">Nuovo</a>
                    </th>
                </tr>
            </thead>
            <tbody class="body-cat">
                @foreach ($categories as $category)
                    <tr>
 
                        <td class="">{{$category->name}}</td>
                        <td>{{$category->type}}</td>
                        <td>{{$category->slot}}</td>

                        <td >
                            <div class="btn-cont">
                                <form class="delete-cat-un" action="{{ route('admin.categories.destroy', ['category' =>$category])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" >Elimina</button>
                                </form>
                                <a class="btn my-btn btn-warning" href="{{ route('admin.categories.edit', ['category' =>$category]) }}">Modifica</a>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


@endsection
