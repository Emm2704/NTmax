<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .list-group-item a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }

        .list-group-item {
            font-size: 20px;
        }

        .icon {
            height: 30px;
            width: auto;
            margin-right: 12px;
        }

        .progress-bar {
            background-color: rgba(39, 186, 195, 255); /* Cambia este color al que desees */
        }

        #progressBarContainer {
            display: none; /* Asegúrate de que el contenedor esté inicialmente oculto */
        }
    </style>
    <div class="container">
        <div id="progressBarContainer" class="my-3">
            <div class="progress">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p>Realizando respaldo, por favor espere...</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 style="color: #333; font-size: 30px; text-align: center;">¡Hola {{ Auth::user()->name }}, este es el menú!</h1>
                <ul class="list-group list-group-flush">
                    @auth
                    @if(auth()->user()->role === 'admin')
                    <li class="list-group-item">
                        <a href="{{ route('usuarios.index') }}">
                            <img src="{{ asset('src/users.png') }}" alt="Icono 1" class="icon"> Supervisión
                        </a>                        
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('roles.index') }}">
                            <img src="{{ asset('src/rol.png') }}" alt="Icono 1" class="icon"> Roles
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" id="backupLink">
                            <img src="{{ asset('src/respaldo.png') }}" alt="Icono 1" class="icon"> Realizar BackUp
                        </a>
                    </li>
                    @endif
                    @endauth

                    {{-- Todos los usuarios --}}
                    <li class="list-group-item">
                        <a href="{{ route('courses.index') }}">
                            <img src="{{ asset('src/curso.png') }}" alt="Icono 1" class="icon"> Cursos
                        </a>                        
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('saved.menu') }}">
                            <img src="{{ asset('src/marcador.png') }}" alt="Icono 1" class="icon"> Guardados
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" id="backupLink">
                            <img src="{{ asset('src/calendario.png') }}" alt="Icono 1" class="icon"> Eventos
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('books.index') }}">
                            <img src="{{ asset('src/libro.png') }}" alt="Icono 1" class="icon"> Libros
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#actividad">
                            <img src="{{ asset('src/video.png') }}" alt="Icono 1" class="icon"> Videos
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('audios.index') }}">
                            <img src="{{ asset('src/auriculares.png') }}" alt="Icono 1" class="icon"> Audios
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#actividad">
                            <img src="{{ asset('src/documento.png') }}" alt="Icono 1" class="icon"> Documentos
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('helps.index') }}">
                            <img src="{{ asset('src/help.png') }}" alt="Icono 1" class="icon"> Ayuda
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('support_tickets.index') }}">
                            <img src="{{ asset('src/soporte.png') }}" alt="Icono 1" class="icon"> Soporte
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('backupLink').addEventListener('click', function(event) {
            event.preventDefault();
            
            if (!confirm('¿Estás seguro de que deseas realizar el respaldo?')) {
                return;
            }
            
            var progressBarContainer = document.getElementById('progressBarContainer');
            var progressBar = document.getElementById('progressBar');

            progressBarContainer.style.display = 'block';
            progressBar.style.width = '0';

            setTimeout(function() {
                progressBar.style.width = '50%';
            }, 1000);

            setTimeout(function() {
                progressBar.style.width = '100%';
            }, 3000);

            setTimeout(function() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'backup.php', true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var link = document.createElement('a');
                        link.href = 'backup.php';
                        link.download = 'backup_' + new Date().toISOString().slice(0, 19).replace(/:/g, "-") + '.sql';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        progressBarContainer.style.display = 'none';
                    } else {
                        alert('Error al hacer la copia de seguridad');
                        progressBarContainer.style.display = 'none';
                    }
                };

                xhr.onerror = function () {
                    alert('Error de red');
                    progressBarContainer.style.display = 'none';
                };

                xhr.send();
            }, 4000);
        });
    </script>
</x-app-layout>
