<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">


    <div class="container mt-5">
        <div class="card" style="border-radius: 15px; max-width: 600px; margin: auto; overflow: hidden;">
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
                    <a href="#" class="btn btn-primary mt-3">Empezar curso</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
