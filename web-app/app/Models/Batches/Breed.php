<?php

namespace App\Models\Batches;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property double $chick_cost
 * @property string|null $description
 */
class Breed extends Model
{
    protected $fillable = ['name', 'chick_cost', 'description'];

    protected function casts(): array {
        return [
            'chick_cost' => 'float',
        ];
    }

    public function batches() {
        return $this->hasMany(Batch::class);
    }
}
