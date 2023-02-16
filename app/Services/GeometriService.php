<?php

namespace App\Services;

use App\Models\Geometri;

class GeometriService{

    public function getAll()
    {
        return Geometri::all();
    }

    public function add(Geometri $geometri){
        return $geometri->save();
    }
}
