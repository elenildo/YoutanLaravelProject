<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $razaoSocial = 'Coca Cola Company';
        Cliente::create([
            'razao_social' => $razaoSocial,
            'ativo' => true,
            'slug' => Str::slug($razaoSocial,'-')
        ]);
    }
}
