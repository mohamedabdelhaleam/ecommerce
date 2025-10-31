<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * Test that the home page route is accessible.
     */
    public function test_home_page_route_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that the home page route returns the correct view.
     */
    public function test_home_page_returns_correct_view(): void
    {
        $response = $this->get('/');

        $response->assertViewIs('website.home.index');
    }

}
