<?php

namespace App\Services;

use App\Models\Batches\Batch;
use App\Services\ABS\BaseService;

class BatchService extends BaseService
{
    protected function modelClass(): string {
        return Batch::class;
    }
}
