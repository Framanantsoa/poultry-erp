<?php

namespace App\Services;

use App\Models\Log;

class LogService
{
    /**
     * @param string $actionName
     * @param int $userId
     * @param array|null $lastValue
     * @param array|null $newValue
     * @return void
     */
    public static function addAction(
        string $actionName,
        int $userId,
        ?array $lastValue = null,
        ?array $newValue = null
    ): void {
        Log::create([
            'action_name' => $actionName,
            'table_name' => 'users',
            'last_value' => $lastValue,
            'new_value' => $newValue,
            'user_id' => $userId,
        ]);
    }
}
