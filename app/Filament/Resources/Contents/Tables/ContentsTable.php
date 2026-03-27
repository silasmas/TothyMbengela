<?php

namespace App\Filament\Resources\Contents\Tables;

use App\Models\Content;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContentsTable
{
    public static function configureList(Table $table): Table
    {
        return static::baseTable($table)
            ->columns(static::listColumns())
            ->groups(static::seriesGroups())
            ->defaultGroup('series_id');
    }

    public static function configureGrid(Table $table): Table
    {
        return static::baseTable($table)
            ->columns(static::gridLayout())
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->groups(static::seriesGroups())
            ->defaultGroup('series_id');
    }

    /**
     * @return array<Group>
     */
    protected static function seriesGroups(): array
    {
        return [
            Group::make('series_id')
                ->label('Série')
                ->collapsible()
                ->titlePrefixedWithLabel(false)
                ->getTitleFromRecordUsing(
                    fn (Content $record): string => $record->series?->title ?? 'Sans série'
                ),
        ];
    }

    protected static function baseTable(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn (Builder $query) => $query->with(['series', 'rubrique', 'theme'])
            )
            ->filters([
                TrashedFilter::make()->label('Corbeille'),
            ])
            ->recordActions([
                EditAction::make()->label('Modifier'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Supprimer'),
                    ForceDeleteBulkAction::make()->label('Supprimer définitivement'),
                    RestoreBulkAction::make()->label('Restaurer'),
                ])->label('Actions groupées'),
            ]);
    }

    /**
     * @return array<Column>
     */
    protected static function listColumns(): array
    {
        return [
            ImageColumn::make('aperçu')
                ->label('Vignette')
                ->height(48)
                ->width(86)
                ->getStateUsing(fn (Content $record): ?string => $record->getThumbnailDisplayUrl())
                ->defaultImageUrl('https://placehold.co/120x68/e2e8f0/64748b?text=—')
                ->checkFileExistence(false),
            TextColumn::make('title')
                ->label('Titre')
                ->searchable()
                ->sortable()
                ->wrap(),
            TextColumn::make('rubrique.name')
                ->label('Rubrique')
                ->searchable()
                ->sortable(),
            TextColumn::make('series.title')
                ->label('Série')
                ->searchable()
                ->sortable()
                ->placeholder('—'),
            TextColumn::make('type')
                ->label('Type')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'video' => 'Vidéo',
                    'audio' => 'Audio',
                    'podcast' => 'Podcast',
                    'article' => 'Article',
                    default => $state,
                }),
            TextColumn::make('source')
                ->label('Source')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'internal' => 'Interne',
                    'youtube' => 'YouTube',
                    'external' => 'Externe',
                    default => $state,
                }),
            IconColumn::make('is_published')
                ->label('Publié')
                ->boolean(),
            TextColumn::make('published_at')
                ->label('Date de publication')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->placeholder('—'),
        ];
    }

    /**
     * Layout en cartes empilées pour la vue grille (nécessite ColumnLayoutComponent).
     *
     * @return array<Stack>
     */
    protected static function gridLayout(): array
    {
        return [
            Stack::make([
                ImageColumn::make('aperçu')
                    ->label('Vignette')
                    ->height(160)
                    ->width('100%')
                    ->getStateUsing(fn (Content $record): ?string => $record->getThumbnailDisplayUrl())
                    ->defaultImageUrl('https://placehold.co/320x180/e2e8f0/64748b?text=—')
                    ->checkFileExistence(false)
                    ->extraImgAttributes(['class' => 'w-full rounded-t-lg object-cover']),
                Stack::make([
                    TextColumn::make('title')
                        ->label('Titre')
                        ->searchable()
                        ->weight('bold')
                        ->size('md')
                        ->wrap(),
                    Split::make([
                        TextColumn::make('rubrique.name')
                            ->label('Rubrique')
                            ->size('sm')
                            ->color('gray')
                            ->grow(false),
                        TextColumn::make('type')
                            ->label('Type')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'video' => 'Vidéo',
                                'audio' => 'Audio',
                                'podcast' => 'Podcast',
                                'article' => 'Article',
                                default => $state,
                            })
                            ->grow(false),
                    ]),
                    Split::make([
                        TextColumn::make('source')
                            ->label('Source')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'internal' => 'Interne',
                                'youtube' => 'YouTube',
                                'external' => 'Externe',
                                default => $state,
                            })
                            ->grow(false),
                        IconColumn::make('is_published')
                            ->label('Publié')
                            ->boolean()
                            ->grow(false),
                        TextColumn::make('published_at')
                            ->label('Publication')
                            ->dateTime('d/m/Y')
                            ->size('sm')
                            ->placeholder('—')
                            ->grow(false),
                    ]),
                ])->space(2),
            ]),
        ];
    }
}
