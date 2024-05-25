<x-app-layout>
    <div class="container mt-5">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Crear Nueva Ayuda') }}
            </h2>
        </x-slot>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('helps.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
