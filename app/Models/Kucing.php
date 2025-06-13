<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kucing extends Model
{
    /** @use HasFactory<\Database\Factories\KucingFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'name',
        'warna',
        'rating',
        'imageUrl'
    ];

    protected $primaryKey = "id_kucing";
}
