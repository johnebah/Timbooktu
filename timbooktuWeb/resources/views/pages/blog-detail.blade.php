@extends('layouts.app')

@php
  $pageTitle = isset($thought) ? $thought->title : 'TATTOO';
@endphp

@section('title', $pageTitle . ' - TIIMBOOKTU')

@section('content')
  <section class="blog-detail-section">
    <div class="container">
      <h1 class="blog-detail-title">{{ $pageTitle }}</h1>

      <div class="blog-detail-content">
        @if (isset($thought))
          @php
            $thoughtDate = $thought->published_at ? $thought->published_at->format('F j, Y') : $thought->created_at->format('F j, Y');
          @endphp
          <p class="blog-date justify-content-center">📅 {{ $thoughtDate }}</p>

          @if ($thought->image_path)
            <center><img src="{{ asset('storage/app/public/' . $thought->image_path) }}" alt="{{ $thought->title }}" class="img-fluid rounded mb-4" /></center>
          @endif

          {!! $thought->body !!}

          @if ($thought->audio_path)
            <div class="audio-player-container mt-4">
              <audio class="w-100" controls preload="metadata">
                <source src="{{ asset('storage/app/public/' . $thought->audio_path) }}" />
              </audio>
            </div>
          @endif

          <div class="mt-5">
            <h2 class="rich-us-form-title">COMMENTS.</h2>
            @if (isset($comments) && $comments->count())
              <div class="mt-3">
                @foreach ($comments as $comment)
                  <div class="p-3 mb-3 rounded" style="background: rgba(255, 255, 255, 0.06);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="text-white fw-semibold">{{ $comment->name }}</div>
                      <div class="text-white-50 small">{{ $comment->created_at->format('M j, Y') }}</div>
                    </div>
                    <div class="text-white-50" style="white-space: pre-wrap;">{{ $comment->message }}</div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="text-white-50 mt-3">No comments yet.</div>
            @endif
          </div>
        @else
        <p>One afternoon half a decade ago, I and a buddy drank one too many of that evil dwarf beer and got too shitfaced to think straight. But, think all the same, we did, and decided, in all our wisdom, to get tattoos. At the very last minute he wisely declined to get any, but me who'd had it in mind to get tats since I was probably 16 decided, against my better judgement, to.</p>

        <p>Getting it wasn't really the issue, per se. Getting it there was. The tattoo artist was this surly-tempered, bald-headed ancient fuck that couldn't keep a steady hand to save his dick. Still, I looked up Malcolm X, selected that pic of him holding up a gun and peering out a window and handed it to him. This dumbass motherfucker ended up doing what dumbass motherfuckers do: be a dumbass motherfucker. The gun ended up being bigger than the Malcolm X holding it and the detailing was so shoddily done that all I got for the money spent and pain gotten was wearing a pair of long sleeves and opting for an immediate cover up.</p>

        <p>Which brings us to a series of points when getting a tat, the first of which is</p>

        <p>It's been 17 years already and I think of it, like, Fuck! Life!</p>

        <div class="blog-divider">
          <span class="paw-icon">🐾</span>
        </div>

        <h3 class="blog-subheading">THE ARTIST.</h3>

        <p>Now, there are quite a number of frauds out there masquerading as tattoo artists. I've never risked getting a tattoo in Nigeria, for example. And I absolutely do not think you should either, because what the hell do these guys use? Cashew nuts and pine and needles or something? Like, what the hell, make. Ever seen what their black ink turns into after some time? Something dull green, like a leech. And ever notice what the feel and texture of the tat feels like? Bumpy, like an ugly scar. Again, ever notice what becomes of the whole of the tat after a few years? Fragments, like a patch of badly dried earth. Nowhere through the duration of that godammed tat are you made to be truly satisfied.</p>

        <p>Should you decide to, however, because you can't wait to rock that ink, you might want to research thoroughly. You hear me? Re-search tho-ro-ugh-ly. Sure, they'll show you videos and pictures of previous clients, but that doesn't necessarily mean shit. Anything taken with good lighting combined with the right angles can turn turd to butter. Plus, at the end of the day, it's a business and most won't care to lie as long as they get your money into their pockets.</p>

        <p>There's no failsafe way to ensure the best service through research, but one thing I'd advise, though, is taking a good look at the artist. Good tattoo artists usually have on good tats and bad tattoo artists usually have amateurish tats.</p>

        <p>Of course, there's the argument that an artist with bad art might have gotten progressively better over the years. Good point, but, would you be willing to risk it?</p>

        <div class="blog-divider">
          <span class="paw-icon">🐾</span>
        </div>

        <h3 class="blog-subheading">INK.</h3>

        <p>You've heard and read it everywhere it has become the unanimous truth: tattoos are permanent. Think carefully before you wear one.</p>

        <p>That's not entirely true. Tattoos aren't permanent. Because they absolutely can be removed. I can imagine the reason why they put that fear of the permanence of tats in you, though. To make you think hard. As you should.</p>

        <p>A tattoo is a mode of self-expression. People have a fairly good idea who you are and what you stand for by merely looking at them. Which is why thinking up the right tat is quite important. [Personally, I think it's a horrible idea for anyone to do tats because of the idea they think they'll communicate to others. In my opinion, half the people who see your tats, regardless of the Jesus or the Jesus' Cross it is, already see you as the Devil's Cupbearer. I think one's tats ought to be for you and only you, and for no one else but you.]</p>

        <p>Regardless of what it is though, trust me, you wanna draw something you'd represent for a long time. Of course, ideologies change, friendships shift, life happens and the people we were so sure of remaining quickly become distant shadows, which is why you ought to think through/about that ink. Like me, you should not take that decision when drunk or high. Or in love.</p>

        <p>A quote? Probably. Religious symbols? Cool. A family member? Dope. A celebrity? Risky. A personality test? Cool. A boyfriend/girlfriend [based on love]? Terrible. Something abstract? Awesome.</p>

        <p>Personally, I have quotes all over, from Hamlet to a Bible verse. And I have a bear tat, a mom tat, a Richard Wright tat, an aspect of personality tat and a girlfriend tat [based on influence, not love]. I've never regretted any of them, and will likely never, except that shit up there which, as you now know, had to be covered up ASAP.</p>

        <p>So, yeah, think! You don't want to live with something you're compelled to keep covering up, something you have to put out a disclaimer for every now and then, or worse, something that haunts your privacy/ peace of mind.</p>

        <div class="blog-divider">
          <span class="paw-icon">🐾</span>
        </div>

        <h3 class="blog-subheading">THE PAIN.</h3>

        <p>Like most things that demand specific answers, the answer to whether or not tattoos hurt depends.</p>

        <p>Hold on a minute. That there doesn't depend. TATTOOS HURT! Period! I mean, we're talking about repeatedly piercing the skin with a sharp or a series of sharp needles. It is the extent of the hurt that varies, and that depends. Depends on what? On who. On what part of the body. On the person's threshold to pain. On how long the session is. I dare say it even depends on the artist.</p>

        <p>Everyone generally seems to agree that the chest [sternum], ribs, knuckles, ankles, the back of your hand and the top of your foot are the worst places to get tatted because they're bony. I'd guess so too, considering it's some hard ass needle repeatedly digging and buzzin' through and through for several hours. For me though... and here's why I say it depends... it was different. Sure, the pain shocked me into extreme hypersensitivity at first, but with time I became comfortable and then it became unbearably sweet [I remember my tattoo artist asking what was wrong with me cause I kept chuckling, and sometimes laughing]. Then again, I doubt I'm normal so it's probably safer for you to assume your session will be truly horrific, from beginning to end.</p>

        <p>For the fleshier parts of the body [where most people get tatted] like the arms [outer and inner], the back and [perhaps] the thighs, it's almost like a soothing sensation [something that I'd hardly even call pain]. Sure, it'll hurt at first but ten to fifteen minutes in, you're sure to get used to it and might even totally embrace it and yearn for more.</p>

        <p>[It should be noted that hurt might mean many things here which include, but aren't limited to, burning, stinging, irritation, chaffing, violent murder pain, birth pain. LOL.]</p>

        <div class="blog-divider">
          <span class="paw-icon">🐾</span>
        </div>

        <div class="audio-player-container">
          <div class="audio-player">
            <button class="play-btn">▶</button>
            <div class="progress-bar-container">
              <div class="progress-bar"></div>
            </div>
            <span class="time-display">0:00 / 3:01</span>
            <button class="volume-btn">🔊</button>
          </div>
        </div>
        @endif
      </div>

      @if (isset($thought))
        <div class="rich-us-form-container mt-5">
          <h2 class="rich-us-form-title">COMMENT?</h2>
          @if (session('comment_submitted'))
            <div class="alert alert-success">Thanks. Your comment is pending approval.</div>
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
          <form class="rich-us-form" method="POST" action="{{ route('page.blog-detail.thought.comments.store', $thought) }}">
            @csrf
            <div class="mb-4">
              <label for="name" class="form-label text-white">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name" required>
            </div>
            <div class="mb-4">
              <label for="email" class="form-label text-white">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your Email">
            </div>
            <div class="mb-4">
              <label for="message" class="form-label text-white">Your Message</label>
              <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="rich-us-submit-btn green-btn">SEND</button>
          </form>
        </div>
      @else
        <div class="rich-us-form-container mt-5">
          <h2 class="rich-us-form-title">COMMENT?</h2>
          <form class="rich-us-form">
            <div class="mb-4">
              <label for="name" class="form-label text-white">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter name">
            </div>
            <div class="mb-4">
              <label for="email" class="form-label text-white">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Enter your Email">
            </div>
            <div class="mb-4">
              <label for="message" class="form-label text-white">Your Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"></textarea>
            </div>
            <button type="submit" class="rich-us-submit-btn green-btn">SEND</button>
          </form>
        </div>
      @endif
    </div>
  </section>
@endsection
