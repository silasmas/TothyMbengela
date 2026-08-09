<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Testimonial;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->where('is_active', true)
            ->orderedForDisplay()
            ->get();

        return view('pages.books.index', compact('books'));
    }

    public function show(string $slug): View
    {
        $book = Book::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedBooks = Book::query()
            ->where('is_active', true)
            ->where('id', '!=', $book->id)
            ->orderedForDisplay()
            ->limit(4)
            ->get();

        $bookReviews = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->limit(12)
            ->get();

        return view('pages.books.show', compact('book', 'relatedBooks', 'bookReviews'));
    }
}
