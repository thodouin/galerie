<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Informations Principales')
                ->schema([
                    TextInput::make('nom')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Adresse e-mail')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('telephone')
                        ->label('Téléphone')
                        ->tel()
                        ->maxLength(255),
                    TextInput::make('dirigeant')
                        ->maxLength(255),
                ])->columns(2),

            Section::make('Adresse')
                ->schema([
                    TextInput::make('adresse')
                        ->maxLength(255),
                    Grid::make()
                        ->schema([
                            TextInput::make('code_postal')
                                ->maxLength(255),
                            TextInput::make('ville')
                                ->maxLength(255),
                        ])
                ]),

            Section::make('Informations Légales & Financières')
                ->schema([
                    TextInput::make('siret')
                        ->maxLength(255),
                    TextInput::make('naf_ape')
                        ->label('Code NAF/APE')
                        ->maxLength(255),
                    TextInput::make('forme_juridique')
                        ->maxLength(255),
                    TextInput::make('immatriculation')
                        ->maxLength(255),
                    Grid::make(3)
                        ->schema([
                             TextInput::make('ca')
                                ->label('Chiffre d\'affaires (€)')
                                ->numeric(),
                             TextInput::make('resultat')
                                ->numeric(),
                             TextInput::make('annee_ca')
                                 ->label('Année du CA')
                                 ->numeric(),
                        ]),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->searchable() // Permet de rechercher sur ce champ
                    ->sortable(),  // Permet de trier par nom
                TextColumn::make('ville')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code_postal')
                    ->label('Code Postal')
                    ->searchable(),
                TextColumn::make('telephone')
                    ->label('Téléphone'),
                TextColumn::make('email')
                    ->label('E-mail'),
            ])
            ->filters([
                SelectFilter::make('ville')
                ->options(
                    // Récupère toutes les villes uniques de la base de données
                    \App\Models\Gallery::query()->distinct()->pluck('ville', 'ville')->all()
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
