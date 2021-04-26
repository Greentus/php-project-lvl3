<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * Test UrlController->index.
     *
     * @return void
     */
    public function testIndex()
    {
        // Тест отображения главной страницы
        $response = $this->get(route('home.index'));
        $response->assertOk();
        $response->assertSee('Анализатор страниц');
        $response->assertSee('Бесплатно проверяйте сайты на SEO пригодность');
    }
}
