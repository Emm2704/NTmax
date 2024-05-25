<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <div class="container mt-5">
        <h2 class="mb-4">Añadir Libro</h2>
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Libro</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="pdf" class="form-label">Archivo PDF</label>
                <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagen del Libro</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
