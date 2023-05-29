<?php

namespace Tests\Feature\Actions;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Actions\CreatePoint;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreatePointTest extends TestCase
{
    use DatabaseMigrations;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_create_point_creates_a_point()
    {

        /** @var CreatePoint $createPoint */
        $createPoint = resolve(CreatePoint::class);
        $data = [
            'note' => 'test',
            'lat' => 10.0,
            'lng' => -11.0,
        ];

        $result = $createPoint($data, $this->user->id);

        $this->assertEquals($this->user->id, $result->user_id);
        $this->assertEquals($data['note'], $result->note);
        $this->assertEquals($data['lat'], $result->lat);
        $this->assertEquals($data['lng'], $result->lng);
    }

    /**
     * @dataProvider vaildationTestDataProvider
     */
    public function test_create_point_validates($data, $userId, $message)
    {
        $createPoint = resolve(CreatePoint::class);
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectExceptionMessage($message);
        $createPoint($data, $userId);
    }

    public function vaildationTestDataProvider()
    {
        return $array = [
            'note is required' => [
                [ // $data
                    'note' => '',
                    'lat' => 1.0,
                    'lng' => -11.0,
                ],
                1,
                'The note field is required.', // exception message
            ],
            'lat is required' => [
                [
                    'note' => 'test',
                    'lat' => '',
                    'lng' => -11.0,
                ],
                1,
                'The lat field is required.',
            ],
            'lng is required' => [ // lng required
                [
                    'note' => 'test',
                    'lat' => 10,
                    'lng' => '',
                ],
                1,
                'The lng field is required.',
            ],
            'lat is numeric' => [ // lat numeric
                [
                    'note' => 'test',
                    'lat' => 'string',
                    'lng' => -11.0,
                ],
                1,
                'The lat must be a number.',
            ],
            'lng is numeric' => [
                [
                    'note' => 'test',
                    'lat' => 1,
                    'lng' => 'string',
                ],
                1,
                'The lng must be a number.',
            ],
        ];
    }
}
