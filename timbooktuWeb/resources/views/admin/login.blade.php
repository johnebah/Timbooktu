@extends('layouts.app')

@section('title', 'Admin Login - TIIMBOOKTU')

@section('content')
  <section class="rich-us-section">
    <div class="container">
      <h1 class="rich-us-title">ADMIN</h1>
      <p class="rich-us-subtitle">Enter password to continue.</p>

      <div class="rich-us-form-container">
        <h2 class="rich-us-form-title">LOGIN</h2>
        <form class="rich-us-form" method="POST" action="{{ route('admin.login.submit') }}">
          @csrf
          <div class="mb-4">
            <label for="password" class="form-label text-white">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="rich-us-submit-btn">LOGIN</button>
        </form>
      </div>
    </div>
  </section>
@endsection

