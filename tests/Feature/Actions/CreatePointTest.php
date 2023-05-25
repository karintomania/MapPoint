<?php

namespace Tests\Feature\Actions;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Actions\CreatePoint;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreatePointTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_point_creates_a_point()
    {

        /** @var CreatePoint $createPoint */
        $createPoint = resolve(CreatePoint::class);
        $data = [
            'note' => 'test',
            'lat' => 10.0,
            'lng' => -11.0,
        ];

        $result = $createPoint($data);

        $this->assertEquals($data['note'], $result->note);
        $this->assertEquals($data['lat'], $result->lat);
        $this->assertEquals($data['lng'], $result->lng);
    }

    public function test_note_is_required()
    {

        /** @var CreatePoint $createPoint */
        $createPoint = resolve(CreatePoint::class);
        $data = [
            'note' => '',
            'lat' => 10.0,
            'lng' => -11.0,
        ];

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectExceptionMessage('The note field is required.');
        $createPoint($data);
    }

    /**
     * @dataProvider vaildationTestDataProvider
     */
    public function test_create_point_validates($data, $message)
    {
        $createPoint = resolve(CreatePoint::class);
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectExceptionMessage($message);
        $createPoint($data);
    }

    public function vaildationTestDataProvider()
    {
        return $array = [
            [ // note required
                [ // $data
                    'note' => '',
                    'lat' => 1.0,
                    'lng' => -11.0,
                ],
                'The note field is required.', // exception message
            ],
            [ // lat required
                [
                    'note' => 'test',
                    'lat' => '',
                    'lng' => -11.0,
                ],
                'The lat field is required.',
            ],
            [ // lng required
                [
                    'note' => 'test',
                    'lat' => 10,
                    'lng' => '',
                ],
                'The lng field is required.',
            ],
            [ // lat numeric
                [
                    'note' => 'test',
                    'lat' => 'string',
                    'lng' => -11.0,
                ],
                'The lat must be a number.',
            ],
            [ // lng numeric
                [
                    'note' => 'test',
                    'lat' => 1,
                    'lng' => 'string',
                ],
                'The lng must be a number.',
            ],
        ];
    }
}
