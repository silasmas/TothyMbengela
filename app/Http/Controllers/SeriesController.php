<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Rubrique;
use App\Models\Series;
use App\Models\Theme;
use Illuminate\View\View;

class SeriesController extends Controller
{
    public function index(): View
    {
        $series = Series::with([
            'rubrique',
            'contents' => fn ($q) => $q->where('is_published', true)->orderBy('position'),
        ])
            ->withCount(['contents' => fn ($q) => $q->where('is_published', true)])
            ->latest()
            ->paginate(12);

        return view('pages.series.index', compact('series'));
    }

    public function show(string $slug): View
    {
        $series = Series::with(['rubrique', 'contents' => function ($q) {
            $q->where('is_published', true)->orderBy('position');
        }])
            ->where('slug', $slug)
            ->firstOrFail();

        $latestContents = Content::query()
            ->with('rubrique')
            ->where('is_published', true)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $sidebarRubriques = Rubrique::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $sidebarTags = Theme::query()->orderBy('name')->limit(12)->get();

        return view('pages.series.show', compact(
            'series',
            'latestContents',
            'sidebarRubriques',
            'sidebarTags',
        ));
    }
}
