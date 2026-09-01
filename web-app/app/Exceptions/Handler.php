<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     */
    // public function render($request, Throwable $e)
    // {
    //     $response = parent::render($request, $e);

    //     if ($e instanceof ValidationException) {
    //         // Return validation errors as Inertia props
    //         return back()->withErrors($e->errors())->withInput();
    //     }

    //     return $response;
    // }
}
