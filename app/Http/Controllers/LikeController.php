<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        $likeCount = $post->likes()->count();

        return response()->json(['status' => 'success', 'message' => 'Post liked successfully', 'likeCount' => $likeCount]);
    }

    public function unlike(Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();

        if ($like) {
            $like->delete();
        }

        $likeCount = $post->likes()->count();

        return response()->json(['status' => 'success', 'message' => 'Post unliked successfully', 'likeCount' => $likeCount]);
    }
}
