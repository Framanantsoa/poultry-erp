<?php

namespace App\Services\ABS;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    abstract protected function modelClass(): string;


    protected function query(): Builder {
        $modelClass = $this->modelClass();

        return $modelClass::query();
    }

    public function all(): Collection {
        return $this->query()->get();
    }

    public function find(int|string $id): ?Model {
        return $this->query()->find($id);
    }

    public function findOrFail(int|string $id): Model {
        return $this->query()->findOrFail($id);
    }

    public function create(array $data): Model {
        $modelClass = $this->modelClass();

        return $modelClass::create($data);
    }

    public function update(Model $model, array $data): Model {
        $model->update($data);

        return $model->refresh();
    }
}
