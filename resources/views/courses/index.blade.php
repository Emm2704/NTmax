<!-- resources/views/courses/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cursos</h1>
    <a href="{{ route('courses.create') }}" class="btn btn-primary">Crear Curso</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Título</th>
                <th>Nivel</th>
                <th>Duración</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->level }}</td>
                <td>{{ $course->duration }} horas</td>
                <td>{{ $course->is_active ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    <form action="{{ route('courses.toggle-status', $course->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">{{ $course->is_active ? 'Inactivar' : 'Activar' }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
