<x-app-layout>
    <div class="container mt-5">
        <h2 class="font-semibold text-xl leading-tight mb-4">{{ __('Editar Ticket de Soporte') }}</h2>
        
        <form action="{{ route('support_tickets.update', $supportTicket->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $supportTicket->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $supportTicket->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Asunto</label>
                <input type="text" class="form-control" id="subject" name="subject" value="{{ $supportTicket->subject }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</x-app-layout>
