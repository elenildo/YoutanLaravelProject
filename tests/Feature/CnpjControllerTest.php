<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Cnpj;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class CnpjControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_endpoint_get_cnpjs_by_cliente(): void
    {
        Cliente::factory(1)->create();

        $cliente = Cliente::find(1);

        $cliente->cnpj()->create([
            'cnpj' => '12021021454544',
            'filial' => 'Matriz',
            'ativo' => true
        ]);
        $cliente->cnpj()->create([
            'cnpj' => '1202102145453',
            'filial' => 'Matriz',
            'ativo' => true
        ]);
        
        $response = $this->get(route('adm.filiais.byCliente', $cliente->id));
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->get(route('adm.filiais.byCliente', $cliente->id));
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJson(function (AssertableJson $json) {
            $json->whereAllType([
                '0.id' => 'integer',
                '0.cnpj' => 'string'
            ]);
        });

        $response = $this->get(route('adm.filiais.byCliente', '999'));
        $response->assertStatus(200);
    }

    public function test_endpoint_post_cnpjs(): void
    {
        Cliente::factory(1)->create();
        $cliente = Cliente::find(1);
        $newCnpj = [
            'cnpj' => '12021021454544',
            'filial' => 'Matriz',
            'ativo' => true
        ];

        $response = $this->post(route('adm.filiais.store', $cliente->id), $newCnpj);
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->post(route('adm.filiais.store', $cliente->id), $newCnpj);
        $response->assertStatus(201);

        $response = $this->post(route('adm.filiais.store', $cliente->id), $newCnpj);
        $response->assertStatus(400);
    }

    public function test_endpoint_put_cnpjs(): void
    {
        Cliente::factory(1)->create();
        $cliente = Cliente::find(1);
        $newCnpj = [
            'cnpj' => '12021021454544',
            'filial' => 'Matriz',
            'ativo' => true
        ];

        $response = $this->actingAs($this->getUser())->post(route('adm.filiais.store', $cliente->id), $newCnpj);
        $response->assertStatus(201);

        $newCnpj['cnpj'] = '12021021454545';

        $response = $this->actingAs($this->getUser())->post(route('adm.filiais.store', $cliente->id), $newCnpj);
        $response->assertStatus(201);

        $cnpj1 = Cnpj::find(1);

        $response = $this->put(route('adm.filiais.edit', $cnpj1->id), $newCnpj);
        $response->assertStatus(400);

        $newCnpj['cnpj'] = '';

        $response = $this->put(route('adm.filiais.edit', $cnpj1->id), $newCnpj);
        $response->assertStatus(500);

    }

    private function getUser()
    {
        User::factory()->create();
        return User::find(1);
    }
}
