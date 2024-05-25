<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{
    public function save(Post $post)
    {
        try {
            $savedPost = SavedPost::firstOrCreate([
                'user_id' => Auth::id(),
                'post_id' => $post->id
            ]);

            return response()->json(['status' => 'success', 'message' => 'Post saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $savedPosts = SavedPost::where('user_id', Auth::id())->with('post')->get();

        return view('saved-posts.index', compact('savedPosts'));
    }
}
