<?php

namespace App\Services;

use App\Models\Sequence;
use Illuminate\Support\Facades\DB;

class SequenceService
{
    /**
     * Get the next value for a given sequence key.
     * @param string $key
     * @return int
     */
    public function next(string $key): int {
        return DB::transaction(function () use ($key) {
            $sequence = Sequence::where('sequence_key', $key)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {
                $sequence = Sequence::create([
                    'sequence_key' => $key,
                    'current_value' => 1,
                ]);

                return $sequence->current_value;
            }

            $sequence->increment('current_value');
            $sequence->refresh();

            return $sequence->current_value;
        });
    }

    /**
     * Create a new sequence with a given key.
     * @param string $key
     * @param int $startValue
     * @return Sequence
     */
    public function create(string $key, int $startValue = 0): Sequence {
        return Sequence::create([
            'sequence_key' => $key,
            'current_value' => $startValue,
        ]);
    }

    /**
     * Get the current value of a sequence without incrementing it.
     * @param string $key
     * @return int|null
     */
    public function current(string $key): ?int {
        return Sequence::where('sequence_key', $key)->value('current_value');
    }

    /**
     * Reset a sequence to a given value.
     * @param string $key
     * @param int $value
     * @return bool
     */
    public function reset(string $key, int $value = 0): bool {
        return Sequence::where('sequence_key', $key)
            ->update(['current_value' => $value]) > 0;
    }
}
