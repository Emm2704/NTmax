<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <div class="container">
        <x-slot name="header">
            <div class="flex items-center">
                <a href="{{ route('posts.create') }}" class="icon-button d-inline-block" style="width: 5%; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/publish.png') }}" style="width: 100%; height: 100%; float: left;" alt="">
                </a>
                <h2 class="font-semibold text-xl leading-tight" style="color:rgba(39, 186, 195, 255);">
                    {{ __('Cuentanos que sientes 😊') }}
                </h2>
            </div>
        </x-slot>
        
        @foreach ($posts as $post)
        <div class="card mb-3" style="
            border-top-left-radius: 50px;
            border-top-right-radius: 50px;
            max-height: auto;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
            ">
            @if ($post->image)
                <div style="position: relative; width: 100%; max-width: 600px;">
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image" style="width: 100%; height: auto;">
                    <div style="position: absolute; top: 0px; right: 0px; background-color: rgba(39, 186, 195, 255); padding: 10px 60px; border-top-left-radius: 0px; border-bottom-left-radius: 50px;">
                        <h5 style="color: white; margin: 0; font-size: 18px;">{{ $post->user->name }}</h5>
                    </div>                
                </div>
            @endif
            <div class="card-body" style="background-color: rgba(39, 186, 195, 255);">
                <p class="card-text">{{ $post->description }}</p>
                <p class="card-text"><small class="text-muted">Publicado hace {{ $post->created_at->diffForHumans() }}</small></p>
            </div>
        </div>
        <div class="card mb-3" style="margin: auto; max-width: 600px;
            background-color: rgba(39, 186, 195, 255);
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;">
            <p style="margin-top: 2%">
                <!-- Botón para Me gusta -->
                <button class="icon-button d-inline-block" onclick="toggleLike({{ $post->id }})" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px; margin-left:8%;">
                    <img src="{{ asset('src/like.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span id="like-count-{{ $post->id }}" style="display: inline-block;">{{ $post->likes->count() }}</span> Me gusta
                </button>

                <!-- Botón para Comentarios -->
                <!-- Botón para Comentarios -->
                <button class="icon-button d-inline-block" onclick="window.location.href='{{ route('posts.comments', $post->id) }}'" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/coment.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Comentarios</span>
                </button>

                <!-- Botón para Guardar -->
                <button class="icon-button d-inline-block" onclick="savePost({{ $post->id }})" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/marcador.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Guardar</span>
                </button>

                <!-- Botón para compartir -->
                <button class="icon-button d-inline-block" onclick="mostrarCompartir({{ $post->id }})" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/share.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Compartir</span>
                </button>

                @if (Auth::user()->role == 'admin')
                <div style="display: inline-block;">
                    <!-- Formulario para eliminar la publicación -->
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button class="icon-button d-inline-block" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                            <img src="{{ asset('src/delete.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                            <span style="display: inline-block;">Eliminar</span>
                        </button>
                    </form>
                    <!-- Formulario para ocultar la publicación -->
                    <form action="{{ route('posts.inactivar', ['post' => $post->id]) }}" method='POST' style="display:inline;">
                        @method('put')
                        @csrf
                        <button class="icon-button d-inline-block" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                            <img src="{{ asset('src/hide.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                            <span style="display: inline-block;">Ocultar</span>
                        </button>
                    </form>
                </div>
                @endif
            </p>
        </div>
        @endforeach
    </div>
</x-app-layout>

<script>
    function toggleLike(postId) {
        const likeCountElement = document.getElementById(`like-count-${postId}`);
        
        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                likeCountElement.innerText = data.likeCount;
                Swal.fire({
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function savePost(postId) {
        fetch(`/posts/${postId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        }).then(response => {
            if (!response.ok) {
                return response.json().then(error => { throw new Error(error.message); });
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
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                showConfirmButton: true
            });
        });
    }

    function mostrarCompartir(postId) {
        const link = `http://127.0.0.1:8000/dashboard/${postId}`;
        navigator.clipboard.writeText(link).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Enlace copiado',
                text: 'El enlace ha sido copiado al portapapeles: ' + link,
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        }).catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo copiar el enlace: ' + error,
                showConfirmButton: true
            });
        });
    }

    function compartirFacebook() {
        Swal.fire(
            'Compartido exitosamente',
            '',
            'success'
        );
    }

    function compartirTwitter() {
        Swal.fire(
            'Compartido exitosamente',
            '',
            'success'
        );
    }

    function compartirLinkedIn() {
        Swal.fire(
            'Compartido exitosamente',
            '',
            'success'
        );
    }
</script>
