<?php

namespace App\Services;

use App\Models\Batches\Breed;
use App\Services\ABS\BaseService;

class BreedService extends BaseService
{
    protected function modelClass(): string {
        return Breed::class;
    }
}
