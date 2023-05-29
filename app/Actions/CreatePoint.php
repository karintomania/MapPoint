<?php

namespace App\Actions;

use App\Models\Point;
use Illuminate\Support\Facades\Validator;

class CreatePoint
{
    public function __invoke(array $data, int $userId): Point
    {
        $data['userId'] = $userId;

        $data = Validator::validate($data, [
            'userId' => 'required',
            'note' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $point = Point::create([
            'user_id' => $data['userId'],
            'note' => $data['note'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ]);

        return $point;
    }
}
