<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Content;
use App\Models\PastorActivity;
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
            ->orderByRaw("CASE product_type WHEN 'book' THEN 0 WHEN 'usb' THEN 1 WHEN 'pack' THEN 2 ELSE 3 END")
            ->latest()
            ->take(8)
            ->get();

        $booksCartPayload = $books
            ->filter(fn (Book $b) => $b->isPurchasable())
            ->map(fn (Book $b) => $b->toCartItem())
            ->values()
            ->all();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $pastorAgendaToday = PastorActivity::query()
            ->published()
            ->overlappingToday()
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();

        $pastorAgendaUpcoming = PastorActivity::query()
            ->published()
            ->upcomingFromTomorrow()
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->take(2)
            ->get();

        $pastorAgendaPast = PastorActivity::query()
            ->published()
            ->pastCompleted()
            ->orderByRaw('COALESCE(ends_at, starts_at) DESC')
            ->orderBy('sort_order')
            ->take(2)
            ->get();

        return view('pages.home', compact(
            'featuredContents',
            'latestContents',
            'rubriques',
            'latestSeries',
            'books',
            'booksCartPayload',
            'testimonials',
            'pastorAgendaToday',
            'pastorAgendaUpcoming',
            'pastorAgendaPast',
        ));
    }

    public function about(): View
    {
        $teamMembers = TeamMember::query()->activeOrdered()->get();

        return view('pages.about', compact('teamMembers'));
    }
}
