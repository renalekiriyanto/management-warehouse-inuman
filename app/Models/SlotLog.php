<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['slot_id', 'old_data', 'new_data'])]
class SlotLog extends Model
{
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
