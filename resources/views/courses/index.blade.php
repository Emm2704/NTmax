<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    
    <div class="container">
        @auth
        @if(auth()->user()->role === 'admin')
        <x-slot name="header">
            <div class="flex items-center">
                <a href="{{ route('courses.create') }}" class="icon-button d-inline-block" style="width: 5%; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/publish.png') }}" style="width: 100%; height: 100%; float: left;" alt="">
                </a>
                <h2 class="font-semibold text-xl leading-tight" style="color:rgba(39, 186, 195, 255);">
                    {{ __('Crea un nuevo curso') }}
                </h2>
            </div>
        </x-slot>
        @endif
        @endauth

        @foreach ($courses as $course)
        <div class="card mb-3" style="border-radius: 15px; max-width: 600px; margin: auto; overflow: hidden;">
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="Course Image" style="width: 100%; height: auto;">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $course->title }}</h5>
                <p class="card-text">{{ $course->description }}</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="bi bi-exclamation-circle"></i> Recomendado: para personas de 12 a 23 años
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-mortarboard"></i> Nivel del curso: {{ $course->level }}
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-clock"></i> Duración de {{ $course->duration }} horas
                    </li>
                </ul>
                <div class="d-grid gap-2">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary mt-3">Empezar curso</a>
                </div>
            </div>
            @auth
            @if(auth()->user()->role === 'admin')
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este curso?')">Eliminar</button>
                </form>
                <form action="{{ route('courses.toggle-status', $course->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">{{ $course->is_active ? 'Inactivar' : 'Activar' }}</button>
                </form>
            </div>
            @endif
            @endauth
        </div>
        @endforeach
    </div>
</x-app-layout>
