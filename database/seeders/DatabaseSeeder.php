<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ponto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Guilherme',
            'email' => 'gui@hehe.com',
            'password' => Hash::make('123123123'),
        ]);

        $pontos = Ponto::factory(5)->create();
        $this->popular_medicoes($pontos);
    }

    public function popular_medicoes(Collection $pontos): void
    {
        DB::transaction(function () use ($pontos) {
            $dia = Carbon::parse('2023-08-01');
            $fim = Carbon::parse('2023-09-01');
            while($dia < $fim) {
                $pontos->each(fn (Ponto $ponto) => $ponto->medicoes()->create(['instante' => $dia, 'grandeza' => 'Energia', 'valor' => rand(-100,100)]));
                // $pontos->each(fn (Ponto $ponto) => $ponto->medicoes()->create(['instante' => $dia, 'grandeza' => 'Energia', 'valor' => $ponto->id]));
                $dia->addDay(1);
            }
        });
    }
}
