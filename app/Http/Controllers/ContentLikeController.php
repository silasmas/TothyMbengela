<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentLikeController extends Controller
{
    public function toggle(Request $request, string $slug): JsonResponse
    {
        $content = Content::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $user = $request->user();

        $existing = ContentLike::query()
            ->where('content_id', $content->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            ContentLike::query()->create([
                'content_id' => $content->id,
                'user_id' => $user->id,
            ]);
            $liked = true;
        }

        $count = ContentLike::query()->where('content_id', $content->id)->count();

        return response()->json([
            'liked' => $liked,
            'count' => $count,
        ]);
    }
}
