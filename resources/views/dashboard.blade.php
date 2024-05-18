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
                        <h5 style="color: white; margin: 0; font-size: 18px;">{{ $post->user_name }}</h5>
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
                <button class="icon-button d-inline-block" onclick="mostrarAlerta()" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px; margin-left:8%;">
                    <img src="{{ asset('src/like.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Me gusta</span>
                </button>

                <!-- Botón para Comentar -->
                <button class="icon-button d-inline-block" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/coment.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Comentar</span>
                </button>

                <!-- Botón para Guardar -->
                <button class="icon-button d-inline-block" onclick="confirmarGuardar()" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/marcador.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Guardar</span>
                </button>

                <!-- Botón para compartir -->
                <button class="icon-button d-inline-block" onclick="mostrarCompartir()" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                    <img src="{{ asset('src/share.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                    <span style="display: inline-block;">Compartir</span>
                </button>
                @if (Auth::user()->role == 'admin')
                <div style="display: inline-block;">
                    <!-- Formulario para eliminar la publicación -->
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');">
                        @csrf
                        @method('DELETE')
                        <button class="icon-button d-inline-block" style="width: auto; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                            <img src="{{ asset('src/delete.png') }}" style="width: 30px; height: 30px; float: left; margin-right: 10px;" alt="">
                            <span style="display: inline-block;">Eliminar</span>
                        </button>
                    </form>
                    <!-- Formulario para ocultar la publicación -->
                    <form action="{{ route('posts.inactivar', ['post' => $post->id]) }}" method='POST' style="display:inline-block">
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
    function mostrarAlerta() {
        Swal.fire({
            icon: 'success',
            title: '¡Me gusta!',
            showConfirmButton: false,
            timer: 1500
        });
    }

    function confirmarGuardar() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Quieres guardar este post?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    '¡Guardado!',
                    'Tu post ha sido guardado correctamente.',
                    'success'
                );
            }
        });
    }

    function mostrarCompartir() {
        Swal.fire({
            title: 'Compartir en redes sociales',
            html: `
                <p>Haz clic en el icono de la red social en la que quieres compartir:</p>
                <div style="display: flex; justify-content: space-around;">
                    <a href="#" onclick="compartirFacebook()">
                        <img src="{{ asset('src/facebook.png') }}" style="width: 30px; height: 30px;" alt="Facebook">
                    </a>
                    <a href="#" onclick="compartirTwitter()">
                        <img src="{{ asset('src/twitter.png') }}" style="width: 30px; height: 30px;" alt="Twitter">
                    </a>
                    <a href="#" onclick="compartirLinkedIn()">
                        <img src="{{ asset('src/instagram.png') }}" style="width: 30px; height: 30px;" alt="Instagram">
                    </a>
                </div>
            `,
            showCancelButton: false,
            showConfirmButton: false
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

    function ocultarPublicacion(postId) {
        var publicacion = document.getElementById('publicacion-' + postId);
        if (publicacion) {
            publicacion.style.display = 'none';
        }
    }
</script>
