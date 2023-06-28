<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $lat
 * @property string $lng
 */
class Marker extends Model
{
    use HasFactory;

    protected $fillable = [
        'lat',
        'lng'
    ];
}
