@extends('layouts.app')

@section('title', 'Guest Content - TIIMBOOKTU')

@push('styles')
  <style>
    .tox-tinymce {
      border-radius: 8px !important;
      border: 1px solid #3E3E3A !important;
    }
    @media (max-width: 768px) {
      .tox-tinymce {
        height: 300px !important;
      }
    }
  </style>
@endpush


@push('scripts')
  <script src="https://cdn.tiny.cloud/1/cqgpe4qmv55yhh32rm6wr4x1s1062rw0p5kjobcooaf6ytt0/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      tinymce.init({
        selector: '#guest_post_editor',
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
          height: 300
        }
      });
    });
  </script>
@endpush


@section('content')
  <section class="guestnetno-section">
    <div class="container">
      <h1 class="guestnetno-title">GUEST CONTENT</h1>
      <div class="guestnetno-subtitle-wrapper">
        <p class="guestnetno-subtitle">An open canvas. A creator's sanctuary.</p>
      </div>

      <div class="text-center mt-5">
        <button class="read-more-pill" type="button" data-bs-toggle="collapse" data-bs-target="#guestContentForm" aria-expanded="false" aria-controls="guestContentForm">CREATE YOUR OWN CONTENT. PUBLISH.</button>
      </div>

      <div class="collapse" id="guestContentForm">
        <div class="rich-us-form-container mt-5">
          <h2 class="rich-us-form-title">SUBMIT?</h2>
          @if (session('guest_post_submitted'))
            <div class="alert alert-success">Thanks. Your post is pending approval.</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form class="rich-us-form" method="POST" action="{{ route('page.guestnetno.posts.store') }}">
            @csrf
            <div class="mb-4">
              <label for="guest_author_name" class="form-label text-white">Name</label>
              <input type="text" class="form-control" id="guest_author_name" name="author_name" value="{{ old('author_name') }}" placeholder="Enter name" required>
            </div>
            <div class="mb-4">
              <label for="guest_author_email" class="form-label text-white">Email</label>
              <input type="email" class="form-control" id="guest_author_email" name="author_email" value="{{ old('author_email') }}" placeholder="Enter your Email">
            </div>
            <div class="mb-4">
              <label for="guest_title" class="form-label text-white">Title</label>
              <input type="text" class="form-control" id="guest_title" name="title" value="{{ old('title') }}" placeholder="Enter title" required>
            </div>
            <div class="mb-4">
              <label for="guest_post_editor" class="form-label text-white">Text</label>
              <textarea id="guest_post_editor" name="body" class="form-control tinymce-editor" rows="10">{{ old('body') }}</textarea>
            </div>

            <button type="submit" class="rich-us-submit-btn">SEND</button>
          </form>
        </div>
      </div>



      <div class="guest-grid">
        @if (isset($guestPosts) && $guestPosts->count())
          @foreach ($guestPosts as $post)
            @php
              $postDate = $post->created_at->format('F j, Y');
              $postExcerpt = \Illuminate\Support\Str::limit(strip_tags((string) $post->body), 140);
            @endphp
            <div class="guest-card">
              <div class="guest-date">
                <span class="calendar-icon">📅</span> {{ strtoupper($postDate) }}
              </div>
              <h3 class="guest-card-title">{{ strtoupper($post->title) }}</h3>
              @if ($post->author_name)
                <div class="text-white-50 mb-2">{{ strtoupper($post->author_name) }}</div>
              @endif
              <p class="guest-card-text">{{ strtoupper($postExcerpt) }}</p>
              <a class="read-more-pill d-inline-block" href="{{ route('page.guestnetno.posts.show', $post) }}">READ MORE</a>
            </div>
          @endforeach
        @else
          <div class="col-12 text-center py-5">
            <p class="text-white-50">NO CONTENT YET. BE THE FIRST TO PUBLISH.</p>
          </div>
        @endif
      </div>

      @if (isset($guestPosts) && $guestPosts instanceof \Illuminate\Contracts\Pagination\Paginator && $guestPosts->lastPage() > 1)
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
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-5">
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
  </section>
  <hr>
@endsection
