<x-app-layout>
    <div class="container mt-5">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Ayuda') }}
            </h2>
        </x-slot>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('helps.create') }}" class="btn btn-primary">Crear Nueva Ayuda</a>
        </div>

        <div class="row">
            @foreach ($helps as $help)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $help->title }}</h5>
                        <p class="card-text">{{ $help->description }}</p>
                        <p class="card-text"><small class="text-muted">Creado hace {{ $help->created_at->diffForHumans() }}</small></p>
                        <a href="{{ route('helps.show', $help->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('helps.edit', $help->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('helps.destroy', $help->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta ayuda?')">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
