@extends('layouts.app')

@section('title', 'Rich Us - TIIMBOOKTU')

@section('content')
  <section class="rich-us-section">
    <div class="container">
      <h1 class="rich-us-title">RICH US.</h1>
      <p class="rich-us-subtitle">Feedback? Suggestions? Opinions? Critiques? Yup, drop it laikit's haat.</p>

      <div class="rich-us-form-container">
        <h2 class="rich-us-form-title"></h2>
        @if (session('rich_us_submitted'))
          <div class="alert alert-success">Thanks. Your message has been sent.</div>
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
        <form class="rich-us-form" method="POST" action="{{ route('page.rich-us.messages.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-4">
            <label for="name" class="form-label text-white">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name" required>
          </div>
          <div class="mb-4">
            <label for="email" class="form-label text-white">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your Email" required>
          </div>
          <div class="mb-4">
            <label for="message" class="form-label text-white">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required>{{ old('message') }}</textarea>
          </div>
          <div class="mb-4">
            <label for="attachment" class="form-label text-white">Attachment (Optional)</label>
            <input type="file" class="form-control" id="attachment" name="attachment" accept=".pdf,image/*">
          </div>
          <button type="submit" class="rich-us-submit-btn">SEND</button>
        </form>
      </div>
    </div>
  </section>
@endsection
