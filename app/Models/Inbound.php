<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['projection_inbound_id', 'date'])]
class Inbound extends Model
{
    public function projectionInbound()
    {
        return $this->belongsTo(ProjectionInbound::class, 'projection_inbound_id');
    }
}
