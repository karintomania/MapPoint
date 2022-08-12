<?php

namespace App\Actions;

use App\Models\Point;
use Illuminate\Support\Facades\Validator;

class UpdatePoint{
    public function __invoke($data, Point $point){

        $data = Validator::validate($data, [
            'note' => 'required',
        ]);

        $point->note = $data['note'];
        $point->save();
        return $point;
    }
}