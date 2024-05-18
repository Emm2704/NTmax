<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Encabezado de la página -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>
    
    <div class="container mt-5">

        @if (Auth::user()->role == 'admin')
            @if (Auth::user()->name != '')
                <div style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h1 style="color: #333; font-size: 24px; text-align: center;">¡Hola {{ Auth::user()->name }}, estos son los usuarios!</h1>
                </div>
            @endif

            <div class="container mt-5">
                <!-- Agregar campo de entrada para la búsqueda -->
                <div class="mb-3">
                    <label for="buscar-nombre" class="form-label">Buscar por nombre:</label>
                    <input type="text" id="buscar-nombre" class="form-control" placeholder="Escribe el nombre del usuario">
                </div>
            <!-- Controles de filtro -->
            <div class="mb-3">
                <label for="filtro-estado" class="form-label">Filtrar por estado:</label>
                <select id="filtro-estado" class="form-select">
                    <option value="todos">Todos</option>
                    <option value="activo">Activos</option>
                    <option value="inactivo">Inactivos</option>
                </select>
            </div>

            <!-- Tabla de proyectos -->
            <div class="table-responsive mt-4">
                <table id="tabla-proyectos" class="table table-striped">
                    <!-- Encabezados de la tabla -->
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="
                                @if ($usuario->estado == 'Activo') activo 
                                @elseif ($usuario->estado == 'Inactivo') inactivo 
                                @endif">
                                <td>{{ $usuario->name}}</td>
                                <td>{{ $usuario->email}}</td>
                                <td>{{ $usuario->estado }}</td>
                                <td>{{ $usuario->role }}</td>
                                <td>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="{{ route('usuarios.edit', ['usuario'=>$usuario->id]) }}" class="btn btn-secondary">Editar</a>
                                        @if ($usuario->estado == 'Activo')
                                            <form action="{{ route('usuarios.inactivar', ['usuario' => $usuario->id]) }}" method='POST' style="display:inline-block">
                                                @method('put')
                                                @csrf
                                                <button class="btn btn-warning" type="submit" onclick="return confirm('¿Estás seguro de inactivar este usuario?')">Inactivar</button>
                                            </form>
                                        @else
                                            <form action="{{ route('usuarios.activar', ['usuario' => $usuario->id]) }}" method='POST' style="display:inline-block">
                                                @method('put')
                                                @csrf
                                                <button class="btn btn-success" type="submit" onclick="return confirm('¿Estás seguro de activar este usuario?')">Activar</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
    <div class="text-center">
        <p class="mb-3">No tienes permiso para acceder a esta página.</p>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('src/cat.jpg') }}" class="img-fluid" style="max-width: 37%;" alt="Cat Image">
        </div>
    </div>
@endif

        
    </div>


    <!-- Scripts JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filtro-estado').change(function() {
                var estado = $(this).val();
                if (estado === 'todos') {
                    $('#tabla-proyectos tbody tr').show();
                } else {
                    $('#tabla-proyectos tbody tr').hide();
                    $('#tabla-proyectos tbody tr.' + estado).show();
                }
            });
        });

    </script>




    <!-- Estilos CSS -->
    <style>

        .activo {
            background-color: #ccffcc; /* Verde claro */
        }
        .inactivo {
            background-color: #ffcccc; /* Rojo claro */
        }

    </style>
    
     <!-- Scripts JavaScript -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script>
         $(document).ready(function() {
             $('#buscar-nombre').on('input', function() {
                 var textoBusqueda = $(this).val().toLowerCase();
                 $('#tabla-proyectos tbody tr').each(function() {
                     var nombreUsuario = $(this).find('td:nth-child(2)').text().toLowerCase();
                     if (nombreUsuario.includes(textoBusqueda)) {
                         $(this).show();
                     } else {
                         $(this).hide();
                     }
                 });
             });
         });
     </script>
 </x-app-layout>