<?php

// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rol,name',
        ]);

        Rol::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Rol $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Rol $role)
    {
        $request->validate([
            'name' => 'required|unique:rol,name,'.$role->id,
        ]);

        $role->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Rol $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
