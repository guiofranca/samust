<?php

namespace App\Filament\Resources\RelatorioSamustResource\Pages;

use App\Filament\Resources\RelatorioSamustResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRelatorioSamusts extends ListRecords
{
    protected static string $resource = RelatorioSamustResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
