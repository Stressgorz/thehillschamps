<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
  />
  <title>The Hills International</title>

  <!-- Favicon -->
  <link
    rel="icon"
    href="https://thehillschamps.com/images/landing/logo.png"
    type="image/x-icon"
  />

  <!-- SEO Meta Tags -->
  <meta
    name="description"
    content="The Hills International – Free forex education · Real-time signals · Expert support"
  />
  <meta
    name="keywords"
    content="forex, trading, education, signals, The Hills International"
  />

  <!-- Open Graph / Facebook -->
  <meta property="og:title" content="The Hills International" />
  <meta
    property="og:description"
    content="Free forex education · Real-time signals · Expert support"
  />
  <meta
    property="og:image"
    content="https://thehillschamps.com/images/og-image.jpg"
  />
  <meta property="og:url" content="https://thehillschamps.com" />
  <meta property="og:type" content="website" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="The Hills International" />
  <meta
    name="twitter:description"
    content="Free forex education · Real-time signals · Expert support"
  />
  <meta
    name="twitter:image"
    content="https://thehillschamps.com/images/og-image.jpg"
  />

  <!-- 1. Sync‐run viewport vars -->
  <script>
    (function () {
      function updateVars() {
        const ih = window.innerHeight,
          oh = window.outerHeight;
        document.documentElement.style.setProperty(
          "--vh",
          `${ih * 0.01}px`
        );
        document.documentElement.style.setProperty(
          "--toolbar-h",
          `${oh - ih + 50}px`
        );
      }
      // initial
      updateVars();

      // on true rotation… reload when going INTO landscape
      window.addEventListener("orientationchange", () => {
        if (window.matchMedia("(orientation: landscape)").matches) {
          setTimeout(() => location.reload(), 50);
        }
      });
    })();
  </script>

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap"
    rel="stylesheet"
  />
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    :root {
      --navy: #1e2a42;
      --peach: #f2cbaa;
    }

    /* Animation utilities */
    .animate-slide-left,
    .animate-slide-right,
    .animate-slide-up,
    .animate-fade-scale {
      opacity: 0;
      transition: opacity 0.7s ease-out, transform 0.7s ease-out;
    }

    .animate-slide-left {
      transform: translateX(-2rem);
    }

    .animate-slide-right {
      transform: translateX(2rem);
    }

    .animate-slide-up {
      transform: translateY(2rem);
    }

    .animate-fade-scale {
      transform: scale(0.8);
    }

    /* When 'visible' is added, each returns to normal state */
    .animate-slide-left.visible {
      opacity: 1;
      transform: translateX(0);
    }

    .animate-slide-right.visible {
      opacity: 1;
      transform: translateX(0);
    }

    .animate-slide-up.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .animate-fade-scale.visible {
      opacity: 1;
      transform: scale(1);
    }

    /* Hide scroll‐snap temporarily */
    html.no-snap {
      scroll-snap-type: none !important;
    }

    /* Screen-reader only */
    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }

    .sr-only:focus,
    .sr-only:active {
      position: static;
      width: auto;
      height: auto;
      margin: 0;
      overflow: visible;
      clip: auto;
      white-space: normal;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      height: 100%;
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
      scroll-snap-type: y mandatory;
      scroll-behavior: smooth;
      margin: 0;
    }

    body {
      min-height: 100%;
      margin: 0;
      font-family: "Open Sans", sans-serif;
    }

    section {
      min-height: calc(var(--vh) * 100 + var(--toolbar-h));
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 0 3rem;
      scroll-snap-align: start;
    }

    h1,
    h2,
    h3,
    blockquote {
      font-family: "Montserrat", serif;
    }

    header {
      padding-top: env(safe-area-inset-top);
    }

    .focus-outline:focus {
      outline: 2px solid var(--peach);
      outline-offset: 2px;
    }

    /* Drawer Menu */
    #backdrop {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s, visibility 0.3s;
      z-index: 40;
    }

    #backdrop.open {
      opacity: 1;
      visibility: visible;
    }

    #drawer {
      position: fixed;
      top: 0;
      right: 0;
      height: 100vh;
      width: 85vw;
      max-width: 320px;
      background: rgba(30, 42, 66, 0.95);
      transform: translateX(100%);
      transition: transform 0.3s ease-out;
      z-index: 50;
      display: flex;
      flex-direction: column;
      color: white;
    }

    #drawer.open {
      transform: translateX(0);
    }

    .drawer-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .drawer-header img {
      height: 28px;
      cursor: pointer;
    }

    .drawer-header span {
      margin-left: 0.75rem;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
    }

    .drawer-header button {
      background: none;
      border: none;
      font-size: 1.25rem;
      color: #ccc;
    }

    .drawer-header button:hover {
      color: #fff;
    }

    #drawer-nav {
      flex: 1;
      overflow-y: auto;
      padding: 1.25rem 1.5rem;
    }

    #drawer-nav ul {
      list-style: none;
    }

    #drawer-nav li {
      margin-bottom: 1rem;
      font-size: 0.875rem;
      cursor: pointer;
      transition: color 0.2s;
    }

    #drawer-nav li.active {
      color: var(--peach);
      font-weight: 600;
    }

    #drawer-nav li:hover {
      color: var(--peach);
    }

    .drawer-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .drawer-footer button {
      width: 100%;
      padding: 0.6rem;
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--navy);
      background: var(--peach);
      border: none;
      border-radius: 0.375rem;
    }

    .drawer-footer button:hover {
      background: #e0b895;
    }

    /* Gallery modal */
    #gallery-modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 50;
      display: none;
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }

    #gallery-modal .modal-content {
      background: white;
      max-width: 90%;
      width: 400px;
      border-radius: 0.5rem;
      padding: 1rem;
      position: relative;
    }

    #gallery-modal .modal-content h3 {
      text-align: center;
      margin-bottom: 1rem;
    }

    #gallery-modal .modal-content .gallery-buttons {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 0.5rem;
      margin-bottom: 1rem;
    }

    #gallery-modal .modal-content .gallery-buttons button {
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 0.25rem;
      background: white;
    }

    #gallery-modal .modal-content .gallery-buttons button:hover {
      background: #f0f0f0;
    }

    #gallery-content {
      display: flex;
      overflow-x: auto;
      gap: 0.75rem;
      padding: 1rem 0;
      scroll-snap-type: x mandatory;
    }

    #gallery-content .gallery-image-container {
      flex: 0 0 75vw;
      scroll-snap-align: center;
      transition: transform 0.3s ease;
    }

    #gallery-content .gallery-image-container img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 0.5rem;
    }

    #gallery-dots {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.5rem;
    }

    #gallery-dots .dot {
      width: 0.75rem;
      height: 0.75rem;
      border-radius: 50%;
      background: #ccc;
      transition: background 0.3s ease;
    }

    #gallery-dots .dot.active {
      background: var(--navy);
    }

    /* Partners logos hover */
    #partners img:hover {
      transform: scale(1.1);
      transition: transform 0.3s ease;
    }

    #gallery-content::-webkit-scrollbar {
      display: none;
    }

    #gallery-content {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    #gallery-dots div {
      transition: background-color 0.3s;
    }

    .gallery-image {
      transition: transform 0.3s ease;
      transform: scale(1);
    }

    .gallery-image.active {
      transform: scale(1.05);
    }
  </style>
</head>

<body class="bg-white">
  <!-- Skip to main content -->
  <a href="#main-content" class="sr-only focus:not-sr-only focus-outline">Skip to main content</a>

  <!-- NAVBAR -->
  <header
    class="fixed inset-x-0 top-0 bg-white shadow-md z-50 h-14 flex items-center justify-between px-4"
    style="padding-top: env(safe-area-inset-top);"
  >
    <div class="flex items-center space-x-2">
      <!-- Logo button scrolls to hero -->
      <button id="logo-btn" aria-label="Scroll to Hero" class="flex items-center space-x-2 focus:outline-none">
        <img
          src="https://thehillschamps.com/images/landing/logo.png"
          alt="The Hills Logo"
          class="h-8 w-8 object-contain"
          width="32"
          height="32"
        />
        <span class="text-sm font-semibold text-[var(--navy)]">
          The Hills International
        </span>
      </button>
    </div>
    <button
      id="open-drawer"
      class="text-[var(--navy)] focus-outline"
      aria-label="Open navigation menu"
      aria-expanded="false"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </header>

  <!-- BACKDROP -->
  <div id="backdrop"></div>

  <!-- DRAWER MENU -->
  <aside id="drawer">
    <div class="drawer-header">
      <div class="flex items-center">
        <img
          src="https://thehillschamps.com/images/landing/logo.png"
          alt="Logo"
          class="h-7 w-7 object-contain"
        />
        <span class="ml-2">The Hills International</span>
      </div>
      <button id="close-drawer" aria-label="Close navigation menu" class="focus-outline">
        &times;
      </button>
    </div>
    <nav id="drawer-nav">
      <ul>
        <li data-target="stats" tabindex="0" class="focus-outline">Achievement</li>
        <li data-target="about-section" tabindex="0" class="focus-outline">About</li>
        <li data-target="service" tabindex="0" class="focus-outline">Service</li>
        <li data-target="team-mobile" tabindex="0" class="focus-outline">Team</li>
        <li data-target="partners" tabindex="0" class="focus-outline">Partner</li>
      </ul>
    </nav>
    <div class="drawer-footer">
      <button id="drawer-apply-btn" class="focus-outline">Apply Now</button>
    </div>
  </aside>

  <!-- INTRO VIDEO OVERLAY -->
  <div id="intro-video" class="fixed inset-0 z-[999] bg-black transition-opacity duration-700">
    <video id="heroVideo" class="w-full h-full object-cover" autoplay muted playsinline>
      <source src="{{ asset('images/video1.mp4') }}" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    <button
      id="skipBtn"
      class="absolute top-4 right-4 text-white bg-black/50 px-3 py-1 rounded-full text-sm hover:bg-black/70 focus-outline"
    >
      ✕ Skip
    </button>
    <button
      id="soundToggle"
      class="absolute bottom-4 right-4 text-white bg-black/50 px-3 py-1 rounded-full text-sm hover:bg-black/70 focus-outline"
    >
      🔇
    </button>
  </div>

  <!-- 1. Hero (always animates on load) -->
  <section
    id="hero"
    class="flex items-center justify-center bg-[var(--navy)] text-white h-screen"
    style="opacity: 0;"
  >
    <div class="max-w-sm text-center space-y-4" style="margin-top: -100px;">
      <h1 id="hero-title" class="text-2xl font-bold opacity-0 whitespace-nowrap">LEARN ⋅ TRADE ⋅ EARN</h1>
      <p id="hero-sub" class="mt-3 text-base sm:text-lg opacity-0" style="transition-delay: 0.2s;">
        Free forex education · Real-time signals · Expert support
      </p>
      <button
        id="hero-apply-btn"
        class="inline-block mt-6 bg-[var(--peach)] text-[var(--navy)] py-2 px-6 rounded-lg font-medium text-sm hover:bg-[#e0b895] focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-2 opacity-0"
        style="transition-delay: 0.4s;"
      >
        Apply Now
      </button>
    </div>
  </section>

  <script>
    const intro = document.getElementById("intro-video");
    const video = document.getElementById("heroVideo");
    const skipBtn = document.getElementById("skipBtn");
    const soundToggle = document.getElementById("soundToggle");

    function revealHeroText() {
      // fade out intro overlay
      intro.classList.add("opacity-0");
      setTimeout(() => {
        intro.remove();

        // fade in entire hero section
        const heroSection = document.getElementById("hero");
        heroSection.style.transition = "opacity 0.6s ease-out";
        heroSection.style.opacity = "1";

        // grab the three elements
        const titleEl = document.getElementById("hero-title");
        const subEl = document.getElementById("hero-sub");
        const ctaEl = document.getElementById("hero-apply-btn");

        // immediately show title
        setTimeout(() => titleEl.classList.add("animate-fade-scale"), 150);
        setTimeout(() => titleEl.classList.add("visible"), 150);

        // show subtitle after its transition-delay (200ms)
        setTimeout(() => subEl.classList.add("animate-fade-scale"), 150);
        setTimeout(() => subEl.classList.add("visible"), 150);

        // show button after its transition-delay (400ms)
        setTimeout(() => ctaEl.classList.add("animate-fade-scale"), 150);
        setTimeout(() => ctaEl.classList.add("visible"), 150);
      }, 100);
    }

    video.addEventListener("ended", revealHeroText);
    skipBtn.addEventListener("click", () => {
      video.pause();
      revealHeroText();
    });
    soundToggle.addEventListener("click", () => {
      video.muted = !video.muted;
      soundToggle.textContent = video.muted ? "🔇" : "🔊";
    });
  </script>

  <!-- 2. Achievements (slide‐up container) -->
  <section
    id="stats"
    class="flex items-center justify-center bg-white text-[var(--navy)]"
  >
    <div class="max-w-6xl mx-auto px-4 mb-14 animate-slide-up">
      <h2 class="text-3xl font-bold text-[var(--navy)] mb-4">Achievements</h2>
      <p class="text-sm text-gray-600 mb-8">A track record that speaks for itself.</p>
      <div class="relative w-full aspect-video overflow-hidden rounded-lg shadow-lg mb-10 max-h-[400px]">
        <video class="w-full h-full object-cover" autoplay muted loop playsinline controls>
          <source src="{{ asset('images/video1.mp4') }}" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="animate-fade-scale" style="transition-delay: 0.1s;">
          <h3 class="text-3xl font-bold text-[var(--navy)] count" data-target="664">0</h3>
          <p class="text-gray-600 text-sm">Events</p>
        </div>
        <div class="animate-fade-scale" style="transition-delay: 0.1s;">
          <h3 class="text-3xl font-bold text-[var(--navy)] count" data-target="5470">0</h3>
          <p class="text-gray-600 text-sm">Insiders</p>
        </div>
        <div class="animate-fade-scale" style="transition-delay: 0.1s;">
          <h3 class="text-3xl font-bold text-[var(--navy)] count" data-target="362">0</h3>
          <p class="text-gray-600 text-sm">Champs</p>
        </div>
        <div class="animate-fade-scale" style="transition-delay: 0.1s;">
          <h3 class="text-3xl font-bold text-[var(--navy)] count" data-target="10">0</h3>
          <p class="text-gray-600 text-sm">Years</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. About / Mission & Vision / Timeline (slide‐left for header, fade‐scale for details) -->
  <section
    id="about-section"
    class="items-center justify-center py-20 bg-white text-[var(--navy)]"
  >
    <div class="flex justify-center border-b border-gray-300 mb-6 space-x-6 mt-6">
      <button
        class="tab-btn text-sm font-semibold py-2 active focus-outline"
        onclick="switchTab('about')"
      >
        About
      </button>
      <button
        class="tab-btn text-sm font-semibold py-2 focus-outline"
        onclick="switchTab('mission')"
      >
        Mission & Vision
      </button>
      <button
        class="tab-btn text-sm font-semibold py-2 focus-outline"
        onclick="switchTab('timeline')"
      >
        Timeline
      </button>
    </div>
    <div class="max-w-3xl mx-auto">
      <div id="tab-about" class="tab-content">
        <h2 class="text-2xl font-bold mb-3 animate-slide-left">About Us</h2>
        <p class="text-sm text-center mb-4 animate-fade-scale" style="transition-delay: 0.2s;">
          At The Hills, our success is driven by our dedicated Education, Service, Technical, and CS teams working seamlessly year-round.
        </p>
        <p class="text-sm text-center mb-4 animate-fade-scale" style="transition-delay: 0.4s;">
          We transform champs into leaders through our annual Elite Team Camp, plus events like CNY, Charity, Sports, Double 11, Christmas, and Incentive Trips.
        </p>
        <p class="text-sm text-center mb-6 animate-fade-scale" style="transition-delay: 0.6s;">
          Our commitment to free education means your money stays your capital, not fees.
        </p>
        <div class="max-w-2xl mx-auto animate-fade-scale" style="transition-delay: 0.8s;">
          <img
            src="{{ asset('images/cny1.jpg') }}"
            alt="CNY Event Group"
            class="w-full rounded-lg shadow-md object-cover max-h-[300px] mx-auto"
          />
        </div>
      </div>

      <div id="tab-mission" class="tab-content hidden">
        <div class="max-w-2xl mx-auto flex flex-col items-center space-y-1">
          <blockquote class="text-xl font-bold text-[var(--peach)] mb-0 animate-fade-scale">“LEARN. TRADE. EARN”</blockquote>
          <div class="text-2xl text-[var(--peach)] mb-0 animate-slide-up">↓</div>
          <h2 class="text-lg font-semibold mb-0 animate-slide-left">Founder’s Vision</h2>
          <p class="text-sm mb-1 animate-fade-scale" style="transition-delay: 0.2s;">
            We deliver HaiDiLao-level service—ethical, transparent, and fully client-focused—empowering you to learn, trade, and keep 100% control of your capital.
          </p>
          <div class="text-2xl text-[var(--peach)] mb-0 animate-slide-up" style="transition-delay: 0.4s;">↓</div>
          <h2 class="text-lg font-semibold mb-0 animate-slide-left" style="transition-delay: 0.6s;">Mission</h2>
          <p class="text-sm mb-1 animate-fade-scale" style="transition-delay: 0.8s;">
            Providing free, A–Z financial education, real-time signals, and expert support so anyone can access and succeed in the markets.
          </p>
          <div class="text-2xl text-[var(--peach)] mb-0 animate-slide-up" style="transition-delay: 1s;">↓</div>
          <h2 class="text-lg font-semibold mb-0 animate-slide-left" style="transition-delay: 1.2s;">Vision</h2>
          <p class="text-sm animate-fade-scale" style="transition-delay: 1.4s;">
            Creating a community where everyone can learn, trade, and earn, backed by our dedicated insiders and global network.
          </p>
        </div>
      </div>

      <div id="tab-timeline" class="tab-content hidden">
        <h2 class="text-2xl font-bold mb-3 animate-slide-up">Timeline</h2>
        <div class="max-w-3xl mx-auto space-y-4 text-sm text-gray-700">
          <p class="animate-fade-scale" style="transition-delay: 0.2s;"><strong>2013:</strong> Launched as CK and expanded to Melbourne.</p>
          <p class="animate-fade-scale" style="transition-delay: 0.4s;"><strong>2015–16:</strong> Rapid growth—50 to 100 IBs.</p>
          <p class="animate-fade-scale" style="transition-delay: 0.6s;"><strong>2019:</strong> 1,000 IBs & $4M USD sales; BBB partnership.</p>
          <p class="animate-fade-scale" style="transition-delay: 0.8s;"><strong>2020:</strong> First live trading event; weathered COVID-19.</p>
          <p class="animate-fade-scale" style="transition-delay: 1s;"><strong>2021:</strong> Rebranded to The Hills.</p>
          <p class="animate-fade-scale" style="transition-delay: 1.2s;"><strong>2023:</strong> 525 events, 3,158 insiders, $1.5M sales in 20 days.</p>
          <p class="animate-fade-scale" style="transition-delay: 1.4s;"><strong>2024:</strong> 7-year anniversary; global expansion under “Learn, Trade, Earn.”</p>
        </div>
      </div>
    </div>
  </section>

  <script>
    function switchTab(tab) {
      document.querySelectorAll(".tab-content").forEach((el) =>
        el.classList.add("hidden")
      );
      document.getElementById(`tab-${tab}`).classList.remove("hidden");
      document
        .querySelectorAll(".tab-btn")
        .forEach((btn) => btn.classList.remove("active"));
      event.target.classList.add("active");
    }
  </script>
  <style>
    .tab-btn {
      border-bottom: 2px solid transparent;
    }

    .tab-btn.active {
      border-bottom-color: var(--peach);
      color: var(--navy);
    }
  </style>

  <!-- 4. Supports & Services (slide‐right for image, slide‐left for text) -->
  <section
    id="service"
    class="items-center text-center justify-center py-20 bg-[var(--navy)] text-white"
  >
    <div class="max-w-6xl mx-auto px-4">
      <div class="text-center mb-10 mt-7 animate-slide-up">
        <h2 class="text-2xl font-bold">Supports & Services</h2>
        <p class="text-sm text-gray-200">to help every Insider grow and thrive</p>
      </div>

      <div
        id="service-wrapper"
        class="relative flex flex-col lg:flex-row items-center lg:items-start transition-all duration-500"
        style="justify-content: center;"
      >
        <div id="service-image" class="text-center transition-all duration-500 animate-slide-right" style="transition-delay: 0.2s;">
          <img
            src="{{ asset('images/services.png') }}"
            alt="Service Photo"
            class="mx-auto object-contain rounded-lg shadow-lg"
            style="width: 220px;"
          />
          <div class="mt-6">
            <button
              onclick="openModal()"
              class="px-6 py-2 bg-[var(--peach)] text-[var(--navy)] font-semibold rounded hover:bg-[#e0b895] transition focus-outline"
            >
              View Gallery
            </button>
          </div>
        </div>

        <div
          id="service-description"
          class="w-full lg:w-1/2 text-left mt-6 lg:mt-0 lg:ml-12 px-4 lg:px-0 hidden lg:block lg:max-w-2/5 animate-slide-left"
          style="transition-delay: 0.4s;"
        >
          <h3 class="text-xl font-bold mb-3 lg:mt-12">Why Join Us</h3>
          <p class="text-sm mb-4">
            When you join, you get free A–Z trading education—covering everything from basic concepts to advanced strategies.
          </p>
          <ul class="list-disc pl-5 space-y-2 text-sm mb-4">
            <li>免费课程 A–Z (Free A–Z Course)</li>
            <li>Learn trading step-by-step, from opening your first account to executing complex trades</li>
            <li>Live signals, market analysis, and one-on-one coaching included</li>
            <li>Community support to keep you motivated and on track</li>
          </ul>
          <p class="text-sm mb-6">
            We believe your money should be used as capital, not eaten by fees. Money is meant for growing your portfolio, not for paying hidden costs.
          </p>
        </div>
      </div>

      <button
        id="toggle-description"
        class="lg:hidden fixed right-3 top-1/2 transform -translate-y-1/2 bg-[var(--peach)] text-[var(--navy)] w-10 h-10 flex items-center justify-center rounded-full shadow z-40 hidden focus-outline animate-slide-up"
        aria-label="Toggle Services Description"
        style="transition-delay: 0.6s;"
      >
        <svg
          id="toggle-icon"
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </section>

  <script>
    const toggleBtn = document.getElementById("toggle-description");
    const toggleIcon = document.getElementById("toggle-icon");
    const imageSection = document.getElementById("service-image");
    const descSection = document.getElementById("service-description");
    const serviceSection = document.getElementById("service");

    let showingDescription = false;
    toggleBtn.addEventListener("click", () => {
      showingDescription = !showingDescription;
      if (showingDescription) {
        imageSection.classList.add("hidden");
        descSection.classList.remove("hidden");
        toggleIcon.setAttribute("d", "M15 19l-7-7 7-7");
      } else {
        imageSection.classList.remove("hidden");
        descSection.classList.add("hidden");
        toggleIcon.setAttribute("d", "M9 5l7 7-7 7");
      }
    });

    // Show/hide arrow only inside service section
    const observerToggle = new IntersectionObserver(
      ([entry]) => {
        toggleBtn.classList.toggle("hidden", !entry.isIntersecting);
      },
      { threshold: 0.5 }
    );
    observerToggle.observe(serviceSection);
  </script>

  <!-- Modal -->
  <div
    id="gallery-modal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center px-4"
  >
    <div class="bg-white max-w-xl w-full rounded-xl p-6 relative shadow-xl">
      <button onclick="closeModal()" aria-label="Close gallery" class="absolute top-3 right-4 text-2xl text-gray-500 hover:text-black focus-outline">
        &times;
      </button>
      <h3 class="text-xl font-bold text-[var(--navy)] mb-4 text-center">Select a Gallery</h3>
      <div class="grid grid-cols-2 gap-3 mb-4">
        <button class="border py-2 rounded hover:bg-gray-100 text-sm focus-outline" onclick="showGallery('Grouping')">Grouping</button>
        <button class="border py-2 rounded hover:bg-gray-100 text-sm focus-outline" onclick="showGallery('LiveTrade')">Live Trade</button>
        <button class="border py-2 rounded hover:bg-gray-100 text-sm focus-outline" onclick="showGallery('STC')">STC</button>
        <button class="border py-2 rounded hover:bg-gray-100 text-sm focus-outline" onclick="showGallery('Events')">Events</button>
        <button class="border py-2 rounded hover:bg-gray-100 text-sm focus-outline col-span-2" onclick="showGallery('Competition')">Competition</button>
      </div>
      <div id="gallery-content" class="flex overflow-x-auto gap-4 py-4 snap-x snap-mandatory justify-start sm:px-0 px-4" style="scroll-padding-left: 1rem;">
        <p class="text-sm text-gray-500 mx-auto">Select a gallery above to view photos.</p>
      </div>
      <div id="gallery-dots" class="flex justify-center space-x-2 mt-4"></div>
    </div>
  </div>

  <style>
    #gallery-content::-webkit-scrollbar {
      display: none;
    }
    #gallery-content {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    #gallery-dots div {
      transition: background-color 0.3s;
    }
    .gallery-image {
      transition: transform 0.3s ease;
      transform: scale(1);
    }
    .gallery-image.active {
      transform: scale(1.05);
    }
  </style>

  <!-- 5. Team (fade‐scale for thumbnails and slide‐up for headings) -->
  <!-- Mobile -->
  <section id="team-mobile" class="grid md:hidden bg-white text-[var(--navy)] py-20">
    <div class="max-w-5xl mx-auto px- text-center overflow-visible animate-slide-up">
      <h2 class="text-3xl font-bold mb-0">Our Team</h2>
      <p class="text-sm text-gray-600 mb-6">Directors and Seniors</p>
      <div class="w-64 sm:w-80 md:w-96 mx-auto mb-0 overflow-visible relative z-10 bg-white shadow-md rounded-lg">
        <img
          src="{{ asset('images/team-black.jpg') }}"
          alt="Team Group Photo"
          class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105"
        />
      </div>
    </div>

    <h3 class="text-xl font-semibold mb-5 mt-5 animate-slide-left">Meet Our Team</h3>
    <div class="w-full overflow-x-auto py-0">
      <div class="inline-flex flex-nowrap space-x-6">
        @for ($i = 1; $i <= 36; $i++)
        <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 0.2s;">
          <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width:3.8rem;">
            <img
              src="{{ asset('images/team/1.jpg') }}"
              alt="Name {{ $i }}"
              class="w-full h-full object-cover"
            />
          </div>
          <p class="mt-2 text-sm font-semibold">Name {{ $i }}</p>
          <p class="text-xs text-gray-500 text-center">Role {{ $i }}</p>
        </div>
        @endfor
      </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 text-center mt-5 animate-slide-up" style="transition-delay: 0.4s;">
      <button class="px-6 py-2 bg-[var(--peach)] text-[var(--navy)] font-semibold rounded hover:bg-[#e0b895] transition focus-outline">
        View All
      </button>
    </div>
  </section>

  <!-- Desktop -->
  <section id="team-desktop" class="hidden md:flex flex-col items-center bg-white text-[var(--navy)] py-20">
    <div class="text-center mb-8 animate-slide-up">
      <h2 class="text-3xl font-bold mb-2">Our Team</h2>
      <p class="text-sm text-gray-600">Directors and Seniors in The Hills International</p>
    </div>

    <div class="w-full max-w-5xl flex flex-col lg:flex-row justify-center items-start gap-8">
      <div class="max-w-5xl px-4 text-center overflow-visible animate-slide-right" style="transition-delay: 0.2s;">
        <div class="w-64 sm:w-80 md:w-96 mx-auto mb-8 overflow-visible relative z-10 bg-white shadow-md rounded-lg">
          <img
            src="{{ asset('images/team-black.jpg') }}"
            alt="Team Group Photo"
            class="w-full h-auto object-cover transition-transform duration-500 hover:scale-105"
          />
        </div>
      </div>

      <div class="my-auto w-64 sm:w-80 md:w-96 py-4 animate-slide-left" style="transition-delay: 0.4s;">
        <h3 class="text-3xl font-bold mb-6">Meet our members</h3>
        <div class="overflow-x-auto">
          <div class="flex space-x-6 mb-8">
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 0.6s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 1"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 1</p>
              <p class="text-xs text-gray-500 text-center">Role 1</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 0.8s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 2"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 2</p>
              <p class="text-xs text-gray-500 text-center">Role 2</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 1s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 3"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 3</p>
              <p class="text-xs text-gray-500 text-center">Role 3</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 1.2s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 4"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 4</p>
              <p class="text-xs text-gray-500 text-center">Role 4</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 1.4s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 5"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 5</p>
              <p class="text-xs text-gray-500 text-center">Role 5</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 1.6s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 6"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 6</p>
              <p class="text-xs text-gray-500 text-center">Role 6</p>
            </div>
          </div>

          <div class="flex space-x-6">
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 1.8s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 7"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 7</p>
              <p class="text-xs text-gray-500 text-center">Role 7</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 2s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 8"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 8</p>
              <p class="text-xs text-gray-500 text-center">Role 8</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 2.2s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 9"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 9</p>
              <p class="text-xs text-gray-500 text-center">Role 9</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 2.4s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 10"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 10</p>
              <p class="text-xs text-gray-500 text-center">Role 10</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 2.6s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 11"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 11</p>
              <p class="text-xs text-gray-500 text-center">Role 11</p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-center animate-fade-scale" style="transition-delay: 2.8s;">
              <div class="aspect-square rounded-full overflow-hidden bg-white shadow-md" style="width: 4.3rem;">
                <img
                  src="{{ asset('images/team/1.jpg') }}"
                  alt="Name 12"
                  class="w-full h-full object-cover"
                />
              </div>
              <p class="mt-2 text-sm font-semibold">Name 12</p>
              <p class="text-xs text-gray-500 text-center">Role 12</p>
            </div>
          </div>
        </div>

        <div class="mt-8 animate-slide-up" style="transition-delay: 3s;">
          <button class="px-6 py-2 bg-[var(--peach)] text-[var(--navy)] font-semibold rounded hover:bg-[#e0b895] transition focus-outline">
            View All
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- 5b. Partners (fade‐scale for logos, slide‐up for heading) -->
  <section id="partners" class="flex items-center justify-center py-20 bg-[var(--navy)] text-white">
    <div class="max-w-4xl mx-auto text-center space-y-6">
      <h2 class="text-2xl font-bold mb-4 animate-slide-up">Our Partners</h2>
      <div class="flex flex-col sm:flex-row items-center justify-center space-y-10 sm:space-y-0 sm:space-x-8">
        <img
          src="https://cp2.aimsfx.com/img/login-logo-w.png"
          alt="AimsFX Logo"
          class="h-20 focus-outline animate-fade-scale"
          style="transition-delay: 0.2s;"
        />
        <img
          src="https://worldtradingtournament.com/static/assets/images/logo.png"
          alt="WTT Logo"
          class="h-12 focus-outline animate-fade-scale"
          style="transition-delay: 0.4s;"
        />
        <img
          src="https://resources1.interface003.com/web20/img/home/logo-en.svg"
          alt="WikiFX Logo"
          class="h-12 focus-outline animate-fade-scale"
          style="transition-delay: 0.6s;"
        />
      </div>
    </div>
  </section>

  <!-- 6. Apply Form (slide‐up for heading, slide‐left/right for inputs, fade‐scale for button) -->
  <section id="apply-form" class="bg-white text-[var(--navy)] py-20">
    <div class="max-w-2xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-8 text-center animate-slide-up">Apply Now</h2>

      <form action="/submit-application" method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="animate-slide-left">
            <label for="full_name" class="block text-sm font-medium mb-1">Full Name</label>
            <input
              type="text"
              id="full_name"
              name="full_name"
              required
              placeholder="Enter your full name"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
            />
          </div>
          <div class="animate-slide-right">
            <label for="email" class="block text-sm font-medium mb-1">Email Address</label>
            <input
              type="email"
              id="email"
              name="email"
              required
              placeholder="Enter your email"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
            />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          <div class="animate-slide-left" style="transition-delay: 0.2s;">
            <label for="phone" class="block text-sm font-medium mb-1">Phone Number</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              required
              placeholder="Enter your phone number"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
            />
          </div>
          <div class="animate-slide-right" style="transition-delay: 0.4s;">
            <label for="trading_experience_years" class="block text-sm font-medium mb-1">Trading Experience (years)</label>
            <input
              type="number"
              id="trading_experience_years"
              name="trading_experience_years"
              min="0"
              placeholder="e.g. 2"
              required
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
            />
          </div>
        </div>

        <div class="mt-6 animate-slide-up" style="transition-delay: 0.6s;">
          <label for="birth_date" class="block text-sm font-medium mb-1">Birth Date</label>
          <input
            type="date"
            id="birth_date"
            name="birth_date"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
          />
        </div>

        <fieldset class="mt-8 animate-slide-up" style="transition-delay: 0.8s;">
          <legend class="text-sm font-medium mb-3">Service Needed (select one or more)</legend>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="free_course" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">Free A–Z Course</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="real_time_signals" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">Real-time Signals</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="one_on_one_coaching" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">One-on-One Coaching</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="community_support" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">Community Support</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="market_analysis" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">Market Analysis</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="vip_signals" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">VIP Signals</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="mentorship_program" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">Mentorship Program</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" name="services[]" value="portfolio_review" class="h-4 w-4 text-[var(--peach)] border-gray-300 rounded focus:ring-[var(--peach)] focus:ring-2" />
              <span class="ml-2 text-sm">Portfolio Review</span>
            </label>
          </div>
        </fieldset>

        <div class="mt-8 animate-slide-up" style="transition-delay: 1s;">
          <label for="message" class="block text-sm font-medium mb-1">Tell us a bit about yourself (optional)</label>
          <textarea
            id="message"
            name="message"
            rows="4"
            placeholder="Write your message here..."
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
          ></textarea>
        </div>

        <div class="mt-10 text-center animate-fade-scale" style="transition-delay: 1.2s;">
          <button
            type="submit"
            class="w-full md:w-auto bg-[var(--peach)] text-[var(--navy)] px-10 py-3 rounded-lg font-semibold hover:bg-[#e0b895] focus:outline-none focus:ring-2 focus:ring-[var(--peach)] focus:ring-offset-1"
          >
            Trade Now
          </button>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer scripts: drawer toggles, scrolling, count-up, gallery modal, animations -->
  <script>
    // Calculate header height including safe-area inset
    function getHeaderHeight() {
      const header = document.querySelector("header.fixed");
      return header ? header.offsetHeight : 0;
    }

    // Smoothly scroll to an element, offsetting the fixed header
    function scrollToSection(elementId) {
      const target = document.getElementById(elementId);
      if (!target) return;
      const headerHeight = getHeaderHeight();
      const targetY = target.getBoundingClientRect().top + window.pageYOffset;
      const scrollPosition = targetY - headerHeight;

      // Temporarily disable scroll-snap so Safari won’t snap you back
      document.documentElement.classList.add("no-snap");
      window.scrollTo({ top: scrollPosition, behavior: "smooth" });
      // Re-enable scroll-snap after 700ms (enough time for the smooth scroll to finish)
      setTimeout(() => {
        document.documentElement.classList.remove("no-snap");
      }, 700);
    }

    // Logo click: scroll to hero
    document.getElementById("logo-btn").addEventListener("click", () => {
      scrollToSection("hero");
      document.getElementById("backdrop").classList.remove("open");
      document.getElementById("drawer").classList.remove("open");
      document.getElementById("open-drawer").setAttribute("aria-expanded", "false");
    });

    // Hero Apply Now: scroll to form
    document.getElementById("hero-apply-btn").addEventListener("click", () => {
      scrollToSection("apply-form");
    });

    // Drawer Apply Now: scroll to form & close drawer
    document.getElementById("drawer-apply-btn").addEventListener("click", () => {
      scrollToSection("apply-form");
      document.getElementById("backdrop").classList.remove("open");
      document.getElementById("drawer").classList.remove("open");
      document.getElementById("open-drawer").setAttribute("aria-expanded", "false");
    });

    // Drawer toggle logic
    const openBtn = document.getElementById("open-drawer"),
      closeBtn = document.getElementById("close-drawer"),
      backdrop = document.getElementById("backdrop"),
      drawer = document.getElementById("drawer"),
      links = document.querySelectorAll("#drawer-nav li");

    openBtn.setAttribute("aria-expanded", "false");
    openBtn.addEventListener("click", () => {
      backdrop.classList.add("open");
      drawer.classList.add("open");
      openBtn.setAttribute("aria-expanded", "true");
    });
    closeBtn.addEventListener("click", () => {
      backdrop.classList.remove("open");
      drawer.classList.remove("open");
      openBtn.setAttribute("aria-expanded", "false");
    });
    backdrop.addEventListener("click", () => {
      backdrop.classList.remove("open");
      drawer.classList.remove("open");
      openBtn.setAttribute("aria-expanded", "false");
    });

    // Drawer menu items: scroll to respective sections
    links.forEach((li) =>
      li.addEventListener("click", () => {
        const targetId = li.dataset.target;
        scrollToSection(targetId);
        backdrop.classList.remove("open");
        drawer.classList.remove("open");
        openBtn.setAttribute("aria-expanded", "false");
      })
    );

    // IntersectionObserver for highlighting active drawer link
    const secs = document.querySelectorAll("section[id]"),
      obsSections = new IntersectionObserver(
        (entries) => {
          entries.forEach((en) => {
            const a = document.querySelector(`[data-target='${en.target.id}']`);
            if (en.isIntersecting && a) {
              links.forEach((l) => l.classList.remove("active"));
              a.classList.add("active");
            }
          });
        },
        { threshold: 0.5 }
      );
    secs.forEach((s) => obsSections.observe(s));

    // Count-up animation
    document.querySelectorAll(".count").forEach((el) => {
      const t = +el.dataset.target,
        step = Math.ceil(t / 100);
      let c = 0;
      const update = () => {
        c = Math.min(c + step, t);
        el.textContent = c;
        if (c < t) requestAnimationFrame(update);
      };
      new IntersectionObserver(
        (entries, observer) => {
          if (entries[0].isIntersecting) {
            update();
            observer.disconnect();
          }
        },
        { threshold: 0.5 }
      ).observe(el);
    });

    // Gallery modal functions
    function openModal() {
      document.getElementById("gallery-modal").style.display = "flex";
    }
    function closeModal() {
      document.getElementById("gallery-modal").style.display = "none";
    }
    function showGallery(type) {
      const gallery = {
        Grouping: [
          "{{ asset('images/services.png') }}",
          "{{ asset('images/services.png') }}",
          "{{ asset('images/services.png') }}",
        ],
        LiveTrade: ["livetrade1.jpg"],
        STC: ["stc1.jpg"],
        Events: ["event1.jpg"],
        Competition: ["competition1.jpg"],
      };
      const content = document.getElementById("gallery-content");
      const images = gallery[type] || [];
      const dotsContainer = document.getElementById("gallery-dots");
      if (!images.length) {
        content.innerHTML = `<p class="text-sm text-gray-500 mx-auto">No images for ${type}.</p>`;
        dotsContainer.innerHTML = "";
        return;
      }
      content.innerHTML = images
        .map(
          (img, i) =>
            `<div class="gallery-image-container" data-index="${i}"><img src="${img}" alt="${type}" /></div>`
        )
        .join("");
      dotsContainer.innerHTML = images
        .map((_, i) => `<div class="dot${i === 0 ? " active" : ""}"></div>`)
        .join("");
      content.scrollLeft = 0;
      content.onscroll = () => {
        const idx = Math.round(content.scrollLeft / content.clientWidth);
        document
          .querySelectorAll("#gallery-dots .dot")
          .forEach((d, i) => d.classList.toggle("active", i === idx));
      };
    }

    // Animate elements when they scroll into view (except hero, which is manual)
    document.addEventListener("DOMContentLoaded", () => {
      const animatedEls = document.querySelectorAll(
        ".animate-slide-left, .animate-slide-right, .animate-slide-up, .animate-fade-scale"
      );
      const observerAnim = new IntersectionObserver(
        (entries, obsAnim) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("visible");
              obsAnim.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.3 }
      );
      animatedEls.forEach((el) => observerAnim.observe(el));
    });
  </script>
</body>

</html>
