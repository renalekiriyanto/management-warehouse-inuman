<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['inbound_slot_id', 'ib_group_id'])]
class InboundCyrcle extends Model
{
    public function inboundSlot()
    {
        return $this->belongsTo(InboundSlot::class, 'inbound_slot_id');
    }

    public function inboundGroup()
    {
        return $this->belongsTo(InboundGroup::class, 'ib_group_id');
    }
}
