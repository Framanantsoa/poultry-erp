<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PaginatesAndSorts
{
    /**
     * Apply search, sort, and pagination to a query.
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @param  array    $searchable  Columns to search across
     * @param  string   $defaultSort
     * @param  string   $defaultDirection
     * @param  int      $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginateAndSort(
        Builder $query,
        Request $request,
        array $searchable = [],
        string $defaultSort = 'id',
        string $defaultDirection = 'desc',
        int $perPage = 15,
    ) {
        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($searchable, $search) {
                foreach ($searchable as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        // Sort
        $sort = $request->input('sort', $defaultSort);
        $direction = $request->input('direction', $defaultDirection);

        // Whitelist sortable columns
        if (in_array($sort, $searchable, true) || $sort === $defaultSort) {
            $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy($defaultSort, $defaultDirection);
        }

        // Paginate + preserve query string
        return $query->paginate($perPage)->withQueryString();
    }
}
