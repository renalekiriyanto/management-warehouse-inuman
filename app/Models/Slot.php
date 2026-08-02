<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'eta', 'station_id'])]
class Slot extends Model
{
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
