<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <div class="d-flex">
            <a class="btn btn-dark mybtdb" href="{{ route('admin.dashboard') }}">Dashboard</a>
            {{-- <div class="notifications_container h-100 ms-2">
                <button class="btn btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-bell-fill" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                    </svg>
                </button>
                <div class="notifications_count">{{ count($notifications)}}</div>
            </div> --}}
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse flex-grow-0 me-5" id="navbarNavDropdown">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Prodotti
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.projects.index') }}">Mostra tutti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.projects.create') }}">Aggiungi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorie
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Mostra tutti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.categories.create') }}">Aggiungi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ingredienti
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.tags.index') }}">Mostra tutti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.tags.create') }}">Aggiungi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Post
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.posts.index') }}">Mostra tutti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.posts.create') }}">Aggiungi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Prenotazioni tavoli
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.reservations.index') }}">Mostra tutti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reservations.create') }}">Aggiungi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ordini d'asporto
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">Mostra tutti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.orders.create') }}">Aggiungi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Impostazioni
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.setting') }}">Servizi</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.months.index') }}">Gestione date</a></li>

                    </ul>
                </li>
            </ul>   
        </div>
    </div>
  </nav>

  @include('admin.notifications.index')
