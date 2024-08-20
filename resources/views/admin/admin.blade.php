<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <title>@yield('title') | Administration</title>
    <style>
      @layer reset{
        button {
          all: unset;
        }
      }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Agence</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @php
        $route = request()->route()->getName();
    @endphp
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a @class(["nav-link", "active" => str_contains($route, 'property.')]) aria-current="page" href="{{ route('admin.property.index') }}">Gérer les bien</a>
        </li>
        <li class="nav-item">
          <a @class(["nav-link", "active" => str_contains($route, 'option.')]) href="{{ route('admin.option.index') }}">Gérer les options</a>
        </li>
      </ul>
      <div class="ms-auto">
        @auth
        <ul class="navbar-nav">
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              @method('delete')
              <button class="nav-link">Se déconnecter</button>
            </form>
          </li>
        </ul>
        @endauth
      </div>
    </div>
  </div>
</nav>

    <div class="container mt-5">
        @include('shared.flash')
        @yield('content')
    </div>

  <script>
    new TomSelect('select[multiple]', {plugins: {remove_button: {title: 'Supprimer'}}})
  </script>

</body>
</html>