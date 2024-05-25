<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Curso') }}
        </h2>
    </x-slot>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Editar Curso
            </div>
            <div class="card-body">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Título del Curso</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción del Curso</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $course->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Nivel del Curso</label>
                        <input type="text" class="form-control" id="level" name="level" value="{{ $course->level }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duración del Curso (en horas)</label>
                        <input type="number" class="form-control" id="duration" name="duration" value="{{ $course->duration }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Imagen del Curso</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    @if ($course->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="img-fluid">
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
