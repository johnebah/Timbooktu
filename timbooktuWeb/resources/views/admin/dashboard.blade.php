@extends('layouts.app')

@section('title', 'Admin - TIIMBOOKTU')

@php
  $featuredImageUrl = $featuredPost->image_path ? asset($featuredPost->image_path) : asset('img/abt.jpeg');
  $featuredAudioUrl = $featuredPost->audio_path ? asset($featuredPost->audio_path) : null;
@endphp

@push('styles')
  <style>
    .tox-tinymce {
      border-radius: 8px !important;
      border: 1px solid #3E3E3A !important;
    }
    @media (max-width: 768px) {
      .tox-tinymce {
        height: 350px !important;
      }
    }
  </style>
@endpush


@push('scripts')
  <script src="https://cdn.tiny.cloud/1/cqgpe4qmv55yhh32rm6wr4x1s1062rw0p5kjobcooaf6ytt0/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      tinymce.init({
        selector: '.tinymce-editor',
        license_key: 'gpl',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 400,
        menubar: false,
        content_style: 'body { font-family: "Inter", sans-serif; font-size:16px; background-color: #1b1b18; color: #fff; }',
        skin: 'oxide-dark',
        content_css: 'dark',
        mobile: {
          menubar: false,
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
          toolbar_mode: 'sliding',
          height: 350
        }
      });


      // Handle file size validation
      const maxImageSize = 4 * 1024 * 1024; // 4MB
      const maxAudioSize = 20 * 1024 * 1024; // 20MB
      const maxGenericSize = 10 * 1024 * 1024; // 10MB default

      document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
          if (!this.files || this.files.length === 0) return;
          
          const file = this.files[0];
          const accept = this.getAttribute('accept') || '';
          const isAudio = accept.includes('audio');
          const isImage = accept.includes('image');
          
          if (isImage && file.size > maxImageSize) {
            alert('Image size exceeds the 4MB limit. Please select a smaller file.');
            this.value = '';
          } else if (isAudio && file.size > maxAudioSize) {
            alert('Audio size exceeds the 20MB limit. Please select a smaller file.');
            this.value = '';
          } else if (!isImage && !isAudio && file.size > maxGenericSize) {
            alert('File size exceeds the limit. Please select a smaller file.');
            this.value = '';
          }
        });
      });
    });
  </script>
@endpush


@section('content')
  <section class="rich-us-section">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="rich-us-title">ADMIN</h1>
          <p class="rich-us-subtitle">Manage featured post, thoughts, and fotografie.</p>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="read-more-pill">LOG OUT</button>
        </form>
      </div>

      <div class="d-flex flex-wrap gap-2 mb-4">
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'featured') active @endif" href="{{ route('admin.featured') }}">FEATURED</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'thoughts') active @endif" href="{{ route('admin.thoughts') }}">THOUGHTS</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'fotografie') active @endif" href="{{ route('admin.fotografie') }}">FOTOGRAFIE</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'comments') active @endif" href="{{ route('admin.comments') }}">COMMENTS</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'reviews') active @endif" href="{{ route('admin.reviews') }}">REVIEWS</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'richus') active @endif" href="{{ route('admin.rich-us') }}">RICH US</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'guestnetno') active @endif" href="{{ route('admin.guestnetno') }}">GUEST CONTENT</a>
        <a class="read-more-pill @if (($activeSection ?? 'featured') === 'ourthing') active @endif" href="{{ route('admin.ourthing') }}">OUR THING</a>
      </div>

      @if (($activeSection ?? 'featured') === 'featured')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">FEATURED POST</h2>
          <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-5">
              <img src="{{ $featuredImageUrl }}" alt="Featured image" class="img-fluid rounded">
              @if ($featuredAudioUrl)
                <div class="audio-player-container mt-3">
                  <audio class="w-100" controls preload="metadata">
                    <source src="{{ $featuredAudioUrl }}" />
                  </audio>
                </div>
              @endif
            </div>
            <div class="col-12 col-lg-7">
              <form class="rich-us-form" method="POST" action="{{ route('admin.featured.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                  <label for="featured_title" class="form-label text-white">Title</label>
                  <input type="text" class="form-control" id="featured_title" name="title" value="{{ old('title', $featuredPost->title) }}">
                </div>
                <div class="mb-4">
                  <label for="featured_subtitle" class="form-label text-white">Subtitle</label>
                  <input type="text" class="form-control" id="featured_subtitle" name="subtitle" value="{{ old('subtitle', $featuredPost->subtitle) }}">
                </div>
                <div class="mb-4">
                  <label for="featured_body" class="form-label text-white">Text</label>
                  <textarea id="featured_body" name="body" class="form-control tinymce-editor" rows="10">{{ old('body', $featuredPost->body) }}</textarea>
                </div>

                <div class="mb-4">
                  <label for="featured_image" class="form-label text-white">Image</label>
                  <input type="file" class="form-control" id="featured_image" name="image" accept="image/*">
                </div>
                <div class="mb-4">
                  <label for="featured_audio" class="form-label text-white">Audio</label>
                  <input type="file" class="form-control" id="featured_audio" name="audio" accept="audio/*">
                </div>
                <button type="submit" class="rich-us-submit-btn">UPDATE FEATURED</button>
              </form>
            </div>
          </div>
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'thoughts')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">THOUGHTS</h2>
          @if (isset($editingThought) && $editingThought)
            <div class="mb-4 p-3 border border-secondary rounded">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0 text-white">Edit Thought</h3>
                <a class="read-more-pill" href="{{ route('admin.thoughts') }}">CANCEL</a>
              </div>
              <form class="rich-us-form" method="POST" action="{{ route('admin.thoughts.update', $editingThought) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                  <div class="col-12 col-lg-6">
                    <label for="thought_edit_title" class="form-label text-white">Title</label>
                    <input type="text" class="form-control" id="thought_edit_title" name="title" value="{{ old('title', $editingThought->title) }}" required>
                  </div>
                  <div class="col-12 col-lg-6">
                    <label for="thought_edit_published_at" class="form-label text-white">Published At</label>
                    <input type="date" class="form-control" id="thought_edit_published_at" name="published_at" value="{{ old('published_at', optional($editingThought->published_at)->format('Y-m-d')) }}">
                  </div>
                  <div class="col-12">
                    <label for="thought_edit_excerpt" class="form-label text-white">Excerpt</label>
                    <textarea id="thought_edit_excerpt" name="excerpt" class="form-control tinymce-editor" rows="4">{{ old('excerpt', $editingThought->excerpt) }}</textarea>
                  </div>
                  <div class="col-12">
                    <label for="thought_edit_body" class="form-label text-white">Body</label>
                    <textarea id="thought_edit_body" name="body" class="form-control tinymce-editor" rows="10">{{ old('body', $editingThought->body) }}</textarea>
                  </div>

                  <div class="col-12 col-lg-6">
                    <label for="thought_edit_image" class="form-label text-white">Image</label>
                    <input type="file" class="form-control" id="thought_edit_image" name="image" accept="image/*">
                    @if ($editingThought->image_path)
                      <div class="small text-white-50 mt-2">{{ $editingThought->image_path }}</div>
                    @endif
                  </div>
                  <div class="col-12 col-lg-6">
                    <label for="thought_edit_audio" class="form-label text-white">Audio</label>
                    <input type="file" class="form-control" id="thought_edit_audio" name="audio" accept="audio/*">
                    @if ($editingThought->audio_path)
                      <div class="small text-white-50 mt-2">{{ $editingThought->audio_path }}</div>
                    @endif
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="rich-us-submit-btn">UPDATE THOUGHT</button>
                </div>
              </form>
            </div>
          @endif

          <form class="rich-us-form mb-4" method="POST" action="{{ route('admin.thoughts.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-12 col-lg-6">
                <label for="thought_title" class="form-label text-white">Title</label>
                <input type="text" class="form-control" id="thought_title" name="title" value="{{ old('title') }}" required>
              </div>
              <div class="col-12 col-lg-6">
                <label for="thought_published_at" class="form-label text-white">Published At</label>
                <input type="date" class="form-control" id="thought_published_at" name="published_at" value="{{ old('published_at') }}">
              </div>
              <div class="col-12">
                <label for="thought_excerpt" class="form-label text-white">Excerpt</label>
                <textarea id="thought_excerpt" name="excerpt" class="form-control tinymce-editor" rows="4">{{ old('excerpt') }}</textarea>
              </div>
              <div class="col-12">
                <label for="thought_body" class="form-label text-white">Body</label>
                <textarea id="thought_body" name="body" class="form-control tinymce-editor" rows="10">{{ old('body') }}</textarea>
              </div>

              <div class="col-12">
                <label for="thought_image" class="form-label text-white">Image</label>
                <input type="file" class="form-control" id="thought_image" name="image" accept="image/*">
              </div>
              <div class="col-12">
                <label for="thought_audio" class="form-label text-white">Audio</label>
                <input type="file" class="form-control" id="thought_audio" name="audio" accept="audio/*">
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="rich-us-submit-btn">ADD THOUGHT</button>
            </div>
          </form>

          <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Published</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($thoughts as $thought)
                  <tr>
                    <td>{{ $thought->title }}</td>
                    <td>{{ optional($thought->published_at)->format('Y-m-d') }}</td>
                    <td class="text-end">
                      <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                        <a class="read-more-pill" href="{{ route('admin.thoughts.edit', $thought) }}">EDIT</a>
                        <form method="POST" action="{{ route('admin.thoughts.delete', $thought) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="read-more-pill">DELETE</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($thoughts->lastPage() > 1)
            @php
              $current = $thoughts->currentPage();
              $last = $thoughts->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $thoughts->previousPageUrl()) disabled @endif" href="{{ $thoughts->previousPageUrl() ?: '#' }}" tabindex="@if (! $thoughts->previousPageUrl()) -1 @endif" aria-disabled="@if (! $thoughts->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $thoughts->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $thoughts->nextPageUrl()) disabled @endif" href="{{ $thoughts->nextPageUrl() ?: '#' }}" tabindex="@if (! $thoughts->nextPageUrl()) -1 @endif" aria-disabled="@if (! $thoughts->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'fotografie')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">FOTOGRAFIE</h2>
          @if (isset($editingPhotograph) && $editingPhotograph)
            <div class="mb-4 p-3 border border-secondary rounded">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0 text-white">Edit Photo</h3>
                <a class="read-more-pill" href="{{ route('admin.fotografie') }}">CANCEL</a>
              </div>
              <div class="mb-3">
                <img src="{{ asset($editingPhotograph->image_path) }}" class="img-fluid rounded" alt="Photo">
              </div>
              <form class="rich-us-form" method="POST" action="{{ route('admin.photographs.update', $editingPhotograph) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                  <div class="col-12 col-lg-6">
                    <label for="photo_edit_title" class="form-label text-white">Title</label>
                    <input type="text" class="form-control" id="photo_edit_title" name="title" value="{{ old('title', $editingPhotograph->title) }}">
                  </div>
                  <div class="col-12 col-lg-6">
                    <label for="photo_edit_image" class="form-label text-white">Replace Image</label>
                    <input type="file" class="form-control" id="photo_edit_image" name="image" accept="image/*">
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="rich-us-submit-btn">UPDATE PHOTO</button>
                </div>
              </form>
            </div>
          @endif

          <form class="rich-us-form mb-4" method="POST" action="{{ route('admin.photographs.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-12 col-lg-6">
                <label for="photo_title" class="form-label text-white">Title</label>
                <input type="text" class="form-control" id="photo_title" name="title" value="{{ old('title') }}">
              </div>
              <div class="col-12 col-lg-6">
                <label for="photo_image" class="form-label text-white">Image</label>
                <input type="file" class="form-control" id="photo_image" name="image" accept="image/*" required>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="rich-us-submit-btn">UPLOAD PHOTO</button>
            </div>
          </form>

          <div class="row g-3">
            @foreach ($photographs as $photo)
              <div class="col-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary h-100">
                  <img src="{{ asset($photo->image_path) }}" class="card-img-top" alt="Photo">
                  <div class="card-body">
                    <div class="small text-white-50 mb-2">{{ $photo->title }}</div>
                    <div class="d-grid gap-2">
                      <a class="read-more-pill w-100 text-center" href="{{ route('admin.photographs.edit', $photo) }}">EDIT</a>
                      <form method="POST" action="{{ route('admin.photographs.delete', $photo) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="read-more-pill w-100">DELETE</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          @if ($photographs->lastPage() > 1)
            @php
              $current = $photographs->currentPage();
              $last = $photographs->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $photographs->previousPageUrl()) disabled @endif" href="{{ $photographs->previousPageUrl() ?: '#' }}" tabindex="@if (! $photographs->previousPageUrl()) -1 @endif" aria-disabled="@if (! $photographs->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $photographs->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $photographs->nextPageUrl()) disabled @endif" href="{{ $photographs->nextPageUrl() ?: '#' }}" tabindex="@if (! $photographs->nextPageUrl()) -1 @endif" aria-disabled="@if (! $photographs->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'comments')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">COMMENTS</h2>

          <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
              <thead>
                <tr>
                  <th>Thought</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($comments as $comment)
                  <tr>
                    <td>{{ $comment->thought?->title }}</td>
                    <td>{{ $comment->name }}</td>
                    <td>{{ $comment->email }}</td>
                    <td style="max-width: 420px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $comment->message }}</td>
                    <td>
                      @if ($comment->is_approved)
                        Approved
                      @else
                        Pending
                      @endif
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                        @if ($comment->is_approved)
                          <form method="POST" action="{{ route('admin.comments.unapprove', $comment) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="read-more-pill">UNAPPROVE</button>
                          </form>
                        @else
                          <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="read-more-pill">APPROVE</button>
                          </form>
                        @endif
                        <form method="POST" action="{{ route('admin.comments.delete', $comment) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="read-more-pill">DELETE</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($comments->lastPage() > 1)
            @php
              $current = $comments->currentPage();
              $last = $comments->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $comments->previousPageUrl()) disabled @endif" href="{{ $comments->previousPageUrl() ?: '#' }}" tabindex="@if (! $comments->previousPageUrl()) -1 @endif" aria-disabled="@if (! $comments->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $comments->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $comments->nextPageUrl()) disabled @endif" href="{{ $comments->nextPageUrl() ?: '#' }}" tabindex="@if (! $comments->nextPageUrl()) -1 @endif" aria-disabled="@if (! $comments->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'reviews')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">REVIEWS</h2>

          <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Location</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reviews as $review)
                  <tr>
                    <td>{{ $review->name }}</td>
                    <td>{{ $review->email }}</td>
                    <td>{{ $review->location }}</td>
                    <td style="max-width: 420px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $review->message }}</td>
                    <td>
                      @if ($review->is_approved)
                        Approved
                      @else
                        Pending
                      @endif
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                        @if ($review->is_approved)
                          <form method="POST" action="{{ route('admin.reviews.unapprove', $review) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="read-more-pill">UNAPPROVE</button>
                          </form>
                        @else
                          <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="read-more-pill">APPROVE</button>
                          </form>
                        @endif
                        <form method="POST" action="{{ route('admin.reviews.delete', $review) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="read-more-pill">DELETE</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($reviews->lastPage() > 1)
            @php
              $current = $reviews->currentPage();
              $last = $reviews->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $reviews->previousPageUrl()) disabled @endif" href="{{ $reviews->previousPageUrl() ?: '#' }}" tabindex="@if (! $reviews->previousPageUrl()) -1 @endif" aria-disabled="@if (! $reviews->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $reviews->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $reviews->nextPageUrl()) disabled @endif" href="{{ $reviews->nextPageUrl() ?: '#' }}" tabindex="@if (! $reviews->nextPageUrl()) -1 @endif" aria-disabled="@if (! $reviews->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'richus')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">RICH US</h2>

          <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Attachment</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($richUsMessages as $richUsMessage)
                  <tr>
                    <td>{{ $richUsMessage->name }}</td>
                    <td>
                      <a class="text-white text-decoration-none" href="mailto:{{ $richUsMessage->email }}?subject={{ rawurlencode('TIIMBOOKTU - Rich Us #'.$richUsMessage->id) }}">
                        {{ $richUsMessage->email }}
                      </a>
                    </td>
                    <td style="max-width: 520px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $richUsMessage->message }}</td>
                    <td>
                      @if ($richUsMessage->attachment_path)
                        <a class="text-white text-decoration-none" href="{{ asset($richUsMessage->attachment_path) }}" target="_blank" rel="noopener noreferrer">VIEW</a>
                      @else
                        —
                      @endif
                    </td>
                    <td>
                      @if ($richUsMessage->contacted_at)
                        Contacted
                      @else
                        New
                      @endif
                    </td>
                    <td>{{ $richUsMessage->created_at->format('Y-m-d') }}</td>
                    <td class="text-end">
                      <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                        <a class="read-more-pill" href="mailto:{{ $richUsMessage->email }}?subject={{ rawurlencode('TIIMBOOKTU - Rich Us #'.$richUsMessage->id) }}">EMAIL</a>
                        <form method="POST" action="{{ route('admin.rich-us.toggle-contacted', $richUsMessage) }}">
                          @csrf
                          @method('PUT')
                          <button type="submit" class="read-more-pill">
                            @if ($richUsMessage->contacted_at)
                              MARK NEW
                            @else
                              MARK CONTACTED
                            @endif
                          </button>
                        </form>
                        <form method="POST" action="{{ route('admin.rich-us.delete', $richUsMessage) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="read-more-pill">DELETE</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($richUsMessages->lastPage() > 1)
            @php
              $current = $richUsMessages->currentPage();
              $last = $richUsMessages->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $richUsMessages->previousPageUrl()) disabled @endif" href="{{ $richUsMessages->previousPageUrl() ?: '#' }}" tabindex="@if (! $richUsMessages->previousPageUrl()) -1 @endif" aria-disabled="@if (! $richUsMessages->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $richUsMessages->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $richUsMessages->nextPageUrl()) disabled @endif" href="{{ $richUsMessages->nextPageUrl() ?: '#' }}" tabindex="@if (! $richUsMessages->nextPageUrl()) -1 @endif" aria-disabled="@if (! $richUsMessages->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'guestnetno')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">GUEST CONTENT</h2>

          <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($guestPosts as $guestPost)
                  <tr>
                    <td>{{ $guestPost->author_name }}</td>
                    <td>{{ $guestPost->author_email }}</td>
                    <td style="max-width: 520px;">
                      <div class="text-white">{{ $guestPost->title }}</div>
                      <div class="text-white-50 small" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ \Illuminate\Support\Str::limit(strip_tags((string) $guestPost->body), 120) }}
                      </div>
                    </td>
                    <td>
                      @if ($guestPost->is_approved)
                        Approved
                      @else
                        Pending
                      @endif
                    </td>
                    <td>{{ $guestPost->created_at->format('Y-m-d') }}</td>
                    <td class="text-end">
                      <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                        @if ($guestPost->is_approved)
                          <form method="POST" action="{{ route('admin.guest-posts.unapprove', $guestPost) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="read-more-pill">UNAPPROVE</button>
                          </form>
                        @else
                          <form method="POST" action="{{ route('admin.guest-posts.approve', $guestPost) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="read-more-pill">APPROVE</button>
                          </form>
                        @endif
                        <form method="POST" action="{{ route('admin.guest-posts.delete', $guestPost) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="read-more-pill">DELETE</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($guestPosts->lastPage() > 1)
            @php
              $current = $guestPosts->currentPage();
              $last = $guestPosts->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $guestPosts->previousPageUrl()) disabled @endif" href="{{ $guestPosts->previousPageUrl() ?: '#' }}" tabindex="@if (! $guestPosts->previousPageUrl()) -1 @endif" aria-disabled="@if (! $guestPosts->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $guestPosts->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $guestPosts->nextPageUrl()) disabled @endif" href="{{ $guestPosts->nextPageUrl() ?: '#' }}" tabindex="@if (! $guestPosts->nextPageUrl()) -1 @endif" aria-disabled="@if (! $guestPosts->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif

      @if (($activeSection ?? 'featured') === 'ourthing')
        <div class="rich-us-form-container mb-5">
          <h2 class="rich-us-form-title">OUR THING</h2>
          @if (isset($editingOurThing) && $editingOurThing)
            <div class="mb-4 p-3 border border-secondary rounded">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0 text-white">Edit Our Thing</h3>
                <a class="read-more-pill" href="{{ route('admin.ourthing') }}">CANCEL</a>
              </div>
              <div class="mb-3 text-center">
                <img src="{{ asset($editingOurThing->image_path) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Our Thing">
              </div>
              <form class="rich-us-form" method="POST" action="{{ route('admin.ourthing.update', $editingOurThing) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                  <div class="col-12 col-lg-6">
                    <label for="ourthing_edit_title" class="form-label text-white">Title</label>
                    <input type="text" class="form-control" id="ourthing_edit_title" name="title" value="{{ old('title', $editingOurThing->title) }}">
                  </div>
                  <div class="col-12 col-lg-6">
                    <label for="ourthing_edit_image" class="form-label text-white">Replace Image</label>
                    <input type="file" class="form-control" id="ourthing_edit_image" name="image" accept="image/*">
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="rich-us-submit-btn">UPDATE OUR THING</button>
                </div>
              </form>
            </div>
          @endif

          <form class="rich-us-form mb-4" method="POST" action="{{ route('admin.ourthing.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-12 col-lg-6">
                <label for="ourthing_title" class="form-label text-white">Title</label>
                <input type="text" class="form-control" id="ourthing_title" name="title" value="{{ old('title') }}">
              </div>
              <div class="col-12 col-lg-6">
                <label for="ourthing_image" class="form-label text-white">Image</label>
                <input type="file" class="form-control" id="ourthing_image" name="image" accept="image/*" required>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="rich-us-submit-btn">UPLOAD OUR THING</button>
            </div>
          </form>

          <div class="row g-3">
            @foreach ($ourThings as $item)
              <div class="col-6 col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary h-100">
                  <img src="{{ asset($item->image_path) }}" class="card-img-top" alt="Our Thing">
                  <div class="card-body">
                    <div class="small text-white-50 mb-2">{{ $item->title ?: 'No Title' }}</div>
                    <div class="d-grid gap-2">
                      <a class="read-more-pill w-100 text-center" href="{{ route('admin.ourthing.edit', $item) }}">EDIT</a>
                      <form method="POST" action="{{ route('admin.ourthing.delete', $item) }}" onsubmit="return confirm('Delete this item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="read-more-pill w-100">DELETE</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          @if ($ourThings->lastPage() > 1)
            @php
              $current = $ourThings->currentPage();
              $last = $ourThings->lastPage();
              $start = max(1, $current - 2);
              $end = min($last, $current + 2);
              $range = range($start, $end);
              if (! in_array(1, $range, true)) {
                  array_unshift($range, 1);
              }
              if (! in_array($last, $range, true)) {
                  $range[] = $last;
              }
              $range = array_values(array_unique($range));
              sort($range);
            @endphp
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <a class="read-more-pill pagination-pill @if (! $ourThings->previousPageUrl()) disabled @endif" href="{{ $ourThings->previousPageUrl() ?: '#' }}" tabindex="@if (! $ourThings->previousPageUrl()) -1 @endif" aria-disabled="@if (! $ourThings->previousPageUrl()) true @else false @endif">PREV</a>
              @foreach ($range as $page)
                @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
                  <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
                @endif
                <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $ourThings->url($page) }}">{{ $page }}</a>
              @endforeach
              <a class="read-more-pill pagination-pill @if (! $ourThings->nextPageUrl()) disabled @endif" href="{{ $ourThings->nextPageUrl() ?: '#' }}" tabindex="@if (! $ourThings->nextPageUrl()) -1 @endif" aria-disabled="@if (! $ourThings->nextPageUrl()) true @else false @endif">NEXT</a>
            </div>
          @endif
        </div>
      @endif
    </div>
  </section>
@endsection
