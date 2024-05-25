<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5pR2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <div class="container mt-5">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight" style="color: rgba(39, 186, 195, 255);">
                {{ __('Mis Audios Guardados') }}
            </h2>
        </x-slot>

        <div class="row justify-content-center">
            @foreach ($savedAudios as $savedAudio)
                <div class="col-md-8 mb-4">
                    <div class="card" style="
                        border-radius: 20px; 
                        max-height: auto; 
                        max-width: 600px; 
                        margin: auto; 
                        overflow: hidden;
                        background-color: rgba(39, 186, 195, 255);
                        color: white;">
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small>{{ $savedAudio->audio->created_at->diffForHumans() }}</small>
                                <small>{{ $savedAudio->audio->user->name }}</small>
                            </div>
                            
                            <div class="d-flex justify-content-center mb-2">
                                <audio controls class="w-100">
                                    <source src="{{ asset('storage/' . $savedAudio->audio->file_path) }}" type="audio/mp3">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-link text-white" onclick="toggleLike({{ $savedAudio->audio->id }})">
                                        <i class="bi bi-hand-thumbs-up"></i> Me gusta
                                    </button>
                                    <span id="like-count-{{ $savedAudio->audio->id }}" class="ms-2">{{ $savedAudio->audio->likes->count() }}</span>
                                </div>
                                <div>
                                    <button class="btn btn-link text-white" onclick="unsaveAudio({{ $savedAudio->audio->id }})">
                                        <i class="bi bi-bookmark"></i> Eliminar de Guardados
                                    </button>
                                </div>
                                <div>
                                    <a href="{{ asset('storage/' . $savedAudio->audio->file_path) }}" class="btn btn-link text-white" target="_blank">
                                        <i class="bi bi-play-circle"></i> Escuchar
                                    </a>
                                </div>
                                @if (Auth::user()->role === 'admin')
                                <div>
                                    <form action="{{ route('audios.inactivar', $savedAudio->audio->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link text-white">
                                            <i class="bi bi-x-circle"></i> Inactivar
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<script>
    function toggleLike(audioId) {
        fetch(`/audios/${audioId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById(`like-count-${audioId}`).innerText = data.likeCount;
                Swal.fire({
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function unsaveAudio(audioId) {
        fetch(`/audios/${audioId}/unsave`, {
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
            location.reload(); // Recarga la página para actualizar la lista de audios guardados
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
