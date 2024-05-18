<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = DB::table('users')
        ->get();
 
        return view('usuarios.index', ['usuarios' => $usuarios]);

        // $usuarios = User::all();
        // return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $usuario = User::find($id);

        return view('usuarios.edit', ['usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        
        $user ->name = $request->name;
        $user ->email = $request->email;
        $user ->role = $request->role;
        $user ->save();

        $usuarios = DB::table('users')
        ->get();
 
        return view('usuarios.index', ['usuarios' => $usuarios]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inactivar(User $usuario)
    {
        $usuario->estado = 'Inactivo';
        $usuario->save();
        return redirect()->route('usuarios.index')->with('success', 'Usuario inactivado correctamente.');
    }

    public function activar(User $usuario)
    {
        $usuario->estado = 'Activo';
        $usuario->save();
        return redirect()->route('usuarios.index')->with('success', 'Usuario activado correctamente.');
    }
}
