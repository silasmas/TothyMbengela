<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AppointmentRequests\AppointmentRequestResource;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\Donations\DonationResource;
use App\Filament\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use App\Filament\Resources\PartnerCommitments\PartnerCommitmentResource;
use App\Models\AppointmentRequest;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\NewsletterSubscriber;
use App\Models\PartnerCommitment;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EngagementStatsWidget extends BaseWidget
{
    protected static ?int $sort = -8;

    protected ?string $heading = 'Engagement';

    protected ?string $description = 'Newsletter, messages, rendez-vous, dons et partenaires.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $unread = ContactMessage::query()->where('is_read', false)->count();
        $pendingRdv = AppointmentRequest::query()->where('status', 'pending')->count();
        $donationsCompleted = Donation::query()->where('status', 'completed')->count();
        $partnersActive = PartnerCommitment::query()->where('status', 'active')->count();

        return [
            Stat::make('Newsletter', NewsletterSubscriber::query()
                ->whereNotNull('verified_at')
                ->whereNull('unsubscribed_at')
                ->count())
                ->description('Inscrits confirmés')
                ->icon(Heroicon::OutlinedEnvelope)
                ->url(NewsletterSubscriberResource::getUrl()),
            Stat::make('Messages', ContactMessage::query()->count())
                ->description($unread > 0 ? $unread.' non lu'.($unread > 1 ? 's' : '') : 'Tous lus')
                ->icon(Heroicon::OutlinedChatBubbleLeft)
                ->url(ContactMessageResource::getUrl()),
            Stat::make('Rendez-vous', AppointmentRequest::query()->count())
                ->description($pendingRdv.' en attente')
                ->icon(Heroicon::OutlinedCalendar)
                ->url(AppointmentRequestResource::getUrl()),
            Stat::make('Dons', Donation::query()->count())
                ->description($donationsCompleted.' complété'.($donationsCompleted > 1 ? 's' : ''))
                ->icon(Heroicon::OutlinedBanknotes)
                ->url(DonationResource::getUrl()),
            Stat::make('Partenaires', PartnerCommitment::query()->count())
                ->description($partnersActive.' actif'.($partnersActive > 1 ? 's' : ''))
                ->icon(Heroicon::OutlinedHeart)
                ->url(PartnerCommitmentResource::getUrl()),
        ];
    }
}
