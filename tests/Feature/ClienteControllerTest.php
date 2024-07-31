<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_get_clientes(): void
    {
        $response = $this->get(route('adm.clientes'));
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->get(route('adm.clientes'));
        $response->assertStatus(200);
       
    }
    public function test_endpoint_get_clientes_by_slug(): void
    {
        Cliente::factory(1)->create();
        $cliente = Cliente::find(1);

        $response = $this->get(route('adm.cliente.findBySlug', $cliente->slug));
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->get(route('adm.cliente.findBySlug', $cliente->slug));
        $response->assertStatus(200);

        $response = $this->get("adm/clientes/find/one-strange-slug");
        $response->assertStatus(404);
    }
    public function test_endpoint_get_clientes_form(): void
    {
        $response = $this->get(route('adm.cliente.form'));
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->get(route('adm.cliente.form'));
        $response->assertStatus(200);
       
    }
    public function test_endpoint_post_clientes(): void
    {
        $newCliente = [
            'razao_social' => 'Nova empresa SA',
            'ativo' => true,
            'slug' => 'nova-empresa-sa'
        ];

        $response = $this->post(route('adm.cliente.store'), $newCliente);
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->post(route('adm.cliente.store'), $newCliente);
        $response->assertStatus(201);

    }

    public function test_endpoint_post_clientes_validation()
    {
        $newCliente = [
            'razao_social' => 'Nova empresa SA',
            'ativo' => true,
            'slug' => 'nova-empresa-sa'
        ];

        $response = $this->actingAs($this->getUser())->post(route('adm.cliente.store'), $newCliente);
        $response->assertStatus(201);

        $response = $this->post(route('adm.cliente.store'), $newCliente);
        $response->assertStatus(400);

        $newCliente['razao_social'] = '';

        $response = $this->post(route('adm.cliente.store'), $newCliente);
        $response->assertStatus(500);
    }

    public function test_endpoint_put_clientes(): void
    {
        Cliente::factory(2)->create();

        $cliente1 = Cliente::find(1);
        $cliente2 = Cliente::find(2);

        $cliente1['razao_social'] = 'Nome alterado';

        $response = $this->actingAs($this->getUser())->put(route('adm.cliente.edit', $cliente1->id), $cliente1->toArray());
        $response->assertStatus(200);

        $cliente1['razao_social'] = $cliente2->razao_social;

        $response = $this->put(route('adm.cliente.edit', $cliente1->id), $cliente1->toArray());
        $response->assertStatus(400);

        $cliente1['razao_social'] = '';

        $response = $this->put(route('adm.cliente.edit', $cliente1->id), $cliente1->toArray());
        $response->assertStatus(500);
    }

    public function test_endpoint_delete_clientes(): void
    {
        Cliente::factory(2)->create();

        $cliente1 = Cliente::find(1);

        $response = $this->delete(route('adm.cliente.delete', $cliente1->id));
        $response->assertStatus(302);

        $response = $this->actingAs($this->getUser())->delete(route('adm.cliente.delete', $cliente1->id));
        $response->assertStatus(200);

        $response = $this->actingAs($this->getUser())->delete(route('adm.cliente.delete', '999'));
        $response->assertStatus(404);
    }

    private function getUser()
    {
        User::factory()->create();
        return User::find(1);
    }
}
