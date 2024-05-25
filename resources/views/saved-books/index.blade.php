<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <div class="container mt-5">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight" style="color:rgba(39, 186, 195, 255);">
                {{ __('Mis Libros Guardados') }}
            </h2>
        </x-slot>
        <div class="row">
            @foreach ($savedBooks as $savedBook)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $savedBook->book->image) }}" class="card-img-top" alt="{{ $savedBook->book->name }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $savedBook->book->name }}</h5>
                        <button class="btn btn-info" onclick="toggleDescription({{ $savedBook->book->id }})">Info</button>
                        <a href="{{ asset('storage/' . $savedBook->book->pdf) }}" class="btn btn-success">Descargar</a>
                        <button class="btn btn-danger" onclick="unsaveBook({{ $savedBook->book->id }})">Eliminar de Guardados</button>
                        <div id="description-{{ $savedBook->book->id }}" class="mt-3" style="display:none;">
                            <p>{{ $savedBook->book->description }}</p>
                        </div>
                    </div>
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

    function unsaveBook(bookId) {
        fetch(`/books/${bookId}/unsave`, {
            method: 'DELETE',
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

            location.reload(); // Recarga la página para actualizar la lista de libros guardados
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
