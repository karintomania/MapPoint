<?php

namespace App\Actions;

use App\Models\Point;
use Illuminate\Support\Facades\Validator;

class CreatePoint{

    public function __invoke(array $data): Point{

        $data = Validator::validate($data, [
            'note' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $point = Point::create([
            'user_id' => 1,
            'note' => $data['note'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ]);

        return $point;
    }
}