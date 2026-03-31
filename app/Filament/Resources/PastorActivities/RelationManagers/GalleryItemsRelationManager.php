<?php

namespace App\Filament\Resources\PastorActivities\RelationManagers;

use App\Models\PastorActivityGalleryItem;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class GalleryItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'galleryItems';

    protected static ?string $title = 'Galerie (après l’événement)';

    protected static ?string $recordTitleAttribute = 'caption';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('type')
                    ->label('Type')
                    ->options([
                        PastorActivityGalleryItem::TYPE_IMAGE => 'Photo',
                        PastorActivityGalleryItem::TYPE_VIDEO => 'Vidéo courte',
                    ])
                    ->required()
                    ->default(PastorActivityGalleryItem::TYPE_IMAGE)
                    ->live()
                    ->columnSpanFull(),
                FileUpload::make('file_path')
                    ->label(fn (Get $get) => ($get('type') === PastorActivityGalleryItem::TYPE_VIDEO)
                        ? 'Fichier vidéo (MP4, WebM…)'
                        : 'Fichier image')
                    ->disk('public')
                    ->directory(fn (Get $get) => ($get('type') === PastorActivityGalleryItem::TYPE_VIDEO)
                        ? 'pastor-activities/gallery-videos'
                        : 'pastor-activities/gallery')
                    ->visibility('public')
                    ->image(fn (Get $get) => ($get('type') ?? PastorActivityGalleryItem::TYPE_IMAGE) === PastorActivityGalleryItem::TYPE_IMAGE)
                    ->acceptedFileTypes(fn (Get $get) => ($get('type') ?? PastorActivityGalleryItem::TYPE_IMAGE) === PastorActivityGalleryItem::TYPE_VIDEO
                        ? ['video/mp4', 'video/webm', 'video/quicktime']
                        : ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->maxSize(102400)
                    ->helperText('Vidéo : fichier court ou laissez vide si vous utilisez uniquement le lien YouTube ci-dessous.')
                    ->nullable()
                    ->columnSpanFull(),
                TextInput::make('external_url')
                    ->label('Lien vidéo (YouTube)')
                    ->url()
                    ->maxLength(2048)
                    ->visible(fn (Get $get) => $get('type') === PastorActivityGalleryItem::TYPE_VIDEO)
                    ->helperText('Optionnel : shorts, youtu.be ou lien watch?v=')
                    ->columnSpanFull(),
                Textarea::make('caption')
                    ->label('Légende')
                    ->maxLength(512)
                    ->rows(2)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->alignCenter(),
                ImageColumn::make('file_path')
                    ->label('Aperçu')
                    ->disk('public')
                    ->height(48)
                    ->checkFileExistence(false),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        PastorActivityGalleryItem::TYPE_VIDEO => 'Vidéo',
                        default => 'Photo',
                    }),
                TextColumn::make('caption')
                    ->label('Légende')
                    ->limit(40)
                    ->placeholder('—'),
                TextColumn::make('external_url')
                    ->label('Lien')
                    ->limit(24)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => $this->validatedGalleryData($data)),
            ])
            ->actions([
                EditAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => $this->validatedGalleryData($data)),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('sort_order');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function validatedGalleryData(array $data): array
    {
        $type = $data['type'] ?? PastorActivityGalleryItem::TYPE_IMAGE;
        $hasFile = filled($data['file_path'] ?? null);
        $hasUrl = filled($data['external_url'] ?? null);

        if ($type === PastorActivityGalleryItem::TYPE_IMAGE && ! $hasFile) {
            throw ValidationException::withMessages([
                'file_path' => 'Ajoutez un fichier image.',
            ]);
        }

        if ($type === PastorActivityGalleryItem::TYPE_VIDEO && ! $hasFile && ! $hasUrl) {
            throw ValidationException::withMessages([
                'file_path' => 'Pour une vidéo, ajoutez un fichier ou un lien YouTube.',
            ]);
        }

        if ($type === PastorActivityGalleryItem::TYPE_IMAGE) {
            $data['external_url'] = null;
        }

        return $data;
    }
}
