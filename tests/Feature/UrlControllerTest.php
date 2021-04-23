<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    private $data;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        Artisan::call('migrate');
        Session::start();
        $this->data = [];
        for ($i = 1; $i < 10; $i++) {
            $this->data[] = ['id' => $i, 'name' => 'http://' . strtolower(Str::random(rand(3, 20)) . '.' . Str::random(3)), 'created_at' => now()->subDays(rand(1, 365)), 'updated_at' => now()->subDays(rand(1, 365))];
        }
        DB::table('urls')->insert($this->data);
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
        foreach ($this->data as $url) {
            $response->assertSee($url['name']);
        }
    }

    public function testStore()
    {
        $url_good = 'http://test.store';
        $response = $this->post(route('urls.store'), ['_token' => csrf_token(), 'url' => ['name' => $url_good]]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', ['name' => $url_good]);

        $response = $this->post(route('urls.store'), ['_token' => csrf_token(), 'url' => ['name' => $url_good]]);
        $response->assertSessionHasErrors();
        $response->assertRedirect();

        $url_bad = 'ftp://test.store';
        $response = $this->post(route('urls.store'), ['_token' => csrf_token(), 'url' => ['name' => $url_bad]]);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('urls', ['name' => $url_bad]);
    }

    public function testShow()
    {
        foreach ($this->data as $url) {
            $response = $this->get(route('urls.show', ['url' => $url['id']]));
            $response->assertOk();
            $response->assertSee($url['name']);
        }
    }

    public function testCheck()
    {
        foreach ($this->data as $url) {
            $response = $this->post(route('urls.check', ['url' => $url['id']]), ['_token' => csrf_token()]);
            $response->assertSessionHasNoErrors();
            $response->assertRedirect();
            $this->assertDatabaseHas('url_checks', ['url_id' => $url['id']]);
        }
    }
}
