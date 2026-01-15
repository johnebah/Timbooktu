@extends('layouts.app')

@section('title', 'Guest Content - TIIMBOOKTU')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var editorEl = document.getElementById('guest_post_editor');
      var inputEl = document.getElementById('guest_post_body');
      if (!editorEl || !inputEl) return;

      var quill = new Quill(editorEl, {
        theme: 'snow',
        modules: {
          toolbar: [
            [{ header: [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'link'],
            ['clean']
          ]
        }
      });

      var initialHtml = editorEl.getAttribute('data-quill-initial');
      if (initialHtml) {
        try {
          initialHtml = JSON.parse(initialHtml);
        } catch (e) {
          initialHtml = '';
        }
      }

      if (typeof initialHtml === 'string' && initialHtml.trim().length) {
        quill.clipboard.dangerouslyPasteHTML(initialHtml);
      }

      var form = editorEl.closest('form');
      if (form) {
        form.addEventListener('submit', function () {
          inputEl.value = quill.root.innerHTML;
        });
      }
    });
  </script>
@endpush

@section('content')
  <section class="guestnetno-section">
    <div class="container">
      <h1 class="guestnetno-title">GUEST CONTENT</h1>
      <div class="guestnetno-subtitle-wrapper">
        <p class="guestnetno-subtitle">"It's sorta like, we write what we want. Not what they like."</p>
        <p class="guestnetno-author">_Thee Guest.</p>
      </div>

      <div class="scroll-down-wrapper">
        <div class="scroll-down-circle">
          <span class="arrow-down">↓</span>
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
          <div class="guest-card">
            <div class="guest-date">
              <span class="calendar-icon">📅</span> JANUARY 3, 2025
            </div>
            <h3 class="guest-card-title">HOW TO FALL IN..</h3>
            <p class="guest-card-text">FIRST YOU SAY, "I DON'T DO THIS OFTEN. I NEVER DO THIS." AS YOU PRESS YOUR LIPS TO HIS HESITANT ONES. YOU'RE...</p>
            <button class="read-more-pill" type="button">READ MORE</button>
          </div>

          <div class="guest-card">
            <div class="guest-date">
              <span class="calendar-icon">📅</span> DECEMBER 31, 2024
            </div>
            <h3 class="guest-card-title">COFFEE</h3>
            <p class="guest-card-text">COFFEE THE FIRST TIME I DRANK COFFEE I WAS FOURTEEN. IF THIS WERE A STORY ABOUT COFFEE, I WOULD SAY...</p>
            <button class="read-more-pill" type="button">READ MORE</button>
          </div>

          <div class="guest-card">
            <div class="guest-date">
              <span class="calendar-icon">📅</span> DECEMBER 29, 2025
            </div>
            <h3 class="guest-card-title">THE NOW</h3>
            <p class="guest-card-text">A FEW THOUSAND YEARS AGO, THERE WAS AN OBSCURE, RUSTIC SETTLEMENT, EXISTING OFF THE BEATEN PATH. ITS PEOPLE WERE MOSTLY...</p>
            <button class="read-more-pill" type="button">READ MORE</button>
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

      <div class="text-center mt-5">
        <button class="read-more-pill" type="button" data-bs-toggle="collapse" data-bs-target="#guestContentForm" aria-expanded="false" aria-controls="guestContentForm">CREATE YOUR OWN CONTENT</button>
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
              <label class="form-label text-white">Text</label>
              <input type="hidden" id="guest_post_body" name="body">
              <div id="guest_post_editor" class="form-control quill-editor" data-quill-initial='@json(old('body'))'></div>
            </div>
            <button type="submit" class="rich-us-submit-btn">SEND</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <hr>
@endsection
