<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\FeaturedPost;
use App\Models\GuestPost;
use App\Models\Photograph;
use App\Models\Review;
use App\Models\RichUsMessage;
use App\Models\Thought;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.featured');
    }

    public function featured(Request $request)
    {
        return $this->dashboardView($request, 'featured');
    }

    public function thoughts(Request $request)
    {
        return $this->dashboardView($request, 'thoughts');
    }

    public function fotografie(Request $request)
    {
        return $this->dashboardView($request, 'fotografie');
    }

    public function comments(Request $request)
    {
        return $this->dashboardView($request, 'comments');
    }

    public function reviews(Request $request)
    {
        return $this->dashboardView($request, 'reviews');
    }

    public function guestnetno(Request $request)
    {
        return $this->dashboardView($request, 'guestnetno');
    }

    public function richUs(Request $request)
    {
        return $this->dashboardView($request, 'richus');
    }

    private function dashboardView(Request $request, string $activeSection, ?Thought $editingThought = null, ?Photograph $editingPhotograph = null)
    {
        $activeSection = in_array($activeSection, ['featured', 'thoughts', 'fotografie', 'comments', 'reviews', 'guestnetno', 'richus'], true) ? $activeSection : 'featured';

        $featuredPost = FeaturedPost::query()->firstOrCreate([], [
            'title' => 'FEATURED POST',
            'subtitle' => 'The Way Life Goes.',
            'body' => '"It\'s a gradual process: the realization that you\'re moving through a world that\'s will turning even when you\'ve stopped a while ago."',
        ]);

        return view('admin.dashboard', [
            'activeSection' => $activeSection,
            'featuredPost' => $featuredPost,
            'thoughts' => Thought::query()->latest()->paginate(10)->withQueryString(),
            'photographs' => Photograph::query()->latest()->paginate(12)->withQueryString(),
            'comments' => Comment::query()->with('thought')->latest()->paginate(20)->withQueryString(),
            'reviews' => Review::query()->latest()->paginate(20)->withQueryString(),
            'guestPosts' => GuestPost::query()->latest()->paginate(20)->withQueryString(),
            'richUsMessages' => RichUsMessage::query()->latest()->paginate(20)->withQueryString(),
            'editingThought' => $editingThought,
            'editingPhotograph' => $editingPhotograph,
        ]);
    }

    public function updateFeatured(Request $request)
    {
        $featuredPost = FeaturedPost::query()->firstOrFail();

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'audio' => ['nullable', 'file', 'max:20480'],
        ]);

        if ($request->hasFile('image')) {
            if ($featuredPost->image_path) {
                Storage::disk('public')->delete($featuredPost->image_path);
            }

            $validated['image_path'] = Storage::disk('public')->putFile('uploads/featured', $request->file('image'));
        }

        if ($request->hasFile('audio')) {
            if ($featuredPost->audio_path) {
                Storage::disk('public')->delete($featuredPost->audio_path);
            }

            $validated['audio_path'] = Storage::disk('public')->putFile('uploads/featured', $request->file('audio'));
        }

        unset($validated['image'], $validated['audio']);

        $featuredPost->update($validated);

        return redirect()->route('admin.featured');
    }

    public function createThought(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
            'audio' => ['nullable', 'file', 'max:20480'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = Storage::disk('public')->putFile('uploads/thoughts', $request->file('image'));
        }

        if ($request->hasFile('audio')) {
            $validated['audio_path'] = Storage::disk('public')->putFile('uploads/thoughts', $request->file('audio'));
        }

        unset($validated['image'], $validated['audio']);

        Thought::query()->create($validated);

        return redirect()->route('admin.thoughts');
    }

    public function editThought(Request $request, Thought $thought)
    {
        return $this->dashboardView($request, 'thoughts', $thought);
    }

    public function updateThought(Request $request, Thought $thought)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
            'audio' => ['nullable', 'file', 'max:20480'],
        ]);

        if ($request->hasFile('image')) {
            if ($thought->image_path) {
                Storage::disk('public')->delete($thought->image_path);
            }

            $validated['image_path'] = Storage::disk('public')->putFile('uploads/thoughts', $request->file('image'));
        }

        if ($request->hasFile('audio')) {
            if ($thought->audio_path) {
                Storage::disk('public')->delete($thought->audio_path);
            }

            $validated['audio_path'] = Storage::disk('public')->putFile('uploads/thoughts', $request->file('audio'));
        }

        unset($validated['image'], $validated['audio']);

        $thought->update($validated);

        return redirect()->route('admin.thoughts');
    }

    public function deleteThought(Thought $thought)
    {
        if ($thought->image_path) {
            Storage::disk('public')->delete($thought->image_path);
        }

        if ($thought->audio_path) {
            Storage::disk('public')->delete($thought->audio_path);
        }

        $thought->delete();

        return redirect()->route('admin.thoughts');
    }

    public function createPhotograph(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:8192'],
        ]);

        $imagePath = Storage::disk('public')->putFile('uploads/fotografie', $request->file('image'));

        Photograph::query()->create([
            'title' => $validated['title'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.fotografie');
    }

    public function editPhotograph(Request $request, Photograph $photograph)
    {
        return $this->dashboardView($request, 'fotografie', null, $photograph);
    }

    public function updatePhotograph(Request $request, Photograph $photograph)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:8192'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($photograph->image_path);
            $validated['image_path'] = Storage::disk('public')->putFile('uploads/fotografie', $request->file('image'));
        }

        unset($validated['image']);

        $photograph->update($validated);

        return redirect()->route('admin.fotografie');
    }

    public function deletePhotograph(Photograph $photograph)
    {
        Storage::disk('public')->delete($photograph->image_path);

        $photograph->delete();

        return redirect()->route('admin.fotografie');
    }

    public function approveComment(Comment $comment)
    {
        $comment->update(['is_approved' => true]);

        return redirect()->back();
    }

    public function unapproveComment(Comment $comment)
    {
        $comment->update(['is_approved' => false]);

        return redirect()->back();
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();

        return redirect()->back();
    }

    public function approveReview(Review $review)
    {
        $review->update(['is_approved' => true]);

        return redirect()->back();
    }

    public function unapproveReview(Review $review)
    {
        $review->update(['is_approved' => false]);

        return redirect()->back();
    }

    public function deleteReview(Review $review)
    {
        $review->delete();

        return redirect()->back();
    }

    public function approveGuestPost(GuestPost $guestPost)
    {
        $guestPost->update(['is_approved' => true]);

        return redirect()->back();
    }

    public function unapproveGuestPost(GuestPost $guestPost)
    {
        $guestPost->update(['is_approved' => false]);

        return redirect()->back();
    }

    public function deleteGuestPost(GuestPost $guestPost)
    {
        $guestPost->delete();

        return redirect()->back();
    }

    public function toggleRichUsContacted(RichUsMessage $richUsMessage)
    {
        $richUsMessage->update([
            'contacted_at' => $richUsMessage->contacted_at ? null : now(),
        ]);

        return redirect()->back();
    }

    public function deleteRichUsMessage(RichUsMessage $richUsMessage)
    {
        if ($richUsMessage->attachment_path) {
            Storage::disk('public')->delete($richUsMessage->attachment_path);
        }

        $richUsMessage->delete();

        return redirect()->back();
    }
}
