<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Like;
use App\Models\SavedAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AudioController extends Controller
{
    public function index()
    {
        $audios = Audio::with('user', 'likes', 'savedAudios')->latest()->get();
        return view('audios.index', compact('audios'));
    }

    public function create()
    {
        return view('audios.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:mp3,wav|max:20480', // Máximo 20 MB
        ]);

        $filePath = $request->file('file')->store('audios');

        $audio = new Audio();
        $audio->title = $validatedData['title'];
        $audio->file_path = $filePath;
        $audio->duration = $this->getAudioDuration($filePath);
        $audio->user_id = Auth::id();
        $audio->save();

        return redirect()->route('audios.index')->with('success', 'Audio creado correctamente.');
    }

    private function getAudioDuration($filePath)
    {
        // Implementa la lógica para obtener la duración del audio
        // Puede usar paquetes de PHP como `getID3` para obtener la duración
        return 0;
    }

    public function toggleLike(Audio $audio)
    {
        $like = Like::where('user_id', Auth::id())->where('audio_id', $audio->id)->first();

        if ($like) {
            $like->delete();
            $likeCount = $audio->likes()->count();
            return response()->json(['status' => 'success', 'message' => 'Me gusta eliminado', 'likeCount' => $likeCount]);
        } else {
            $audio->likes()->create(['user_id' => Auth::id()]);
            $likeCount = $audio->likes()->count();
            return response()->json(['status' => 'success', 'message' => 'Me gusta añadido', 'likeCount' => $likeCount]);
        }
    }

    public function save(Audio $audio)
    {
        SavedAudio::firstOrCreate([
            'user_id' => Auth::id(),
            'audio_id' => $audio->id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Audio guardado correctamente']);
    }

    public function unsave(Audio $audio)
    {
        $savedAudio = SavedAudio::where('user_id', Auth::id())->where('audio_id', $audio->id)->first();
        if ($savedAudio) {
            $savedAudio->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Audio eliminado de guardados']);
    }

    public function inactivar(Audio $audio)
    {
        $audio->estado = 'Inactivo';
        $audio->save();
        return redirect()->route('audios.index')->with('success', 'Audio inactivado correctamente.');
    }

    public function activar(Audio $audio)
    {
        $audio->estado = 'Activo';
        $audio->save();
        return redirect()->route('audios.index')->with('success', 'Audio activado correctamente.');
    }

}
