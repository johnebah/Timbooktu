<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thought;
use Illuminate\Http\Request;

class ThoughtPageController extends Controller
{
    public function index()
    {
        return view('pages.lacomposmentis', [
            'thoughts' => Thought::query()
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->paginate(8),
        ]);
    }

    public function show(Thought $thought)
    {
        return view('pages.blog-detail', [
            'thought' => $thought,
            'comments' => $thought
                ->comments()
                ->where('is_approved', true)
                ->latest()
                ->get(),
        ]);
    }

    public function storeComment(Request $request, Thought $thought)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Comment::query()->create([
            'thought_id' => $thought->id,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'],
            'is_approved' => false,
        ]);

        return redirect()
            ->route('page.blog-detail.thought', $thought)
            ->with('comment_submitted', true);
    }
}
