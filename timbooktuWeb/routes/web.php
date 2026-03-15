<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\FotografiePageController;
use App\Http\Controllers\GuestnetnoPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThoughtPageController;
use App\Models\Review;
use App\Models\RichUsMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index'])->name('page.index');

Route::view('/timbooktu', 'pages.timbooktu')->name('page.timbooktu');
Route::get('/tuiites', function () {
    return view('pages.tuiites', [
        'reviews' => Review::query()
            ->where('is_approved', true)
            ->latest()
            ->get(),
    ]);
})->name('page.tuiites');
Route::post('/tuiites/reviews', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255'],
        'location' => ['nullable', 'string', 'max:255'],
        'message' => ['required', 'string', 'max:5000'],
    ]);

    Review::query()->create([
        'name' => $validated['name'],
        'email' => $validated['email'] ?? null,
        'location' => $validated['location'] ?? null,
        'message' => $validated['message'],
        'is_approved' => false,
    ]);

    return redirect()
        ->route('page.tuiites')
        ->with('review_submitted', true);
})->name('page.tuiites.reviews.store');
Route::get('/lacomposmentis', [ThoughtPageController::class, 'index'])->name('page.lacomposmentis');
Route::get('/guestnetno', [GuestnetnoPageController::class, 'index'])->name('page.guestnetno');
Route::post('/guestnetno/posts', [GuestnetnoPageController::class, 'store'])->name('page.guestnetno.posts.store');
Route::get('/guestnetno/posts/{guestPost}', [GuestnetnoPageController::class, 'show'])->name('page.guestnetno.posts.show');
Route::get('/fotografie', [FotografiePageController::class, 'index'])->name('page.fotografie');
Route::get('/our-thing', function () {
    return view('pages.our-thing', [
        'ourThings' => \App\Models\OurThing::query()->latest()->paginate(12),
    ]);
})->name('page.our-thing');
Route::view('/rich-us', 'pages.rich-us')->name('page.rich-us');
Route::post('/rich-us/messages', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'message' => ['required', 'string', 'max:5000'],
        'attachment' => ['nullable', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,webp'],
    ]);

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $attachmentPath = Storage::disk('public')->putFile('uploads/rich-us', $request->file('attachment'));
    }

    RichUsMessage::query()->create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'message' => $validated['message'],
        'attachment_path' => $attachmentPath,
        'contacted_at' => null,
    ]);

    return redirect()
        ->route('page.rich-us')
        ->with('rich_us_submitted', true);
})->name('page.rich-us.messages.store');
Route::view('/shop', 'pages.shop')->name('page.shop');
Route::view('/blog', 'pages.blog')->name('page.blog');
Route::redirect('/blog-detail', '/lacomposmentis')->name('page.blog-detail');
Route::get('/blog-detail/{thought}', [ThoughtPageController::class, 'show'])->name('page.blog-detail.thought');
Route::post('/blog-detail/{thought}/comments', [ThoughtPageController::class, 'storeComment'])->name('page.blog-detail.thought.comments.store');

Route::get('/admin/login', [AdminAuthController::class, 'show'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function (): void {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/featured', [AdminDashboardController::class, 'featured'])->name('admin.featured');
    Route::get('/admin/thoughts', [AdminDashboardController::class, 'thoughts'])->name('admin.thoughts');
    Route::get('/admin/fotografie', [AdminDashboardController::class, 'fotografie'])->name('admin.fotografie');
    Route::get('/admin/comments', [AdminDashboardController::class, 'comments'])->name('admin.comments');
    Route::get('/admin/reviews', [AdminDashboardController::class, 'reviews'])->name('admin.reviews');
    Route::get('/admin/guestnetno', [AdminDashboardController::class, 'guestnetno'])->name('admin.guestnetno');
    Route::get('/admin/rich-us', [AdminDashboardController::class, 'richUs'])->name('admin.rich-us');
    Route::get('/admin/ourthing', [AdminDashboardController::class, 'ourThing'])->name('admin.ourthing');
    Route::post('/admin/featured', [AdminDashboardController::class, 'updateFeatured'])->name('admin.featured.update');
    Route::post('/admin/thoughts', [AdminDashboardController::class, 'createThought'])->name('admin.thoughts.create');
    Route::get('/admin/thoughts/{thought}/edit', [AdminDashboardController::class, 'editThought'])->name('admin.thoughts.edit');
    Route::put('/admin/thoughts/{thought}', [AdminDashboardController::class, 'updateThought'])->name('admin.thoughts.update');
    Route::delete('/admin/thoughts/{thought}', [AdminDashboardController::class, 'deleteThought'])->name('admin.thoughts.delete');
    Route::post('/admin/photographs', [AdminDashboardController::class, 'createPhotograph'])->name('admin.photographs.create');
    Route::get('/admin/photographs/{photograph}/edit', [AdminDashboardController::class, 'editPhotograph'])->name('admin.photographs.edit');
    Route::put('/admin/photographs/{photograph}', [AdminDashboardController::class, 'updatePhotograph'])->name('admin.photographs.update');
    Route::delete('/admin/photographs/{photograph}', [AdminDashboardController::class, 'deletePhotograph'])->name('admin.photographs.delete');
    Route::put('/admin/comments/{comment}/approve', [AdminDashboardController::class, 'approveComment'])->name('admin.comments.approve');
    Route::put('/admin/comments/{comment}/unapprove', [AdminDashboardController::class, 'unapproveComment'])->name('admin.comments.unapprove');
    Route::delete('/admin/comments/{comment}', [AdminDashboardController::class, 'deleteComment'])->name('admin.comments.delete');
    Route::put('/admin/reviews/{review}/approve', [AdminDashboardController::class, 'approveReview'])->name('admin.reviews.approve');
    Route::put('/admin/reviews/{review}/unapprove', [AdminDashboardController::class, 'unapproveReview'])->name('admin.reviews.unapprove');
    Route::delete('/admin/reviews/{review}', [AdminDashboardController::class, 'deleteReview'])->name('admin.reviews.delete');
    Route::put('/admin/rich-us/{richUsMessage}/toggle-contacted', [AdminDashboardController::class, 'toggleRichUsContacted'])->name('admin.rich-us.toggle-contacted');
    Route::delete('/admin/rich-us/{richUsMessage}', [AdminDashboardController::class, 'deleteRichUsMessage'])->name('admin.rich-us.delete');
    Route::put('/admin/guest-posts/{guestPost}/approve', [AdminDashboardController::class, 'approveGuestPost'])->name('admin.guest-posts.approve');
    Route::put('/admin/guest-posts/{guestPost}/unapprove', [AdminDashboardController::class, 'unapproveGuestPost'])->name('admin.guest-posts.unapprove');
    Route::delete('/admin/guest-posts/{guestPost}', [AdminDashboardController::class, 'deleteGuestPost'])->name('admin.guest-posts.delete');
    Route::post('/admin/ourthing', [AdminDashboardController::class, 'createOurThing'])->name('admin.ourthing.create');
    Route::get('/admin/ourthing/{ourThing}/edit', [AdminDashboardController::class, 'editOurThing'])->name('admin.ourthing.edit');
    Route::put('/admin/ourthing/{ourThing}', [AdminDashboardController::class, 'updateOurThing'])->name('admin.ourthing.update');
    Route::delete('/admin/ourthing/{ourThing}', [AdminDashboardController::class, 'deleteOurThing'])->name('admin.ourthing.delete');
});

Route::redirect('/index.html', '/', 301);
Route::redirect('/timbooktu.html', '/timbooktu', 301);
Route::redirect('/tuiites.html', '/tuiites', 301);
Route::redirect('/lacomposmentis.html', '/lacomposmentis', 301);
Route::redirect('/guestnetno.html', '/guestnetno', 301);
Route::redirect('/fotografie.html', '/fotografie', 301);
Route::redirect('/rich-us.html', '/rich-us', 301);
Route::redirect('/shop.html', '/shop', 301);
Route::redirect('/blog.html', '/blog', 301);
Route::redirect('/blog-detail.html', '/blog-detail', 301);
