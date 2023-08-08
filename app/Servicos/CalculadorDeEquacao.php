<?php

namespace App\Servicos;

use App\Models\Equacao;
use App\Models\Equacionavel;
use App\Models\Ponto;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class CalculadorDeEquacao
{
    public function __construct(public string $connection = 'mysql') {
        //
    }

    public function calcular(Equacao $equacao, $inicio, $fim)
    {
        try {
            $transactionNaoExiste = DB::connection($this->connection)->transactionLevel() == 0;
            if ($transactionNaoExiste) {
                DB::beginTransaction();
            }

            $equacao->loadMissing('equacionaveis.variavel');

            $datas = $this->validar_datas($inicio, $fim);
            $this->criar_tabela_temporaria($equacao);
            $this->popular_tabela_temporaria($equacao, $datas);

            $resultado = DB::connection($this->connection)->table($this->nome_tabela($equacao))->selectRaw("instante, {$equacao->formula} valor")->get();

        } catch (\Throwable $th) {
            throw $th;
        } finally {
            $this->destruir_tabela_temporaria($equacao);
            DB::rollBack();
            //DB::commit();
        }

        return $resultado;
    }

    private function popular_tabela_temporaria(Equacao $equacao, $datas)
    {
        $equacao->equacionaveis->each(function (Equacionavel $eq) use ($datas, $equacao) {
            $dados = $this->buscar_dados($eq, $datas);
            $dados = $dados->map(fn ($v) => ['instante' => $v->instante, $eq->nome => $v->valor])->toArray();
            DB::connection($this->connection)->table($this->nome_tabela($equacao))
                ->upsert($dados, ['instante'], [$eq->nome]);
        });
    }

    private function buscar_dados(Equacionavel $equacionavel, $datas)
    {
        if ($equacionavel->equacionavel instanceof Ponto) {
            return $equacionavel->equacionavel->medicoes()
                ->where('grandeza', $equacionavel->grandeza)
                ->whereBetween('instante', [$datas[0], $datas[1]])
                ->get();
        }

        if ($equacionavel->equacionavel instanceof Equacao) {
            if ($equacionavel->equacionavel->id == $equacionavel->equacao_id) throw new \Exception("Recursão infinita em {$equacionavel->nome}");
            return $this->calcular($equacionavel->equacionavel, $datas[0], $datas[1]);
        }
    }

    private function validar_datas($inicio, $fim)
    {
        $validator = Validator::make(['dataInicial' => $inicio, 'dataFinal' => $fim], [
            'dataInicial' => 'required|date',
            'dataFinal' => 'required|date',
        ]);

        if ($validator->invalid()) throw new \Exception($validator->messages());

        return [
            Carbon::parse($validator->validated()['dataInicial']),
            Carbon::parse($validator->validated()['dataFinal'])
        ];
    }

    private function criar_tabela_temporaria(Equacao $equacao)
    {
        Schema::connection($this->connection)->create($this->nome_tabela($equacao), function (Blueprint $table) use ($equacao) {
            $table->temporary();
            $table->timestamp('instante')->unique();
            foreach ($equacao->equacionaveis->pluck('nome') as $coluna) {
                $table->float($coluna)->nullable();
            }
        });
    }

    private function destruir_tabela_temporaria(Equacao $equacao)
    {
        $nome = $this->nome_tabela($equacao);
        Schema::connection($this->connection)->dropIfExists($nome);
    }

    private function nome_tabela(Equacao $equacao): string
    {
        return "continhas_da_equacao_{$equacao->id}";
    }
}
