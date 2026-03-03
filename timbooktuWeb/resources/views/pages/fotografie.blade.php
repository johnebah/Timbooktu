@extends('layouts.app')

@section('title', 'Fotografie - TIIMBOOKTU')

@section('content')
  <section class="fotografie-page-section">
    <div class="container">
      <h1 class="fotografie-page-title">FOTOGRAFIE</h1>

      <div class="fotografie-grid-container">
        @php
          $photoRows = isset($photographs)
            ? $photographs->getCollection()->chunk(3)
            : collect([
                collect([
                  (object) ['title' => 'Photo 1', 'image_url' => asset('img/image 92.png')],
                  (object) ['title' => 'Photo 2', 'image_url' => asset('img/image 96.png')],
                  (object) ['title' => 'Photo 3', 'image_url' => asset('img/image 97.png')],
                ]),
              ]);
        @endphp

        @foreach ($photoRows as $row)
          <div class="fotografie-row">
            @foreach ($row as $photo)
              @php
                $photoImageUrl = isset($photo->image_path)
                  ? asset($photo->image_path)
                  : $photo->image_url;
              @endphp
              <div class="fotografie-card">
                <img src="{{ $photoImageUrl }}" alt="{{ $photo->title ?: 'Photo' }}" data-bs-toggle="modal" data-bs-target="#imageModal" style="cursor: pointer;" onclick="document.getElementById('modalImage').src=this.src;">
              </div>
            @endforeach
          </div>
        @endforeach
      </div>

      @if (isset($photographs) && $photographs instanceof \Illuminate\Contracts\Pagination\Paginator && $photographs->lastPage() > 1)
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
          $range = array-values(array_unique($range));
          sort($range);
        @endphp
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-5">
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

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center pt-0">
            <img id="modalImage" src="" alt="Full Size Image" class="img-fluid rounded" style="max-height: 85vh; object-fit: contain;">
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
