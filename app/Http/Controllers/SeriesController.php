<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\View\View;

class SeriesController extends Controller
{
    public function index(): View
    {
        $series = Series::with('rubrique')
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

        return view('pages.series.show', compact('series'));
    }
}
