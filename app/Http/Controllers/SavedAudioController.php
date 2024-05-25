<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audio;
use App\Models\SavedAudio;
use Illuminate\Support\Facades\Auth;

class SavedAudioController extends Controller
{
    public function index()
    {
        $savedAudios = SavedAudio::where('user_id', Auth::id())->with('audio')->get();
        return view('saved-audios.index', compact('savedAudios'));
    }

    public function save(Audio $audio)
    {
        $savedAudio = SavedAudio::firstOrCreate([
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
            return response()->json(['status' => 'success', 'message' => 'Audio eliminado de guardados']);
        }

        return response()->json(['status' => 'error', 'message' => 'Audio no encontrado en guardados']);
    }
}
