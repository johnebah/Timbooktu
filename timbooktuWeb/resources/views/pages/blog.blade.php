@extends('layouts.app')

@section('title', 'BLOG - TIIMBOOKTU')

@section('content')
  <section class="lacomposmentis-section">
    <div class="container">
      <h1 class="lacomposmentis-title">BLOG</h1>
      <p class="lacomposmentis-subtitle">Stories, thoughts, and everything in between.</p>

      <div class="blog-grid">
        <div class="blog-card">
          <div class="blog-image">
            <img src="{{ asset('img/thought-card1.png') }}" alt="Untitled" />
          </div>
          <div class="blog-content">
            <p class="blog-date">📅 February 12, 2024</p>
            <h3 class="blog-title">UNTITLED</h3>
            <p class="blog-excerpt">Lorem ipsum dolor sit amet consectetur. Vulputate commodo sit massa vitae. Sagittis tempor tempus ac sodales elementum eu convallis dui...</p>
            <button class="read-more-btn" onclick="window.location.href='#'">Read more</button>
          </div>
        </div>

        <div class="blog-card">
          <div class="blog-image">
            <img src="{{ asset('img/thought-card2.png') }}" alt="Tattoo" />
          </div>
          <div class="blog-content">
            <p class="blog-date">📅 February 12, 2024</p>
            <h3 class="blog-title">TATTOO</h3>
            <p class="blog-excerpt">TATTOO One afternoon half a decade ago, I and a buddy drank one too many of that evil dwarf beer and got too shitfaced to think straight. But...</p>
            <button class="read-more-btn" onclick="window.location.href='{{ route('page.blog-detail') }}'">Read more</button>
          </div>
        </div>

        <div class="blog-card">
          <div class="blog-image">
            <img src="{{ asset('img/thought-card3.png') }}" alt="Listen, You Really..." />
          </div>
          <div class="blog-content">
            <p class="blog-date">📅 February 12, 2024</p>
            <h3 class="blog-title">LISTEN, YOU REA...</h3>
            <p class="blog-excerpt">LISTEN, YOU REALLY CAN'T SEE SHIT! Occasionally, you'll see the couple that pop out with the cute videos and pristine smiles, and I know I'm a...</p>
            <button class="read-more-btn" onclick="window.location.href='#'">Read more</button>
          </div>
        </div>

        <div class="blog-card">
          <div class="blog-image">
            <img src="{{ asset('img/thought-card4.png') }}" alt="Illegal" />
          </div>
          <div class="blog-content">
            <p class="blog-date">📅 February 10, 2025</p>
            <h3 class="blog-title">ILLEGAL</h3>
            <p class="blog-excerpt">ILLEGAL He says the shit is easy peasy, that the city is easy, that the roads are pearl-paved, that I'll just do my master's, maybe find a job on the sid...</p>
            <button class="read-more-btn" onclick="window.location.href='#'">Read more</button>
          </div>
        </div>

        <div class="blog-card">
          <div class="blog-image">
            <img src="{{ asset('img/thought-card1.png') }}" alt="Knowledge" />
          </div>
          <div class="blog-content">
            <p class="blog-date">📅 February 4, 2025</p>
            <h3 class="blog-title">KNOWLEDGE</h3>
            <p class="blog-excerpt">KNOWLEDGE Sometime in the late 30s a young man walked late into class and met two problems on the blackboard he assumed were take home...</p>
            <button class="read-more-btn" onclick="window.location.href='#'">Read more</button>
          </div>
        </div>

        <div class="blog-card">
          <div class="blog-image">
            <img src="{{ asset('img/thought-card2.png') }}" alt="Problem" />
          </div>
          <div class="blog-content">
            <p class="blog-date">📅 February 1, 2025</p>
            <h3 class="blog-title">PROBLEM</h3>
            <p class="blog-excerpt">PROBLEM As I'm writing this, I geh like five problem. Five! All which needs to be solved before Wednesday. They cease to be a problem after...</p>
            <button class="read-more-btn" onclick="window.location.href='#'">Read more</button>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
