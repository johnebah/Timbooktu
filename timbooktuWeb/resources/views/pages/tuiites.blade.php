@extends('layouts.app')

@section('title', 'From the Tui&#039;ites - TIIMBOOKTU')

@section('content')
  <section class="tuiites-section">
    <div class="container">
      <h1 class="tuiites-title">FROM THE TUI'ITES</h1>
      <p class="tuiites-subtitle">From our small growing army of friends, fans and fan-atics...on a page solely for them and none else.</p>

      <div class="testimonials-list">
        @if (isset($reviews) && $reviews->count())
          @foreach ($reviews as $review)
            <div class="testimonial-item">
              <p class="quote">"{{ $review->message }}"</p>
              <p class="author">{{ strtoupper($review->name) }}</p>
              @if ($review->location)
                <p class="location">{{ $review->location }}</p>
              @endif
            </div>
          @endforeach
        @else
          <div class="testimonial-item">
            <p class="quote">"Strawberry Moon, with the intensity of the voicing of I Am My Hair, combined with better beats, has the potential to become a sledgehammer!"</p>
            <p class="author">SKINHEAD</p>
            <p class="location">Lagos, portugal</p>
          </div>

          <div class="testimonial-item">
            <p class="quote">"I Like the velvety feel of the website when i scroll. It feels like cutting fruits on antique black china."</p>
            <p class="author">KEFAS</p>
            <p class="location">Utrecht, The Netherlands</p>
          </div>

          <div class="testimonial-item">
            <p class="quote">"After 2020, Nobody Lives Here became the world. I no even know my next-door neighbours. ND Th Kevin Durant reference made me laugh hard. I remembered that."</p>
            <p class="author">BABA NNEKA,</p>
            <p class="location">Surulere, Lagos</p>
          </div>

          <div class="testimonial-item">
            <p class="quote">"I re-read Mosaic about last month. Mad man! My favorite story is that one where Oshodi was throwing dice". Hahahaha.</p>
            <p class="author">BREAD CRUMB</p>
            <p class="location">G I</p>
          </div>
        @endif
      </div>

      <div class="comment-form-wrapper">
        <h2 class="form-title">COMMENT?</h2>
        @if (session('review_submitted'))
          <div class="alert alert-success">Thanks. Your review is pending approval.</div>
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
        <form class="comment-form" method="POST" action="{{ route('page.tuiites.reviews.store') }}">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your Email">
          </div>
          <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="Enter your location">
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your message" required>{{ old('message') }}</textarea>
          </div>
          <button type="submit" class="submit-btn">SEND</button>
        </form>
      </div>
    </div>
  </section>
@endsection
