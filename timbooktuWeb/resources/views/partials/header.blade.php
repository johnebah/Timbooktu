<header class="header-section">
  <div class="d-none d-lg-block">
    <div class="container border-bottom border-secondary py-3">
      <div class="d-flex justify-content-between align-items-center">
        <a class="logo text-white text-decoration-none" href="{{ route('page.index') }}">TIIMBOOKTU</a>

        <div class="search-bar position-relative flex-grow-1 mx-5">
          <span class="search-icon position-absolute top-50 start-0 translate-middle-y ms-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </span>
          <input type="text" class="form-control bg-transparent text-white border-secondary ps-4" placeholder="Search" />
        </div>

        <div class="user-actions text-white d-flex align-items-center gap-2">
          <span class="user-icon">👤</span>
          <span class="dropdown-arrow">﹀</span>
        </div>
      </div>
    </div>

    <div class="container py-3">
      <ul class="nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            TIIMBOOKTU
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="{{ route('page.timbooktu') }}">On Timbooktu</a></li>
            <li><a class="dropdown-item" href="{{ route('page.tuiites') }}">From the Tu’ites</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            THOUGHTS
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="{{ route('page.lacomposmentis') }}">La Compos Mentis</a></li>
            <li><a class="dropdown-item" href="{{ route('page.guestnetno') }}">Guest Content</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('page.fotografie') }}">FOTOGRAFIE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('page.rich-us') }}">RICH US</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('page.shop') }}">OUR THING (The Shop)</a>
        </li>
      </ul>
    </div>
  </div>

  <nav class="navbar navbar-dark bg-black d-lg-none">
    <div class="container">
      <a class="navbar-brand logo" href="{{ route('page.index') }}">TIIMBOOKTU</a>

      <div class="d-flex align-items-center gap-3">
        <button class="btn text-white p-0" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileContent" aria-controls="navbarMobileContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse mt-3" id="navbarMobileContent">
        <div class="search-bar position-relative mb-3">
          <span class="search-icon position-absolute top-50 start-0 translate-middle-y ms-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </span>
          <input type="text" class="form-control bg-transparent text-white border-secondary ps-4" placeholder="Search" />
        </div>

        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              TIIMBOOKTU
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="{{ route('page.timbooktu') }}">On Timbooktu</a></li>
              <li><a class="dropdown-item" href="{{ route('page.tuiites') }}">From the Tu’ites</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              THOUGHTS
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="{{ route('page.lacomposmentis') }}">La Compos Mentis</a></li>
              <li><a class="dropdown-item" href="{{ route('page.guestnetno') }}">Guest Content</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('page.fotografie') }}">FOTOGRAFIE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('page.rich-us') }}">RICH US</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('page.shop') }}">OUR THING (The Shop)</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
