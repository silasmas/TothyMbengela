<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Content;
use App\Models\Rubrique;
use App\Models\Series;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredContents = Content::with(['rubrique', 'series'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        $latestContents = Content::with(['rubrique', 'series'])
            ->where('is_published', true)
            ->latest('published_at')
            ->take(8)
            ->get();

        $rubriques = Rubrique::withCount('contents')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $latestSeries = Series::with('rubrique')
            ->withCount('contents')
            ->latest()
            ->take(4)
            ->get();

        $books = Book::where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $booksCartPayload = $books
            ->filter(fn (Book $b) => $b->stock_quantity === null || $b->stock_quantity > 0)
            ->map(fn (Book $b) => [
                'id' => $b->id,
                'title' => $b->title,
                'price' => $b->price !== null ? (float) $b->price : null,
                'currency' => $b->currency ?? 'USD',
                'cover_url' => $b->cover_url,
            ])
            ->values()
            ->all();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.home', compact(
            'featuredContents',
            'latestContents',
            'rubriques',
            'latestSeries',
            'books',
            'booksCartPayload',
            'testimonials',
        ));
    }

    public function about(): View
    {
        $teamMembers = TeamMember::query()->activeOrdered()->get();

        return view('pages.about', compact('teamMembers'));
    }
}
