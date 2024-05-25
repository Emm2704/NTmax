<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight" style="color:rgba(39, 186, 195, 255);">
                {{ __('Comentarios') }}
            </h2>
        </x-slot>

        <div class="card mb-3" style="border-radius: 50px; max-width: 600px; margin: auto;">
            @if ($post->image)
                <div style="position: relative; width: 100%; max-width: 600px;">
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image" style="width: 100%; height: auto;">
                    <div style="position: absolute; top: 0px; right: 0px; background-color: rgba(39, 186, 195, 255); padding: 10px 60px; border-radius: 0px 0px 0px 50px;">
                        <h5 style="color: white; margin: 0;">{{ $post->user->name }}</h5>
                    </div>
                </div>
            @endif
            <div class="card-body" style="background-color: rgba(39, 186, 195, 255);">
                <p class="card-text">{{ $post->description }}</p>
                <p class="card-text"><small class="text-muted">Publicado hace {{ $post->created_at->diffForHumans() }}</small></p>
            </div>
        </div>

        <!-- Sección de comentarios -->
        <div class="card mb-3" style="margin: auto; max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title">Comentarios</h5>
                @foreach ($comments as $comment)
                    <div class="comment mb-2">
                        <strong>{{ $comment->user->name }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach
                <div id="new-comments"></div>
                <!-- Formulario para añadir un nuevo comentario -->
                <div class="mt-3">
                    <input type="text" id="new-comment-content" class="form-control" placeholder="Añadir un comentario...">
                    <button class="btn btn-primary mt-2" onclick="addComment({{ $post->id }})">Comentar</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function addComment(postId) {
        const content = document.getElementById('new-comment-content').value;

        fetch(`/posts/${postId}/comment`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ content: content })
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

            // Añadir el nuevo comentario a la lista de comentarios
            const newCommentHtml = `
                <div class="comment mb-2">
                    <strong>${data.comment.user.name}</strong>
                    <small class="text-muted">Justo ahora</small>
                    <p>${data.comment.content}</p>
                </div>
            `;
            document.getElementById('new-comments').insertAdjacentHTML('afterbegin', newCommentHtml);
            document.getElementById('new-comment-content').value = ''; // Limpiar el campo de entrada
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
