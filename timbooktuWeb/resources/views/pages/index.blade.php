@extends('layouts.app')

@section('title', 'TIIMBOOKTU')

@section('content')
  @php
    $featuredImageUrl = isset($featuredPost) && $featuredPost?->image_path
      ? asset($featuredPost->image_path)
      : asset('img/abt.jpeg');
    $featuredAudioUrl = isset($featuredPost) && $featuredPost?->audio_path
      ? asset($featuredPost->audio_path)
      : null;
    $featuredSubtitle = isset($featuredPost) && $featuredPost?->subtitle ? $featuredPost->subtitle : 'The Way Life Goes.';
    $featuredBody = isset($featuredPost) && $featuredPost?->body
      ? $featuredPost->body
      : '"It\'s a gradual process: the realization that you\'re moving through a world that\'s will turning even when you\'ve stopped a while ago."';
  @endphp
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <div class="hero-text">
          <h1>WE 'RE:<br>NOT THEM.</h1>
          <p class="hero-subtitle">&nbsp;STORIES x ALLIANCE x ART |CREATING TOGETHER</p>
        </div>
        <div class="hero-image">
          <picture>
            <source media="(min-width: 992px)" srcset="{{ asset('img/hrss.jpeg') }}">
            <img src="{{ asset('img/hr.png') }}" alt="Hero Image" />
          </picture>
        </div>
      </div>
    </div>
  </section>

  <section class="featured-post">
    <div class="container">
      <h2 class="section-title">FEATURED POST</h2>
      <p class="section-subtitle">{{ $featuredSubtitle }}</p>
      <div class="featured-content">
        <div class="featured-image">
          <img src="{{ $featuredImageUrl }}" alt="Featured Post" />
        </div>
        <div class="featured-quote">
          <blockquote>
            {!! $featuredBody !!}
          </blockquote>
          <div class="audio-player-container">
            @if ($featuredAudioUrl)
              <audio class="w-100" controls preload="metadata">
                <source src="{{ $featuredAudioUrl }}" />
              </audio>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="thoughts">
    <div class="container">
      <h2 class="section-title">THOUGHTS.</h2>
      <div class="carousel-wrapper">
        <button class="carousel-btn prev" id="prevBtn">&#10094;</button>
        <div class="carousel" id="carousel">
          @if (isset($thoughts) && $thoughts->count())
            @foreach ($thoughts as $thought)
              @php
                $thoughtImageUrl = $thought->image_path
                  ? asset($thought->image_path)
                  : asset('img/thought-card1.png');
              @endphp
              <a class="carousel-item" href="{{ route('page.blog-detail.thought', $thought) }}">
                <img src="{{ $thoughtImageUrl }}" alt="{{ $thought->title }}" />
                <p class="carousel-label">{{ $thought->title }}</p>
              </a>
            @endforeach
          @else
            <div class="carousel-item">
              <img src="{{ asset('img/thought-card1.png') }}" alt="Ilizwi" />
              <p class="carousel-label">Ilizwi</p>
            </div>
            <div class="carousel-item">
              <img src="{{ asset('img/thought-card2.png') }}" alt="IsiKuu" />
              <p class="carousel-label">IsiKuu</p>
            </div>
            <div class="carousel-item">
              <img src="{{ asset('img/thought-card3.png') }}" alt="Students" />
              <p class="carousel-label">Students, Death, Scythe</p>
            </div>
            <div class="carousel-item">
              <img src="{{ asset('img/thought-card4.png') }}" alt="Art" />
              <p class="carousel-label">Art</p>
            </div>
          @endif
        </div>
        <button class="carousel-btn next" id="nextBtn">&#10095;</button>
      </div>
      <a class="view-all-btn" href="{{ route('page.lacomposmentis') }}">View All</a>
    </div>
  </section>

  <section class="fotografie">
    <div class="container">
      <h2 class="section-title">FOTOGRAFIE.</h2>
      <div class="carousel-wrapper">
        <button class="carousel-btn prev" id="photoPrevBtn">&#10094;</button>
        <div class="fotografie-grid" id="photoCarousel">
          @if (isset($photographs) && $photographs->count())
            @foreach ($photographs as $photo)
              <div class="fotografie-item {{ $loop->iteration > 3 ? 'mobile-only-photo' : '' }}">
                <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: 'Photo' }}" />
                <p class="carousel-label">{{ $photo->title ?: 'Photo' }}</p>
              </div>
            @endforeach
          @else
            <div class="fotografie-item">
              <img src="{{ asset('img/image 92.png') }}" alt="Photo 1" />
              <p class="carousel-label">Photo 1</p>
            </div>
            <div class="fotografie-item">
              <img src="{{ asset('img/image 96.png') }}" alt="Photo 2" />
              <p class="carousel-label">Photo 2</p>
            </div>
            <div class="fotografie-item">
              <img src="{{ asset('img/image 97.png') }}" alt="Photo 3" />
              <p class="carousel-label">Photo 3</p>
            </div>
            <div class="fotografie-item mobile-only-photo">
              <img src="{{ asset('img/image 92.png') }}" alt="Photo 4" />
              <p class="carousel-label">Photo 4</p>
            </div>
            <div class="fotografie-item mobile-only-photo">
              <img src="{{ asset('img/image 96.png') }}" alt="Photo 5" />
              <p class="carousel-label">Photo 5</p>
            </div>
            <div class="fotografie-item mobile-only-photo">
              <img src="{{ asset('img/image 97.png') }}" alt="Photo 6" />
              <p class="carousel-label">Photo 6</p>
            </div>
          @endif
        </div>
        <button class="carousel-btn next" id="photoNextBtn">&#10095;</button>
      </div>
      <a class="view-all-btns" href="{{ route('page.fotografie') }}">View All</a>
    </div>
  </section>

  <section class="our-thing">
    <div class="container">
      <h2 class="section-title">Our Thing.</h2>
      <div class="carousel-wrapper">
        <button class="carousel-btn prev" id="ourThingPrevBtn">&#10094;</button>
        <div class="fotografie-grid" id="ourThingCarousel">
          @if (isset($ourThings) && $ourThings->count())
            @foreach ($ourThings as $item)
              <div class="fotografie-item">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title ?: 'Our Thing' }}" />
              </div>
            @endforeach
          @else
            <div class="fotografie-item">
              <img src="{{ asset('img/t1.png') }}" alt="Demo 1" />
            </div>
            <div class="fotografie-item">
              <img src="{{ asset('img/t2.png') }}" alt="Demo 2" />
            </div>
            <div class="fotografie-item">
              <img src="{{ asset('img/t3.png') }}" alt="Demo 3" />
            </div>
          @endif
        </div>
        <button class="carousel-btn next" id="ourThingNextBtn">&#10095;</button>
      </div>
      <a class="view-all-btn" href="{{ route('page.our-thing') }}">View All</a>
    </div>
  </section>

  <section class="subscribe">
    <div class="container">
      <h2 class="section-title">SUBSCRIBE TO. THE<br>SIGNAL.</h2>
      <form class="subscribe-form">
        <input type="email" placeholder="Your Email" required />
      </form>
      <button class="view-all-btnss">Submit</button>
    </div>
  </section>
@endsection
