@extends('layouts.app')

@section('title', 'Our Thing - TIIMBOOKTU')

@section('content')
  <section class="fotografie-page-section">
    <div class="container">
      <h1 class="fotografie-page-title">OUR THING</h1>

      <div class="fotografie-grid-container">
        @php
          $ourThingRows = isset($ourThings)
            ? $ourThings->getCollection()->chunk(3)
            : collect([]);
        @endphp

        @if ($ourThingRows->isEmpty())
          <p class="text-center text-white-50">No images uploaded yet.</p>
        @else
          @foreach ($ourThingRows as $row)
            <div class="fotografie-row">
              @foreach ($row as $item)
                <div class="fotografie-card">
                  <img src="{{ asset($item->image_path) }}" alt="{{ $item->title ?: 'Our Thing' }}" data-bs-toggle="modal" data-bs-target="#imageModal" style="cursor: pointer;" onclick="document.getElementById('modalImage').src=this.src;">
                  @if ($item->title)
                    <p class="photograph-label">{{ $item->title }}</p>
                  @endif
                </div>
              @endforeach
            </div>
          @endforeach
        @endif
      </div>

      @if (isset($ourThings) && $ourThings instanceof \Illuminate\Contracts\Pagination\Paginator && $ourThings->lastPage() > 1)
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
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-5">
          <a class="read-more-pill pagination-pill @if (! $ourThings->previousPageUrl()) disabled @endif" href="{{ $ourThings->previousPageUrl() ?: '#' }}" tabindex="@if (! $ourThings->previousPageUrl()) -1 @endif" aria-disabled="@if (! $ourThings->previousPageUrl()) true @else false @endif">PREV</a>
          @foreach ($range as $page)
            @if ($loop->first === false && $page - $range[$loop->index - 1] > 1)
              <span class="read-more-pill pagination-pill disabled" aria-disabled="true">…</span>
            @endif
            <a class="read-more-pill pagination-pill @if ($page === $current) active @endif" href="{{ $ourThings->url($page) }}">{{ $page }}</a>
          @endforeach
          <a class="read-more-pill pagination-pill @if (! $ourThings->nextPageUrl()) disabled @endif" href="{{ $ourThings->url($page+1) ?: '#' }}" tabindex="@if (! $ourThings->nextPageUrl()) -1 @endif" aria-disabled="@if (! $ourThings->nextPageUrl()) true @else false @endif">NEXT</a>
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
