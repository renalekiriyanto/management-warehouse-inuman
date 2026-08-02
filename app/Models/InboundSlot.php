<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Inbound;

#[Fillable(['inbound_id', 'slot_id', 'ata', 'qty_order'])]
class InboundSlot extends Model
{
    protected $table = 'inbound_slots';

    public function inbound()
    {
        return $this->belongsTo(Inbound::class, 'inbound_id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }
}
