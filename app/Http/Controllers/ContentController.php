<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Rubrique;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Content::with(['rubrique', 'series', 'theme'])
            ->where('is_published', true);

        if ($rubrique = $request->query('rubrique')) {
            $query->whereHas('rubrique', fn ($q) => $q->where('slug', $rubrique));
        }

        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $contents = $query->latest('published_at')->paginate(12);

        $rubriques = Rubrique::where('is_active', true)->orderBy('sort_order')->get();
        $types = ['video', 'audio', 'podcast', 'article'];

        return view('pages.contents.index', compact('contents', 'rubriques', 'types'));
    }

    public function show(string $slug): View
    {
        $content = Content::with(['rubrique', 'series.contents' => function ($q) {
            $q->where('is_published', true)->orderBy('position');
        }, 'theme'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $related = Content::with('rubrique')
            ->where('is_published', true)
            ->where('id', '!=', $content->id)
            ->where('rubrique_id', $content->rubrique_id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('pages.contents.show', compact('content', 'related'));
    }
}
