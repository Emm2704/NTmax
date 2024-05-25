<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-SL25GAkCz06bDADKmMv3UjiAHJzrmcN7k1WyCmSRj5R2EMZZBo1p7voikd0jJzG3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <div class="container mt-5">
        <x-slot name="header">
            <a href="{{ route('audios.create') }}" class="icon-button d-inline-block" style="width: 5%; height: auto; padding: 0; border: none; background: none; margin-right:12px;">
                <img src="{{ asset('src/publish.png') }}" style="width: 100%; height: 100%; float: left;" alt="">
            </a>
            <h2 class="font-semibold text-xl leading-tight" style="color: rgba(39, 186, 195, 255);">
                {{ __('Audios') }}
            </h2>
        </x-slot>

        <div class="row justify-content-center">
            @foreach ($audios as $audio)
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
                                <small>{{ $audio->created_at->diffForHumans() }}</small>
                                <small>{{ $audio->user->name }}</small>
                            </div>
                            
                            <div class="d-flex justify-content-center mb-2">
                                <audio controls class="w-100">
                                    <source src="{{ asset('storage/' . $audio->file_path) }}" type="audio/mp3">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-link text-white" onclick="toggleLike({{ $audio->id }})">
                                        <i class="bi bi-hand-thumbs-up"></i> Me gusta
                                    </button>
                                    <span id="like-count-{{ $audio->id }}" class="ms-2">{{ $audio->likes->count() }}</span>
                                </div>
                                <div>
                                    <button class="btn btn-link text-white" onclick="saveAudio({{ $audio->id }})">
                                        <i class="bi bi-bookmark"></i> Guardar
                                    </button>
                                </div>
                                <div>
                                    <a href="{{ asset('storage/' . $audio->file_path) }}" class="btn btn-link text-white" target="_blank">
                                        <i class="bi bi-play-circle"></i> Escuchar
                                    </a>
                                </div>
                            </div>
                            @if (Auth::user() && Auth::user()->role === 'admin')
                            <div class="d-flex justify-content-end mt-2">
                                @if ($audio->estado === 'Activo')
                                    <form action="{{ route('audios.inactivar', $audio) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning">Inactivar</button>
                                    </form>
                                @else
                                    <form action="{{ route('audios.activar', $audio) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">Activar</button>
                                    </form>
                                @endif
                            </div>
                            @endif
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

    function saveAudio(audioId) {
        fetch(`/audios/${audioId}/save`, {
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
