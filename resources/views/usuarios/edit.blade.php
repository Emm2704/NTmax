<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
        <!-- Bootstrap Linki -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
        <title>Editar Usuario</title>
    </head>
    <body>
        @if (Auth::user()->role == 'admin')
      <div class="p-5 mb-4 text-bg-dark container-fluid">
        <div class="container">
          <h1 class="display-5 fw-bold">Editar Usuario</h1>
        </div>
      </div>
        <div class="container">
          <div class="card">
              <div class="card-header">
                  <span>Datos del Usuario</span>
              </div>
              <div class="card-body">
                <form method="POST" class="form-horizontal" action="{{ route( 'usuarios.update', ['usuario' => $usuario ->id]) }}">
                    @method('put')
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Nombre:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre de proyecto:"
                            value=" {{ $usuario->name}} ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ejemplo: 75000"
                            value=" {{ $usuario->email}} ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="role">Seleccione el Rol:</label>
                        <div class="col-sm-10">
                          <select class="form-select" id="role" name="role" required>
                            @if ($usuario ->role == $usuario ->role)
                            <option selected value="{{ $usuario ->role }}">{{ $usuario ->role }}</option>
                            @endif
                                  <option value="normal">normal</option>
                                  <option value="admin">admin</option>
                          </select>
                        </div>
                    </div>
                    
                      <div class="form-group mt-3">
                          <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-primary">Guardar</button>
                              
                          </div>
                      </div>
                  </form>
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