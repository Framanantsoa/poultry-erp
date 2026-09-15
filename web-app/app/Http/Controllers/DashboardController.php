<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response {
        return Inertia::render('Dashboard', [
            'stats' => [
                'batches' => 12,
                'incubations' => 3,
                'eggsToday' => 1450,
                'mortalityToday' => 4,
            ],
            'activities' => [
                ['type'=>'create', 'message'=> 'Lorem IPSUM', 'time'=> 'yesterday'],
                ['type'=>'create', 'message'=> 'Lorem IPSUM', 'time'=> 'yesterday'],
                ['type'=>'delete', 'message'=> 'Lorem IPSUM', 'time'=> 'yesterday'],
                ['type'=>'update', 'message'=> 'Lorem IPSUM', 'time'=> 'yesterday'],
                ['type'=>'login', 'message'=> 'Lorem IPSUM', 'time'=> 'yesterday'],
            ],
        ]);
    }
}
