@extends('layouts.base')

@section('contents')
    {{-- <img src="{{ Vite::asset('resources/img/picsum30.jpg') }}" alt=""> --}}


        <h1>Comuni di consegna per il servizio a domicilio</h1>
        <table class="table table-striped">
            <thead>
                <tr>

                    <th>COMUNE</th>
                    <th>PROVINCIA</th>

                    <th>
                        <a class="btn btn-success" href="{{ route('admin.addresses.create') }}">Nuovo</a>
                    </th>
                </tr>
            </thead>
            <tbody class="body-cat">
                @foreach ($addresses as $address)
                    <tr>
 
                        <td class="">{{$address->comune}}</td>
                        <td> - {{$address->provincia}} </td>

                        <td >
                            <div class="btn-cont">
                                <form class="" action="{{ route('admin.addresses.destroy', ['address' =>$address])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" >Elimina</button>
                                </form>
                                <a class="btn my-btn btn-warning" href="{{ route('admin.addresses.edit', ['address' =>$address]) }}">Modifica</a>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


@endsection
