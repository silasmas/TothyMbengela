<?php

namespace App\Filament\Resources\Slides\Pages;

use App\Filament\Resources\Slides\SlideResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Création d’une slide.
 */
class CreateSlide extends CreateRecord
{
    protected static string $resource = SlideResource::class;
}
