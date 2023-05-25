<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Point;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use function Tonysm\TurboLaravel\dom_id;
use Tonysm\TurboLaravel\Testing\AssertableTurboStream;
use Tonysm\TurboLaravel\Testing\InteractsWithTurbo;

/**
 * to run the test
 * php artisan test ./tests/Feature/Http/Controllers/PointControllerTest.php
 */
class PointControllerTest extends TestCase
{
    use DatabaseMigrations;
    use InteractsWithTurbo;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @dataProvider getRouteProvider
     */
    public function test_routes_require_authentication(string $route, string $method, $requirePoint)
    {
        $parameters = ($requirePoint) ? ['point' => Point::factory()->create()] : [];

        $response = $this->$method(route($route, $parameters));

        // redirects to login
        $response->assertRedirect(route('login'));
    }

    public function getRouteProvider()
    {
        return [
            ['points.index', 'get', false],
            ['points.create', 'get', false],
            ['points.store', 'post', false],
            ['points.show', 'get', true],
            ['points.edit', 'get', true],
            ['points.update', 'put', true],
            ['points.destroy', 'delete', true],
        ];
    }

    public function test_index_shows_index()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertSeeInOrder([
            'point-create',
            'point-list',
        ]);
    }

    public function test_create_shows_create()
    {
        $response = $this->actingAs($this->user)->get(route('points.create'));

        $response->assertViewIs('points._create');
        $response->assertSee('point-create');
    }

    public function test_store_stores_a_point()
    {
        $data = [
            'note' => 'note test!!',
            'lat' => 10,
            'lng' => 20,
        ];
        $response = $this->actingAs($this->user)->post(route('points.store'), $data);

        $storedPoint = Point::first();

        $this->assertEquals(1, $storedPoint->user_id);
        $this->assertEquals($data['note'], $storedPoint->note);
        $this->assertEquals($data['lat'], $storedPoint->lat);
        $this->assertEquals($data['lng'], $storedPoint->lng);

        return compact('response', 'data');
    }

    /**
     * @depends test_store_stores_a_point
     */
    public function test_store_shows_created(array $result)
    {
        /** @var TestResponse $response */
        $response = $result['response'];
        $data = $result['data'];

        $response->assertOk();

        $response->assertTurboStream(
            fn (AssertableTurboStream $streams) => (
                $streams->has(2)
                ->hasTurboStream(fn ($stream) => (
                    $stream->where('target', 'point-list')
                    ->where('action', 'prepend')
                    ->see($data['note'])
                ))
                ->hasTurboStream(fn ($stream) => (
                    $stream->where('target', 'point-create')
                    ->where('action', 'replace')
                ))
            )
        );
    }

    public function test_edit_shows_edit()
    {
        $point = Point::factory()->create();

        $response = $this->actingAs($this->user)->get(route('points.edit', ['point' => $point]));

        $response->assertOk();
        $response->assertViewIs('points._edit');

        $response->assertViewHas('point', function ($pointInView) use ($point) {
            return $point->id === $pointInView->id;
        });
    }

    public function test_update_updates_point()
    {
        $point = Point::factory()->create();

        $data = [
            'note' => 'note updated.',
        ];

        $response = $this->actingAs($this->user)->patch(route('points.update', ['point' => $point]), $data);

        $updatedPoint = Point::find($point->id);

        $this->assertEquals($data['note'], $updatedPoint->note);

        return compact('response', 'data');
    }

    /**
     * @depends test_update_updates_point
     */
    public function test_update_shows_update(array $result)
    {
        $response = $result['response'];
        $data = $result['data'];

        $response->assertOk();
        $response->assertViewIs('points._show');
        $response->assertSee($data['note']);
    }

    public function test_delete_deltes_point()
    {
        $point = Point::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('points.destroy', ['point' => $point]));

        $response->assertStatus(200);
        $this->assertModelMissing($point);

        return compact('response', 'point');
    }

    /**
     * @depends test_delete_deltes_point
     */
    public function test_delete_shows_deleted(array $result)
    {
        $response = $result['response'];
        $point = $result['point'];

        $response->assertStatus(200);
        $response->assertTurboStream(
            fn (AssertableTurboStream $streams) => (
                $streams->has(1)
                ->hasTurboStream(fn ($stream) => (
                    $stream->where('target', dom_id($point))
                    ->where('action', 'remove')
                ))
            )
        );
    }
}
