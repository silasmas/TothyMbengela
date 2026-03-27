<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentCommentLike;
use App\Models\ContentLike;
use App\Models\Rubrique;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Content::with(['rubrique', 'series', 'theme'])
            ->withCount('contentLikes')
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

        $likedContentIds = [];
        if (auth()->check() && $contents->isNotEmpty()) {
            $likedContentIds = ContentLike::query()
                ->where('user_id', auth()->id())
                ->whereIn('content_id', $contents->pluck('id'))
                ->pluck('content_id')
                ->all();
        }

        $rubriques = Rubrique::where('is_active', true)->orderBy('sort_order')->get();
        $types = ['video', 'audio', 'podcast', 'article'];

        return view('pages.contents.index', compact('contents', 'rubriques', 'types', 'likedContentIds'));
    }

    public function show(string $slug): View
    {
        $content = Content::with(['rubrique', 'series.contents' => function ($q) {
            $q->where('is_published', true)->orderBy('position');
        }, 'theme'])
            ->withCount('contentLikes')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $latestContents = Content::query()
            ->with('rubrique')
            ->where('is_published', true)
            ->where('id', '!=', $content->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $sidebarRubriques = Rubrique::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $sidebarTags = Theme::query()->orderBy('name')->limit(12)->get();

        $prevContent = null;
        $nextContent = null;
        if ($content->published_at) {
            $prevContent = Content::query()
                ->where('is_published', true)
                ->where('published_at', '<', $content->published_at)
                ->orderByDesc('published_at')
                ->first();
            $nextContent = Content::query()
                ->where('is_published', true)
                ->where('published_at', '>', $content->published_at)
                ->orderBy('published_at')
                ->first();
        } else {
            $prevContent = Content::query()
                ->where('is_published', true)
                ->where('id', '<', $content->id)
                ->orderByDesc('id')
                ->first();
            $nextContent = Content::query()
                ->where('is_published', true)
                ->where('id', '>', $content->id)
                ->orderBy('id')
                ->first();
        }

        $contentComments = $content->comments()
            ->withCount('likes')
            ->latest()
            ->get();

        $likedCommentIds = [];
        $userLikedContent = false;
        if (auth()->check()) {
            $likedCommentIds = ContentCommentLike::query()
                ->where('liker_fingerprint', 'user:'.auth()->id())
                ->whereIn('content_comment_id', $contentComments->pluck('id'))
                ->pluck('content_comment_id')
                ->all();
            $userLikedContent = ContentLike::query()
                ->where('content_id', $content->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('pages.contents.show', compact(
            'content',
            'latestContents',
            'sidebarRubriques',
            'sidebarTags',
            'prevContent',
            'nextContent',
            'contentComments',
            'likedCommentIds',
            'userLikedContent',
        ));
    }
}
