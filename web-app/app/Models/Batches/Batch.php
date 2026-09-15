<?php

namespace App\Models\Batches;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property int $initial_effective
 * @property int $initial_age_in_weeks
 * @property Carbon $arrival_date
 * @property int $breed_id
 * @property double $total_cost
 * @property int $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Batch extends Model
{
    protected $fillable = ['code', 'initial_effective',
     'initial_age_in_weeks', 'arrival_date', 'breed_id', 'parent_id',
     'created_at', 'updated_at'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

}
