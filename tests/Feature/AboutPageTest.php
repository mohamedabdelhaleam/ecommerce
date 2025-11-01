<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    /**
     * Test that the about page route is accessible.
     */
    public function test_about_page_route_is_accessible(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    /**
     * Test that the about page route returns the correct view.
     */
    public function test_about_page_returns_correct_view(): void
    {
        $response = $this->get('/about');

        $response->assertViewIs('website.about.index');
    }
}
