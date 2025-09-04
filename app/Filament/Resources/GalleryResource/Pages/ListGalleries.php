<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Imports\GalleriesImport; // <-- IMPORTANT : Importer notre classe d'import
use Filament\Actions;
use Filament\Actions\ImportAction; // <-- IMPORTANT : Importer l'action
use Filament\Resources\Pages\ListRecords;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // On ajoute l'action d'importation ici
            ImportAction::make()
                ->importer(GalleriesImport::class),

            // On conserve l'action de création qui était là par défaut
            Actions\CreateAction::make(),
        ];
    }
}