@extends('base')

@section('title', $property->title)

@section('content')
<style>
    .carousel-indicators img{
        width: 70px;
        display: block;
    }
    .carousel-indicators button{
        width: max-content!important;
    }
</style>
    <div class="container mt-4">
        
        <hr>

        <div class="mt-4">
            <div class="row">
                <div class="col">
                    <div class="carousel slide" id="carouselDemo" data-bs-wrap="true" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($images as $key => $image )
                                <button type="button" data-bs-target="#carouselDemo" data-bs-slide-to="{{$key}}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key }}" >
                                    <img src="{{ asset($image->image) }}" alt=""/>
                                </button>
                        @endforeach
                        
                    </div>
                        <div class="carousel-inner">
                        @foreach ($images as $key => $image )
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" style="object-fit:cover;" src="{{ asset($image->image) }}" alt="">
                                <div class="carousel-caption">
                                    <h5>{{ $property->title }}</h5>
                                </div>
                            </div>
                        @endforeach
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselDemo" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselDemo" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            <div class="carousel-indicators">
                                @for ($i = 0; $i >= $images->count(); $i++)
                                    <button type="button" class="border"></button>            
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <h1><strong>{{ $property->title }}</strong></h1>
                    <h2>{{ $property->rooms }} piéces - {{ $property->surface }}m²</h2>

                    <div class="text-primary fw-bold" style="font-size: 4rem;">
                        {{ number_format($property->price, thousands_separator: ' ') }}£
                    </div>

                    <h4>Intéressé par ce bien ?</h4>
                    @include('shared.flash')

                    <form action="{{ route('property.contact', $property) }}" method="post" class="vstack gap-3">
                        @csrf
                        <div class="row">
                            <x-input class="col" name="firstname" label="Prénom" value="" />
                            @include('shared.input', ['class' => 'col', 'name' => 'firstname', 'label' => 'Prénom'])
                            @include('shared.input', ['class' => 'col', 'name' => 'lastname', 'label' => 'Nom'])
                        </div>

                        <div class="row">
                            @include('shared.input', ['class' => 'col', 'name' => 'phone', 'label' => 'Téléphone'])
                            @include('shared.input', ['type' => 'email', 'class' => 'col', 'name' => 'email', 'label' => 'Email'])
                        </div>

                        @include('shared.input', ['type' => 'textarea', 'class' => 'col', 'name' => 'message', 'label' => 'Votre message'])
                        <div>
                            <button class="btn btn-primary">
                                Nous contacter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <p>{!! nl2br($property->description) !!}</p>
        </div>
        <div class="row">
            <div class="col-8">
                <h2>Caractéristique</h2>
                <table class="table table-striped">
                    <tr>
                        <td>Surface habitable</td>
                        <td>{{ $property->surface }}m²</td>
                    </tr>
                    <tr>
                        <td>Piéces</td>
                        <td>{{ $property->rooms }}</td>
                    </tr>
                    <tr>
                        <td>Chambres</td>
                        <td>{{ $property->bedrooms }}</td>
                    </tr>
                    <tr>
                        <td>Etage</td>
                        <td>{{ $property->floor ?: 'Rez de chaussé' }}</td>
                    </tr>
                    <tr>
                        <td>Localisation</td>
                        <td>
                            {{ $property->address }}<br/>
                            {{ $property->city }} {{ $property->postal_code }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-4">
                <h2>Spécificités</h2>
                <ul class="list-group">
                    @foreach ($property->options as $option)
                        <li class="list-group-item">{{ $option->name }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
    
@endsection