<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'first_time', 'last_time', 'cutoff_time'])]
class InboundGroup extends Model
{
    //
}
