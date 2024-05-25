<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SavedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedBookController extends Controller
{
    public function index()
    {
        $savedBooks = Auth::user()->savedBooks()->with('book')->get();
        return view('saved-books.index', compact('savedBooks'));
    }

    public function save(Book $book)
    {
        SavedBook::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Libro guardado correctamente']);
    }

    public function destroy(Book $book)
    {
        $savedBook = SavedBook::where('user_id', Auth::id())->where('book_id', $book->id)->first();
        if ($savedBook) {
            $savedBook->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Libro eliminado de los guardados']);
    }
}
