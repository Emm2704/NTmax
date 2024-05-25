<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <div class="container mt-5">
        @auth
        @if(auth()->user()->role === 'admin')
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Añadir Libro</a>
        </div>
        @endif
        @endauth
        <div class="row">
            @foreach ($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{ $book->name }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $book->name }}</h5>
                        <button class="btn btn-info" onclick="toggleDescription({{ $book->id }})">Info</button>
                        <a href="{{ route('books.download', $book->id) }}" class="btn btn-success">Descargar</a>
                        <button class="btn btn-primary" onclick="saveBook({{ $book->id }})">Guardar Libro</button>
                        <div id="description-{{ $book->id }}" class="mt-3" style="display:none;">
                            <p>{{ $book->description }}</p>
                        </div>
                    </div>
                    @auth
                    @if(auth()->user()->role === 'admin')
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este libro?')">Eliminar</button>
                        </form>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<script>
    function toggleDescription(bookId) {
        var element = document.getElementById('description-' + bookId);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }

    function saveBook(bookId) {
        fetch(`/books/${bookId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.json();
        }).then(data => {
            Swal.fire({
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1500
            });
        }).catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                showConfirmButton: true
            });
        });
    }

</script>
