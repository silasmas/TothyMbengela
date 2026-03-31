<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PastorActivity;
use Illuminate\View\View;

class PastorActivityController extends Controller
{
    public function index(): View
    {
        $todayActivities = PastorActivity::query()
            ->published()
            ->overlappingToday()
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();

        $upcomingActivities = PastorActivity::query()
            ->published()
            ->upcomingFromTomorrow()
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();

        $pastActivities = PastorActivity::query()
            ->published()
            ->pastCompleted()
            ->orderByRaw('COALESCE(ends_at, starts_at) DESC')
            ->orderBy('sort_order')
            ->get();

        return view('pages.pastor-activities.index', [
            'todayActivities' => $todayActivities,
            'upcomingActivities' => $upcomingActivities,
            'pastActivities' => $pastActivities,
            'title' => 'Agenda',
        ]);
    }

    public function show(PastorActivity $pastorActivity): View
    {
        abort_unless($pastorActivity->is_published, 404);

        $otherActivities = PastorActivity::query()
            ->published()
            ->whereKeyNot($pastorActivity->getKey())
            ->orderByRaw('COALESCE(ends_at, starts_at) DESC')
            ->limit(5)
            ->get();

        $pastorActivity->load([
            'galleryItems' => fn ($q) => $q->orderBy('sort_order')->orderBy('id'),
        ]);

        return view('pages.pastor-activities.show', [
            'activity' => $pastorActivity,
            'title' => $pastorActivity->title,
            'sidebarPastorActivities' => $otherActivities,
        ]);
    }
}
