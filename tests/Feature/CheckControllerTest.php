<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckControllerTest extends TestCase
{
    private array $data;

    /**
     * Setting initial values.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        Artisan::call('migrate');
        Session::start();
        $this->data[] = ['id' => 1, 'name' => 'http://127.0.0.2:1', 'created_at' => now(), 'updated_at' => now()];
        $this->data[] = ['id' => 2, 'name' => 'http://' . strtolower(Str::random(rand(3, 20)) . '.' . Str::random(3)), 'created_at' => now(), 'updated_at' => now()];
        DB::table('urls')->insert($this->data);
    }

    /**
     * Test CheckController->check.
     *
     * @return void
     */
    public function testCheck()
    {
        // Тест выполнения проверки сайта с ошибкой соединения
        $response = $this->post(route('checks.store', ['url' => 1]), ['_token' => csrf_token()]);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('url_checks', ['url_id' => 1]);

        Http::fakeSequence()->push('<h1>Test</h1>')->push('Forbidden', 403);
        // Тест выполнения нормальной проверки сайта
        $response = $this->post(route('checks.store', ['url' => 2]), ['_token' => csrf_token()]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', ['url_id' => 2, 'h1' => 'Test']);

        // Тест выполнения проверки сайта с запретом доступа
        $response = $this->post(route('checks.store', ['url' => 2]), ['_token' => csrf_token()]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', ['url_id' => 2, 'status_code' => 403]);
    }
}
