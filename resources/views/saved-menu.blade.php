<!-- resources/views/saved-menu.blade.php -->
<x-app-layout>
    <div class="container mt-5">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight" style="color: rgba(39, 186, 195, 255);">
                {{ __('Mis Guardados') }}
            </h2>
        </x-slot>

        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <a href="{{ route('saved-posts.index') }}" class="text-decoration-none">
                    <div class="card text-center" style="border-radius: 20px; background-color: rgba(39, 186, 195, 255); color: white;">
                        <div class="card-body">
                            <img src="{{ asset('src/marcador.png') }}" class="img-fluid mb-2" alt="Mis Posts" style="height: 50px;">
                            <h5 class="card-title">Mis Posts</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('saved-audios.index') }}" class="text-decoration-none">
                    <div class="card text-center" style="border-radius: 20px; background-color: rgba(39, 186, 195, 255); color: white;">
                        <div class="card-body">
                            <img src="{{ asset('src/auriculares.png') }}" class="img-fluid mb-2" alt="Mis Audios" style="height: 50px;">
                            <h5 class="card-title">Mis Audios</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('saved-books.index') }}" class="text-decoration-none">
                    <div class="card text-center" style="border-radius: 20px; background-color: rgba(39, 186, 195, 255); color: white;">
                        <div class="card-body">
                            <img src="{{ asset('src/libro.png') }}" class="img-fluid mb-2" alt="Mis Libros" style="height: 50px;">
                            <h5 class="card-title">Mis Libros</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
