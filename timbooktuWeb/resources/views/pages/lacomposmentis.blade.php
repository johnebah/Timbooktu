@extends('layouts.app')

@section('title', 'La Compos Mentis - TIIMBOOKTU')

@section('content')
  <section class="lacomposmentis-section">
    <div class="container">
      <h1 class="lacomposmentis-title">LA COMPOS MENTIS</h1>
      <p class="lacomposmentis-subtitle">Things I don't tell anyone. Turns out, I talk.</p>

      <div class="blog-grid">
        @forelse ($thoughts as $thought)
          @php
            $thoughtImageUrl = $thought->image_path
              ? asset($thought->image_path)
              : asset('img/thought-card1.png');
            $thoughtDate = $thought->published_at ? $thought->published_at->format('F j, Y') : $thought->created_at->format('F j, Y');
            $thoughtExcerpt = \Illuminate\Support\Str::limit(strip_tags((string) ($thought->excerpt ?: $thought->body)), 140);
          @endphp
          <div class="blog-card">
            <div class="blog-image">
              <img src="{{ $thoughtImageUrl }}" alt="{{ $thought->title }}" />
            </div>
            <div class="blog-content">
              <p class="blog-date">📅 {{ $thoughtDate }}</p>
              <h3 class="blog-title">{{ $thought->title }}</h3>
              <p class="blog-excerpt">{{ $thoughtExcerpt }}</p>
              <a class="read-more-btn" href="{{ route('page.blog-detail.thought', $thought) }}">Read more</a>
            </div>
          </div>
        @empty
          <div class="text-center text-white-50">No thoughts yet.</div>
        @endforelse
      </div>

      @if (isset($thoughts) && $thoughts instanceof \Illuminate\Contracts\Pagination\Paginator && $thoughts->lastPage() > 1)
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
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-5">
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
  </section>
@endsection
