<?php

namespace App\Http\Controllers;

use App\Models\FeaturedPost;
use App\Models\Photograph;
use App\Models\Thought;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPost = FeaturedPost::query()->first();

        return view('pages.index', [
            'featuredPost' => $featuredPost,
            'thoughts' => Thought::query()
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->take(4)
                ->get(),
            'photographs' => Photograph::query()->latest()->take(6)->get(),
        ]);
    }
}
