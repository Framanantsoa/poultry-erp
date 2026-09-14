<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/** 
 * @property int $id
 * @property string $sequence_key
 * @property int $current_value
 */
#[Fillable(['sequence_key', 'current_value'])]
class Sequence extends Model
{
    /**
     * The attributes that should be guarded.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];
}
