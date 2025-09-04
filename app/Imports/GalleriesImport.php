<?php

namespace App\Imports;

use App\Models\Gallery;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Eloquent\Model;

class GalleriesImport extends Importer
{
    public static function getModel(): string
    {
        return Gallery::class;
    }

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nom')->label('Nom'),
            ImportColumn::make('adresse')->label('Adresse'),
            ImportColumn::make('code_postal')->label('Code Postal'),
            ImportColumn::make('ville')->label('Ville'),
            ImportColumn::make('telephone')->label('Téléphone'),
            
            // CORRECTION DÉFINITIVE :
            // make() DOIT correspondre à l'en-tête du CSV.
            ImportColumn::make('adresse_email') 
                // On ajoute une transformation pour que Filament sache
                // que la colonne 'adresse_email' du CSV doit remplir
                // l'attribut 'email' du modèle.
                ->fillRecordUsing(function (Model $record, string $state): void {
                    $record->email = $state;
                }),

            ImportColumn::make('forme_juridique')->label('Forme Juridique'),
            ImportColumn::make('dirigeant')->label('Dirigeant'),
            ImportColumn::make('immatriculation')->label('Immatriculation'),
            ImportColumn::make('annee_ca')->label('Année CA'),
            ImportColumn::make('ca')->label('CA'),
            ImportColumn::make('resultat')->label('Résultat'),
            ImportColumn::make('effectif')->label('Effectif'),
            ImportColumn::make('naf_ape')->label('NAF APE'),
            ImportColumn::make('siret')->label('SIRET'),
            ImportColumn::make('effectif_min')->label('Effectif Min'),
            ImportColumn::make('effectif_max')->label('Effectif Max'),
        ];
    }
    
    public function resolveRecord(): ?Model
    {
        // On force la création de chaque ligne
        return null;
    }

    // Le reste ne change pas
    public function getValidationRules(): array
    {
        return [
            'siret' => ['nullable', 'digits:14'],
            'adresse_email' => ['nullable', 'email'],
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $successfulRows = $import->successful_rows;
        $body = 'Importation des galeries terminée. ';
        $body .= $successfulRows . ' ' . str('ligne')->plural($successfulRows) . ' importées avec succès.';
        if ($import->failed_rows > 0) {
            $body .= ' ' . $import->failed_rows . ' ' . str('ligne')->plural($import->failed_rows) . ' en échec.';
        }
        return $body;
    }
}