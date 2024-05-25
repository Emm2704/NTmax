<?php
// app/Http/Controllers/BookController.php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'pdf' => 'required|mimes:pdf|max:20480',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['_token']); // Excluir _token

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('books/pdfs');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books/images');
        }

        Book::create($data);
        return redirect()->route('books.index')->with('success', 'Libro creado exitosamente.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['_token', '_method']); // Excluir _token y _method

        if ($request->hasFile('pdf')) {
            Storage::delete($book->pdf);
            $data['pdf'] = $request->file('pdf')->store('books/pdfs');
        }

        if ($request->hasFile('image')) {
            Storage::delete($book->image);
            $data['image'] = $request->file('image')->store('books/images');
        }

        $book->update($data);
        return redirect()->route('books.index')->with('success', 'Libro actualizado exitosamente.');
    }

    public function destroy(Book $book)
    {
        Storage::delete($book->pdf);
        Storage::delete($book->image);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Libro eliminado exitosamente.');
    }

    public function download(Book $book)
    {
        return Storage::download($book->pdf);
    }
}
