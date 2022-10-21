<?php

namespace Tests\Feature;

use App\Models\Developer;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DeveloperTest extends TestCase
{

    use RefreshDatabase;


    public string $uri = "/api/v1/developers";


    /**
     * Listar desenvolvedores existentes - 200
     */
    public function test_list_developers(): void
    {
        $response = $this->get($this->uri);

        $response->assertStatus(200);
    }

    /**
     * Cadastrar um desenvolvedor - 201
     */
    public function test_create_developer_success(): void
    {
        $birth_date = "1992-03-28";
        $date = Carbon::create($birth_date);
        $age = $date->diffInYears(Carbon::now());
        $response = $this->create_developer("Dev", "M", $birth_date, "DJ");

        $this->assertDatabaseHas('developers', [
            "name" => "Dev",
            "gender" => "M",
            "birth_date" => $birth_date,
            "hobby" => "DJ",
            "age" => $age
        ]);

        $response->assertStatus(201);
    }

    /**
     * @param $name
     * @param $gender "F-Feminino ou M-Masculino"
     * @param $birth_date
     * @param $hobby
     * @return TestResponse
     */
    public function create_developer($name, $gender, $birth_date, $hobby): TestResponse
    {
        $level = Level::factory()->create();

        return $this->post($this->uri, [
            "level_id" => $level->id,
            "name" => $name,
            "gender" => $gender,
            "birth_date" => $birth_date,
            "hobby" => $hobby
        ]);
    }

    /**
     * Cadastrar um nível duplicado - 400
     */
    public function test_create_developer_with_duplicate_name(): void
    {
        $this->create_developer("Dev", "M", now()->format("Y-m-d"), "DJ");
        $response = $this->create_developer("Dev", "M", now()->format("Y-m-d"), "DJ");

        $response->assertStatus(400);
    }

    /**
     * Editar um desenvolvedor - 200
     */
    public function test_edit_a_developer()
    {

        $level = Level::factory()->create();

        $developer = Developer::factory()->create([
            'level_id' => $level->id
        ]);


        $developer_value = [
            "level_id" => $level->id,
            "name" => "Developer Edited",
            "gender" => "F",
            "birth_date" => now()->format("Y-m-d"),
            "hobby" => "Ler"
        ];

        $response = $this->put($this->uri . "/$developer->id", $developer_value);

        $this->assertDatabaseHas('developers', $developer_value);

        $response->assertStatus(200);
    }

    /**
     * Excluir um desenvolvedor - 204
     */
    public function test_delete_developer()
    {
        $level = Level::factory()->create();

        $developers = Developer::factory(5)->create([
            "level_id" => $level->id
        ]);

        $response = $this->delete($this->uri . "/".$developers[0]->id);

        $this->assertDatabaseCount('developers', 4);

        $response->assertStatus(204);
    }

    /**
     * Pesquisar um dev com query string
     */
    public function test_search_developer_with_query_string(): void
    {
        $level = Level::factory()->create();

        Developer::factory()->create([
            "level_id" => $level->id,
            "name" => "Developer"
        ]);

        $qs = http_build_query(["name" => "Developer"]);

        $response = $this->get("api/v1/developer/search?$qs");

        $response->assertStatus(200)->assertJson([
            "data" => [[
                "name" => "Developer"
            ]]
        ]);
    }


}
