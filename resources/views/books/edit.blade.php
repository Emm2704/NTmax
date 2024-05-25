<x-app-layout>
    <div class="container mt-5">
        <h2>Editar Libro</h2>
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Libro</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $book->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $book->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="pdf" class="form-label">Archivo PDF</label>
                <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf">
                <p>Archivo actual: <a href="{{ route('books.download', $book->id) }}">{{ $book->pdf }}</a></p>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagen del Libro</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name }}" style="width: 100px; height: auto;">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</x-app-layout>
