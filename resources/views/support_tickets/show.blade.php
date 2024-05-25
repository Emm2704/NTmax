<x-app-layout>
    <div class="container mt-5">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Detalle del Ticket de Soporte') }}
            </h2>
        </x-slot>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $supportTicket->title }}</h5>
                <p class="card-text">{{ $supportTicket->description }}</p>
                <p class="card-text"><small class="text-muted">Creado hace {{ $supportTicket->created_at->diffForHumans() }}</small></p>
                <a href="{{ route('support_tickets.edit', $supportTicket->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('support_tickets.destroy', $supportTicket->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este ticket?')">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
