<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geometri extends Model
{
    use HasFactory;

    protected $table = "geometri";
    public $timestamps = false;

    protected $fillable = [
        'geo_type',
        'coordinates',
        'id_sawah'
    ];

    public function sawah()
    {
        return $this->belongsTo(Sawah::class, 'id_akun');
    }
}
