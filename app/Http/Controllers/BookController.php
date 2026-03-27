<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('pages.books.index', compact('books'));
    }

    public function show(string $slug): View
    {
        $book = Book::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.books.show', compact('book'));
    }
}
