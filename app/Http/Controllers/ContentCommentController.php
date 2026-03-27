<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentComment;
use App\Models\ContentCommentLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentCommentController extends Controller
{
    public function store(Request $request, string $slug): JsonResponse|RedirectResponse
    {
        $content = Content::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:5000'],
        ]);
        $data['user_id'] = auth()->id();
        $data['author_name'] = auth()->user()->name;
        $data['author_email'] = auth()->user()->email;

        /** @var ContentComment $comment */
        $comment = $content->comments()->create($data);
        $comment->loadCount('likes');

        $total = $content->comments()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Commentaire publié.',
                'comments_count' => $total,
                'comment' => [
                    'id' => $comment->id,
                    'author_name' => $comment->author_name,
                    'body' => $comment->body,
                    'likes_count' => (int) $comment->likes_count,
                    'created_label' => $comment->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm'),
                ],
            ]);
        }

        return back()->with('comment_success', true)->withFragment('commentaires');
    }

    public function toggleLike(Request $request, string $slug, ContentComment $comment): JsonResponse|RedirectResponse
    {
        $content = Content::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        abort_unless($comment->content_id === $content->id, 404);

        $fingerprint = 'user:'.auth()->id();

        $existing = ContentCommentLike::query()
            ->where('content_comment_id', $comment->id)
            ->where('liker_fingerprint', $fingerprint)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            ContentCommentLike::query()->create([
                'content_comment_id' => $comment->id,
                'user_id' => auth()->id(),
                'liker_fingerprint' => $fingerprint,
            ]);
            $liked = true;
        }

        $count = $comment->likes()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'count' => $count,
            ]);
        }

        return back()->withFragment('commentaires');
    }
}
