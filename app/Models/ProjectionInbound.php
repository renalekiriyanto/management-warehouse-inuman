<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['station_id', 'date', 'qty_projected'])]
class ProjectionInbound extends Model
{
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
