<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Content;
use App\Models\PastorActivity;
use App\Models\Series;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Suggestions JSON pour la recherche en temps réel (header).
     */
    public function suggestions(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([
                'contents' => [],
                'books' => [],
                'series' => [],
                'activities' => [],
            ]);
        }

        $like = '%'.$q.'%';

        $contents = Content::query()
            ->where('is_published', true)
            ->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('excerpt', 'like', $like);
            })
            ->latest('published_at')
            ->take(6)
            ->get(['title', 'slug', 'type']);

        $books = Book::query()
            ->where('is_active', true)
            ->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like);
            })
            ->latest()
            ->take(6)
            ->get(['title', 'slug']);

        $series = Series::query()
            ->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like);
            })
            ->latest()
            ->take(6)
            ->get(['title', 'slug']);

        $activities = PastorActivity::query()
            ->where('is_published', true)
            ->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhere('location', 'like', $like)
                    ->orWhereHas('galleryItems', fn ($q) => $q->where('caption', 'like', $like));
            })
            ->orderByRaw('COALESCE(ends_at, starts_at) DESC')
            ->take(6)
            ->get(['title', 'slug', 'starts_at']);

        return response()->json([
            'contents' => $contents->map(fn (Content $c) => [
                'title' => $c->title,
                'url' => route('contents.show', $c->slug),
                'type' => $c->type,
            ])->values()->all(),
            'books' => $books->map(fn (Book $b) => [
                'title' => $b->title,
                'url' => route('books.show', $b->slug),
            ])->values()->all(),
            'series' => $series->map(fn (Series $s) => [
                'title' => $s->title,
                'url' => route('series.show', $s->slug),
            ])->values()->all(),
            'activities' => $activities->map(fn (PastorActivity $a) => [
                'title' => $a->title,
                'url' => route('pastor-activities.show', $a),
                'meta' => $a->starts_at?->locale('fr')->isoFormat('D MMM YYYY'),
            ])->values()->all(),
        ]);
    }

    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $contents = collect();
        $books = collect();
        $series = collect();
        $activities = collect();

        if ($q !== '') {
            $like = '%'.$q.'%';

            $contents = Content::query()
                ->with('rubrique')
                ->where('is_published', true)
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('excerpt', 'like', $like);
                })
                ->latest('published_at')
                ->take(30)
                ->get();

            $books = Book::query()
                ->where('is_active', true)
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->latest()
                ->take(30)
                ->get();

            $series = Series::query()
                ->with('rubrique')
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->latest()
                ->take(30)
                ->get();

            $activities = PastorActivity::query()
                ->where('is_published', true)
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhere('location', 'like', $like)
                        ->orWhereHas('galleryItems', fn ($q) => $q->where('caption', 'like', $like));
                })
                ->orderByRaw('COALESCE(ends_at, starts_at) DESC')
                ->take(30)
                ->get();
        }

        return view('pages.search', compact('q', 'contents', 'books', 'series', 'activities'));
    }
}
