<?php

namespace App\Filament\Resources\EquacaoResource\Widgets;

use App\Models\Equacao;
use App\Servicos\CalculadorDeEquacao;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class GrafikinWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafikin';
    protected static string $resource = EquacaoResource::class;
    public ?Equacao $record = null;
    protected int | string | array $columnSpan = 2;
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $calculador = new CalculadorDeEquacao($this->record);
        $dados = $calculador->calcular($this->record, '2023-08-01', '2023-08-30');
        return [
            'datasets' => [
                [
                    'label' => "Dados de {$this->record->nome}",
                    'data' => $dados->map(fn($dado) => $dado->valor)->toArray(),
                ],
            ],
            'labels' => $dados->map(fn($dado) => Carbon::parse($dado->instante)->format('d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
