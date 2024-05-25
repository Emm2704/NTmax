<!-- resources/views/courses/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Curso</h1>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Nivel</label>
            <input type="text" class="form-control" id="level" name="level" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duración (horas)</label>
            <input type="number" class="form-control" id="duration" name="duration" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
