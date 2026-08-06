<?php

namespace App\Filament\Resources\Slides;

use App\Filament\Resources\Slides\Pages\CreateSlide;
use App\Filament\Resources\Slides\Pages\EditSlide;
use App\Filament\Resources\Slides\Pages\ListSlides;
use App\Filament\Resources\Slides\Schemas\SlideForm;
use App\Filament\Resources\Slides\Tables\SlidesTable;
use App\Models\Slide;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Ressource Filament des slides du carrousel d’accueil.
 */
class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|\UnitEnum|null $navigationGroup = 'Site public';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'slide';

    protected static ?string $pluralModelLabel = 'slides';

    protected static ?string $navigationLabel = 'Slides';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    /**
     * Formulaire slide.
     *
     * @param  Schema  $schema  Schéma
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return SlideForm::configure($schema);
    }

    /**
     * Table slides.
     *
     * @param  Table  $table  Table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return SlidesTable::configure($table);
    }

    /**
     * Relations.
     *
     * @return array<int, mixed>
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Pages.
     *
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListSlides::route('/'),
            'create' => CreateSlide::route('/create'),
            'edit' => EditSlide::route('/{record}/edit'),
        ];
    }
}
