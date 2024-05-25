<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('posts.*', 'users.name as user_name')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.estado', 'activo') 
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('dashboard', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.new');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->description = $validatedData['description'];
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post creado correctamente.');
    }

    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->get();
        return view('posts.show', compact('post', 'comments'));
    }

    public function comments(Post $post)
    {
        $comments = $post->comments()->latest()->get();
        return view('posts.comments', compact('post', 'comments'));
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Comentario añadido correctamente',
            'comment' => $comment,
        ]);
    }

    public function edit(string $id)
    {
        // 
    }

    public function update(Request $request, string $id)
    {
        // 
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();

        $posts = Post::select('posts.*', 'users.name as user_name')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.estado', 'activo')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('dashboard', ['posts' => $posts]);
    }

    public function showImage($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            $imageContent = $post->image;
            return response($imageContent)->header('Content-Type', 'image');
        }
    }

    public function misPosts()
    {
        $userId = auth()->id();
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', $userId)
            ->orderBy('posts.created_at', 'desc')
            ->select('posts.*', 'users.name as user_name')
            ->get();

        return view('posts.mis-posts', compact('posts'));
    }

    public function inactivar(Post $post)
    {
        $post->estado = 'Inactivo';
        $post->save();
        return redirect()->route('dashboard')->with('success', 'Post inactivado correctamente.');
    }

    public function activar(Post $post)
    {
        $post->estado = 'Activo';
        $post->save();
        return redirect()->route('dashboard')->with('success', 'Post activado correctamente.');
    }
}
