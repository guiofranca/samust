<?php

namespace App\Filament\Resources\EquacaoResource\Pages;

use App\Filament\Resources\EquacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EquacaoResource\Widgets\GrafikinWidget;

class EditEquacao extends EditRecord
{
    protected static string $resource = EquacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GrafikinWidget::class,
        ];
    }
}
