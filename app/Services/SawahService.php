<?php

namespace App\Services;

use App\Models\Sawah;

class SawahService
{

    public function getAll()
    {
        return Sawah::all();
    }

    public function add(Sawah $sawah)
    {
        return $sawah->save();
    }

    public function getById($id)
    {
        return Sawah::where('id', '=', $id)->first();
    }

    public function update($id, $attributes = [])
    {
        return $this->getById($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }
}
