<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // return view('dashboard', ['posts' => $posts]);

        $posts = Post::select('posts.*', 'users.name as user_name')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->orderBy('posts.created_at', 'desc')
        ->get();
    

          return view('dashboard', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Valida los datos del formulario
    $validatedData = $request->validate([
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048', // Ajusta el tamaño máximo de la imagen según tus necesidades
    ]);

    // Crea un nuevo post en la base de datos
    $post = new Post();
    $post->user_id = auth()->id(); // Asigna el ID del usuario actual
    $post->description = $validatedData['description'];
    
    // Guarda la imagen si se ha subido
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images');
        $post->image = $imagePath;
    }

    $post->save();

    // Redirige al usuario al dashboard u otra página después de crear el post
    return redirect()->route('dashboard')->with('success', 'Post creado correctamente.');
}
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showImage($id)
{
    $post = Post::findOrFail($id);

    // Verifica si el post tiene una imagen
    if ($post->image) {
        // Obtén el contenido de la imagen desde la base de datos
        $imageContent = $post->image;

        // Devuelve la imagen con el tipo de contenido adecuado
        return response($imageContent)->header('Content-Type', 'image');
    }

    // Si el post no tiene imagen, devuelve una imagen de marcador de posición o un mensaje de error
    // ...
}
}
