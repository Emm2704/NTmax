<x-app-layout>
    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-xl leading-tight" style="color:rgba(39, 186, 195, 255);">
                {{ __('Mis Publicaciones Guardadas') }}
            </h2>
        </x-slot>

        @foreach ($savedPosts as $savedPost)
        <div class="card mb-3" style="
            border-radius: 15px;
            max-height: auto;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
            ">
            @if ($savedPost->post->image)
                <div style="position: relative; width: 100%; max-width: 600px;">
                    <img src="{{ asset('storage/' . $savedPost->post->image) }}" class="card-img-top" alt="Post Image" style="width: 100%; height: auto;">
                </div>
            @endif
            <div class="card-body" style="background-color: rgba(39, 186, 195, 255);">
                <h5 class="card-title" style="color: white;">{{ $savedPost->post->user->name }}</h5>
                <p class="card-text">{{ $savedPost->post->description }}</p>
                <p class="card-text"><small class="text-muted">Publicado hace {{ $savedPost->post->created_at->diffForHumans() }}</small></p>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
