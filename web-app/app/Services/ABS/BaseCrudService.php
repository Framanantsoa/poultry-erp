<?php

namespace App\Services\ABS;

use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudService extends BaseService
{
    public function delete(Model $model): bool {
        return (bool) $model->delete();
    }
}
