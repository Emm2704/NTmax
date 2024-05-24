<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .list-group-item a {
            text-decoration: none;
            color: inherit;
        }
        
        .list-group-item {
            font-size: 20px;
        }
        
        .icon {
            height: 30px;
            width: auto;
            margin-right: 12px;
        }
    </style>
    @if (Auth::user()->role == 'admin')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 style="color: #333; font-size: 30px; text-align: center;">¡Hola {{ Auth::user()->name }}, este es el menú!</h1>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{ route('usuarios.index') }}">
                            <img src="{{ asset('src/users.png') }}" alt="Icono 1" class="icon"> Supervisión
                        </a>                        
                    </li>
                    <li class="list-group-item">
                        <a href="#roles">
                            <img src="{{ asset('src/rol.png') }}" alt="Icono 1" class="icon"> Roles
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="backup.php">
                            <img src="{{ asset('src/respaldo.png') }}" alt="Icono 1" class="icon"> Realizar BackUp
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#seguimiento">
                            <img src="{{ asset('src/ver.png') }}" alt="Icono 1" class="icon"> Seguimiento
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#actividad">
                            <img src="{{ asset('src/crecimiento.png') }}" alt="Icono 1" class="icon"> Actividad de usuarios
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <p class="mb-3">No tienes permiso para acceder a esta página.</p>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('src/cat.jpg') }}" class="img-fluid" style="max-width: 37%;" alt="Cat Image">
        </div>
    </div>
@endif
</x-app-layout>
