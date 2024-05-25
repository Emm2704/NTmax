<!-- resources/views/courses/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Curso</h1>
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $course->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Nivel</label>
            <input type="text" class="form-control" id="level" name="level" value="{{ $course->level }}" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duración (horas)</label>
            <input type="number" class="form-control" id="duration" name="duration" value="{{ $course->duration }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
