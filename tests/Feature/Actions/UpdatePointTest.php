<?php

namespace Tests\Feature\Actions;

use App\Actions\UpdatePoint;
use App\Models\Point;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdatePointTest extends TestCase
{
    use DatabaseMigrations;

    public function test_update_point_updates_a_point()
    {

        /**  @var UpdatePoint $updatePoint*/
        $updatePoint =  resolve(UpdatePoint::class);
        $point = Point::factory()->create();

        $data = [
            'note' => 'updated!'
        ];

        $updatePoint($data, $point);

        $updated = Point::find($point->id);

        $this->assertEquals($point->id, $updated->id);
        $this->assertEquals($data['note'], $updated->note);

    }

    public function test_note_is_required()
    {

        /**  @var UpdatePoint $updatePoint*/
        $updatePoint =  resolve(UpdatePoint::class);
        $point = Point::factory()->create();

        $data = [
            'note' => '',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The note field is required.');
        $updatePoint($data, $point);

    }
}