<?php

namespace App\Http\Controllers\Batches;

use App\Http\Controllers\Concerns\PaginatesAndSorts;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBreedRequest;
use App\Models\Batches\Breed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BreedController extends Controller
{
    use PaginatesAndSorts;

    public function index(Request $request): Response {
        $breeds = $this->paginateAndSort(
            query: Breed::query()->withCount('batches'),
            request: $request,
            searchable: ['name', 'code', 'description'],
            defaultSort: 'name',
            defaultDirection: 'asc',
            perPage: 15,
        );

        return Inertia::render('Breeds/Index', [
            'pagination' => $breeds,
            'filters' => [
                'search' => $request->input('search'),
                'sort' => $request->input('sort', 'name'),
                'direction' => $request->input('direction', 'asc'),
            ],
        ]);
    }


    public function create(): Response {
        return Inertia::render('Breeds/Create');
    }


    public function store(StoreBreedRequest $request): RedirectResponse {
        Breed::create($request->validated());

        return redirect()
            ->route('breeds.index')
            ->with('success', 'Breed created successfully.');
    }
}
