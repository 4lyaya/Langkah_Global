<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    public function test_language_switch_to_english()
    {
        $response = $this->get('/language/en');

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
    }

    public function test_language_switch_to_indonesian()
    {
        $response = $this->get('/language/id');

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'id');
    }

    public function test_language_switch_to_chinese()
    {
        $response = $this->get('/language/zh');

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'zh');
    }

    public function test_unsupported_language_returns_error()
    {
        $response = $this->get('/language/fr');

        $response->assertStatus(400);
    }

    public function test_language_middleware_sets_correct_locale()
    {
        session()->put('locale', 'id');

        $response = $this->get('/');

        $this->assertEquals('id', app()->getLocale());
    }
}