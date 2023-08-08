<?php

namespace App\Filament\Resources\RelatorioSamustResource\Pages;

use App\Filament\Resources\RelatorioSamustResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRelatorioSamust extends EditRecord
{
    protected static string $resource = RelatorioSamustResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
