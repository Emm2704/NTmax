<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedAudio extends Model
{
    use HasFactory;

    protected $table = 'saved_audios';

    protected $fillable = ['user_id', 'audio_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }
}
