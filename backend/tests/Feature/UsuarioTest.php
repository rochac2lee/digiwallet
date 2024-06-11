<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
/** @test */
    public function only_logged_users_can_see_clients_list()
    {
        $response = $this->get('/clientes')
            ->assertRedirect('/auth/login');
    }
}
