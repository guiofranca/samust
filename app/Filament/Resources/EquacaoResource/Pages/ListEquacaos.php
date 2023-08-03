<?php

namespace App\Filament\Resources\EquacaoResource\Pages;

use App\Filament\Resources\EquacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquacaos extends ListRecords
{
    protected static string $resource = EquacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
