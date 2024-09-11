@extends('layouts.base')

@section('content')
    @php
        // $type = 'info';
        // $type = 'danger';
        // $type = 'success';
        $type = 'warning';
    @endphp

    <x-alert type="{{ $type }}">
        Des informations: <i>(Dont le type de l'alerte est: "<b>{{ $type }}</b>")</i>
    </x-alert>

    <div class="bg-light p-1 mb-5 text-center">
        <div class="container">
            <h1 class="font-bold text-xl m-0">Agence lorem ipsum</h1>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book.</p>
        </div>
    </div>

    <div class="container">
        <h2>Nos derniers biens</h2>
        <div class="row">
            @foreach ($properties as $property)
                <div class="col">
                    @include('property.card')
                </div>
            @endforeach
        </div>
    </div>
@endsection
