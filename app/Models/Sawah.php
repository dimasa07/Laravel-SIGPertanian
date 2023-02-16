<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sawah extends Model
{
    use HasFactory;

    protected $table = "sawah";
    public $timestamps = false;

    protected $fillable = [
        'color',
        'owner',
        'crop',
        'area',
        'hamlet',
        'planting_date',
        'created_at'
    ];

    public function geometri()
    {
        return $this->hasOne(Geometri::class, 'id_sawah');
    }
}
