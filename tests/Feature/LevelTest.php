<?php

namespace Tests\Feature;

use App\Models\Developer;
use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LevelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    public string $base_url_levels = "/api/v1/levels";


    /**
     * Listar níveis existentes - 200
     */
    public function test_list_levels(): void
    {
        $response = $this->get($this->base_url_levels);

        $response->assertStatus(200);
    }

    /**
     * Cadastrar um nível - 201
     */
    public function test_create_level_success(): void
    {
        $response = $this->create_level("Level Teste");

        $this->assertDatabaseHas('levels', [
            'level' => 'Level Teste',
        ]);

        $response->assertStatus(201);
    }

    public function create_level($level): TestResponse
    {
        return $this->post($this->base_url_levels, [
            "level" => $level
        ]);
    }

    /**
     * Cadastrar um nível duplicado - 400
     */
    public function test_create_level_with_duplicate_name(): void
    {
        $this->create_level("Level Duplicado");
        $response = $this->create_level("Level Duplicado");

        $response->assertStatus(400);
    }

    /**
     * Cadastrar um nível sem descrição - 400
     */
    public function test_create_level_with_empty_name(): void
    {
        $response = $this->create_level("");

        $response->assertStatus(400);
    }

    /**
     * Cadastrar um nível com descrição curta - 400
     */
    public function test_create_level_with_name_up_to_two_characters(): void
    {
        $response = $this->create_level("LV");

        $response->assertStatus(400);
    }

    /**
     * Cadastrar um nível com descrição muito longa - 400
     */
    public function test_create_level_with_name_with_many_characters(): void
    {
        $response = $this->create_level("Nível de programadores com mais de trinta caracteres");

        $response->assertStatus(400);
    }

    /**
     * Editar um nível - 200
     */
    public function test_edit_a_level(): void
    {
        $level = Level::factory()->create();

        $response = $this->put($this->base_url_levels . "/$level->id", [
            "level" => "Senior"
        ]);

        $this->assertDatabaseHas('levels', [
            'id' => $level->id,
            'level' => 'Senior',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Editar um nível com descrição muito curta - 400
     */
    public function test_edit_a_level_with_small_value(): void
    {
        $level = Level::factory()->create([
            "level" => "Senior"
        ]);

        $response = $this->put($this->base_url_levels . "/$level->id", [
            "level" => "S"
        ]);

        $this->assertDatabaseHas('levels', [
            'id' => $level->id,
            'level' => 'Senior',
        ]);

        $response->assertStatus(400);
    }

    /**
     * Excluir um nível - 204
     */
    public function test_delete_nivel(): void
    {
        $level = Level::factory()->create();

        $response = $this->delete($this->base_url_levels . "/$level->id");

        $this->assertDatabaseCount('levels', 0);

        $response->assertStatus(204);
    }


    /**
     * Excluir um nível com vinculo de desenvolvedor - 501
     */
    public function test_delete_level_with_linked_developer(): void
    {
        $level = Level::factory()->create();
        Developer::factory(15)->create([
            "level_id" => $level->id
        ]);

        $response = $this->delete($this->base_url_levels . "/$level->id" );

        $response->assertStatus(501);
    }

    /**
     *Pesquisar um nivel com query string 200
     */
    public function test_search_level_with_query_string(): void
    {
        Level::factory()->create([
            "level" => "Senior"
        ]);

        $qs = http_build_query(["level" => "Senior"]);

        $response = $this->get("api/v1/level/search?$qs");

        $response->assertStatus(200)->assertJson([
            "data" => [[
                "level" => "Senior"
            ]]
        ]);
    }


}
