@extends('layouts.app')

@section('title', ($guestPost->title ?? 'Guest Content') . ' - TIIMBOOKTU')

@section('content')
  <section class="blog-detail-section">
    <div class="container">
      <h1 class="blog-detail-title">{{ $guestPost->title }}</h1>

      <div class="blog-detail-content">
        <p class="blog-date justify-content-center">📅 {{ $guestPost->created_at->format('F j, Y') }}</p>
        @if ($guestPost->author_name)
          <p class="text-white-50 text-center mb-4">{{ $guestPost->author_name }}</p>
        @endif
        <div class="text-white">{!! $guestPost->body !!}</div>
      </div>

      <div class="text-center mt-5">
        <a class="read-more-pill d-inline-block" href="{{ route('page.guestnetno') }}">BACK</a>
      </div>
    </div>
  </section>
@endsection

