<?php

namespace App\Http\Controllers;

use App\Models\Photograph;

class FotografiePageController extends Controller
{
    public function index()
    {
        return view('pages.fotografie', [
            'photographs' => Photograph::query()->latest()->paginate(5),
        ]);
    }
}
