<?php

namespace App\Filament\Resources\EquacaoResource\Widgets;

use App\Models\Equacao;
use App\Models\Equacionavel;
use App\Servicos\CalculadorDeEquacao;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class GrafikinWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafikin';
    protected static string $resource = EquacaoResource::class;
    public ?Equacao $record = null;
    protected int | string | array $columnSpan = 2;
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $calculador = new CalculadorDeEquacao('soh_pra_calculinho');
        $dados = $calculador->calcular($this->record, '2023-08-01', '2023-08-30');
        $dadosDasVariaveis = [];

        $dadosDasVariaveis = $this->record->equacionaveis->map(fn (Equacionavel $eq) => [
            'label' => $eq->nome,
            'data' => Cache::pull("equacao_{$eq->equacao_id}_{$eq->equacionavel->id}")
                ->map(fn ($dado) => $dado->valor)->toArray(),
            'borderColor' => fake()->hexColor(),
            'tension' => 0.3,
        ]);
        return [
            'datasets' => [
                [
                    'label' => "Dados de {$this->record->nome}",
                    'data' => $dados->map(fn ($dado) => $dado->valor)->toArray(),
                    'borderWidth' => 5,
                    'tension' => 0.3,
                ],
                ...$dadosDasVariaveis,
            ],
            'labels' => $dados->map(fn ($dado) => Carbon::parse($dado->instante)->format('d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
