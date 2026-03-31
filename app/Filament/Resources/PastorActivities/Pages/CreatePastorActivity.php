<?php

namespace App\Filament\Resources\PastorActivities\Pages;

use App\Filament\Resources\PastorActivities\PastorActivityResource;
use App\Models\PastorActivity;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePastorActivity extends CreateRecord
{
    protected static string $resource = PastorActivityResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $title = isset($data['title']) ? (string) $data['title'] : '';
        $slugInput = isset($data['slug']) ? trim((string) $data['slug']) : '';

        if ($slugInput === '' && $title !== '') {
            $base = Str::slug($title);
            $slug = $base;
            $n = 0;
            while (PastorActivity::query()->where('slug', $slug)->exists()) {
                $n++;
                $slug = $base.'-'.$n;
            }
            $data['slug'] = $slug;
        }

        return $data;
    }
}
