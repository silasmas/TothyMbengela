<?php

namespace App\Filament\Resources\PartnerCommitments;

use App\Filament\Resources\PartnerCommitments\Pages\CreatePartnerCommitment;
use App\Filament\Resources\PartnerCommitments\Pages\EditPartnerCommitment;
use App\Filament\Resources\PartnerCommitments\Pages\ListPartnerCommitments;
use App\Filament\Resources\PartnerCommitments\Schemas\PartnerCommitmentForm;
use App\Filament\Resources\PartnerCommitments\Tables\PartnerCommitmentsTable;
use App\Models\PartnerCommitment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class PartnerCommitmentResource extends Resource
{
    protected static ?string $model = PartnerCommitment::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static string|\UnitEnum|null $navigationGroup = 'Engagement';

    protected static ?int $navigationSort = 44;

    protected static ?string $modelLabel = 'partenariat';

    protected static ?string $pluralModelLabel = 'partenariats';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    public static function form(Schema $schema): Schema
    {
        return PartnerCommitmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnerCommitmentsTable::configure($table);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['payment_reference', 'user.name', 'user.email'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return 'Partenariat #'.$record->id;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return array_filter([
            'Partenaire' => $record->user?->name,
            'Statut' => $record->status,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartnerCommitments::route('/'),
            'create' => CreatePartnerCommitment::route('/create'),
            'edit' => EditPartnerCommitment::route('/{record}/edit'),
        ];
    }
}
