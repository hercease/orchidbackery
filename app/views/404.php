<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>404 — Orchid Bakery</title>

  <!-- Tailwind (CDN for quick integration). For production, compile Tailwind in your build pipeline. -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Optional: Tailwind config for a more bespoke palette -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ink: {
              950: "#120B10",
              900: "#1C111A",
              800: "#2A1A26"
            },
            orchid: {
              50: "#FFF6FB",
              100: "#FFE8F5",
              200: "#FFC9E8",
              300: "#FF9ED7",
              400: "#FF65C1",
              500: "#F13FAA",
              600: "#D92A8F",
              700: "#B51D75"
            },
            cream: "#FFF6EA",
            cocoa: "#4A2C2A",
          },
          boxShadow: {
            soft: "0 18px 60px rgba(18,11,16,.28)",
            glaze: "inset 0 1px 0 rgba(255,255,255,.25)"
          }
        }
      }
    }
  </script>

  <style>
    /* Small handcrafted touches outside Tailwind */
    @media (prefers-reduced-motion: reduce) {
      .reveal { transition: none !important; transform: none !important; opacity: 1 !important; }
      .floaty { animation: none !important; }
    }

    .grain {
      pointer-events: none;
      position: fixed;
      inset: 0;
      opacity: .09;
      mix-blend-mode: multiply;
      background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='260' height='260'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='260' height='260' filter='url(%23n)' opacity='.35'/%3E%3C/svg%3E");
      background-size: 260px 260px;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0) }
      50% { transform: translateY(-10px) }
    }
    .floaty { animation: float 7s ease-in-out infinite; }

    /* Staggered load reveal */
    .reveal { opacity: 0; transform: translateY(10px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.is-in { opacity: 1; transform: translateY(0); }
  </style>
</head>

<body class="min-h-screen bg-cream text-ink-950 antialiased selection:bg-orchid-200 selection:text-ink-950">
  <!-- Background: warm bakery vibe with subtle “frosting” + cocoa -->
  <div aria-hidden="true" class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-[radial-gradient(1200px_600px_at_20%_15%,rgba(255,101,193,.28),transparent_60%),radial-gradient(900px_520px_at_80%_25%,rgba(241,63,170,.18),transparent_55%),radial-gradient(900px_620px_at_50%_95%,rgba(74,44,42,.16),transparent_55%)]"></div>

    <!-- Decorative SVG sprinkles / piping -->
    <svg class="absolute -top-16 -left-24 w-[520px] max-w-none opacity-70" viewBox="0 0 520 520" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="g1" x1="40" y1="60" x2="420" y2="420" gradientUnits="userSpaceOnUse">
          <stop stop-color="#FF9ED7" stop-opacity=".9"/>
          <stop offset="1" stop-color="#FFF6FB" stop-opacity=".0"/>
        </linearGradient>
      </defs>
      <path d="M84 168c78-86 206-108 308-56 102 52 150 162 116 262-34 100-141 160-253 141C143 496 54 402 54 290c0-45 11-86 30-122Z" fill="url(#g1)"/>
      <path d="M140 132c28 9 49 27 62 53" stroke="#B51D75" stroke-opacity=".55" stroke-width="10" stroke-linecap="round"/>
      <path d="M226 112c34 7 62 27 84 60" stroke="#D92A8F" stroke-opacity=".5" stroke-width="10" stroke-linecap="round"/>
      <path d="M302 132c30 12 56 34 74 66" stroke="#F13FAA" stroke-opacity=".45" stroke-width="10" stroke-linecap="round"/>
    </svg>

    <svg class="absolute -bottom-24 -right-24 w-[560px] max-w-none opacity-70" viewBox="0 0 560 560" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="g2" x1="460" y1="120" x2="120" y2="520" gradientUnits="userSpaceOnUse">
          <stop stop-color="#4A2C2A" stop-opacity=".20"/>
          <stop offset="1" stop-color="#FF65C1" stop-opacity=".0"/>
        </linearGradient>
      </defs>
      <path d="M500 252c-26-118-140-196-264-182C112 84 28 196 52 320c24 124 145 212 274 196 129-16 200-146 174-264Z" fill="url(#g2)"/>
      <path d="M210 396c44 18 92 18 140 0" stroke="#4A2C2A" stroke-opacity=".35" stroke-width="12" stroke-linecap="round"/>
      <path d="M176 342c70 34 138 34 208 0" stroke="#4A2C2A" stroke-opacity=".22" stroke-width="12" stroke-linecap="round"/>
    </svg>

    <div class="grain"></div>
  </div>

  <main class="relative mx-auto flex min-h-screen max-w-6xl items-center px-6 py-16">
    <div class="w-full">
      <!-- Top bar -->
      <header class="reveal flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <a href="dashboard" class="group inline-flex items-center gap-3">
          <span class="relative grid h-11 w-11 place-items-center rounded-2xl bg-white/70 shadow-soft ring-1 ring-black/5 backdrop-blur">
            <!-- Simple orchid mark -->
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M12 21c3.2 0 6-2.2 6-5.6 0-3.1-2.4-4.8-4.9-5.6.2 1.4-.5 2.7-1.9 3.4-1.4-.7-2.1-2-1.9-3.4C6.4 10.6 4 12.3 4 15.4 4 18.8 6.8 21 10 21" stroke="#B51D75" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M12 6.5c1.6 0 2.9-1.2 2.9-2.7C14.9 2.2 13.6 1 12 1S9.1 2.2 9.1 3.8c0 1.5 1.3 2.7 2.9 2.7Z" fill="#FF65C1" fill-opacity=".85"/>
            </svg>
          </span>
          <span class="leading-tight">
            <span class="block text-sm font-semibold tracking-wide text-ink-950">Orchid Bakery</span>
            <span class="block text-xs text-ink-800/70">Fresh bakes • Soft petals • Sweet finds</span>
          </span>
        </a>

        <nav class="flex flex-wrap items-center gap-2">
          <a href="dashboard" class="rounded-full bg-white/70 px-4 py-2 text-sm font-medium text-ink-950 shadow-glaze ring-1 ring-black/5 backdrop-blur transition hover:bg-white hover:shadow-soft focus:outline-none focus-visible:ring-2 focus-visible:ring-orchid-500/70">
            Home
          </a>
          <a href="/contact" class="rounded-full bg-white/40 px-4 py-2 text-sm font-medium text-ink-950 ring-1 ring-black/5 backdrop-blur transition hover:bg-white/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-orchid-500/70">
            Contact
          </a>
        </nav>
      </header>

      <!-- Content grid -->
      <section class="mt-10 grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
        <!-- Left: message -->
        <div class="reveal">
          <div class="inline-flex items-center gap-2 rounded-full bg-white/60 px-3 py-1 text-xs font-semibold tracking-wide text-ink-900 ring-1 ring-black/5 backdrop-blur">
            <span class="h-2 w-2 rounded-full bg-orchid-500"></span>
            Error 404 • Page not found
          </div>

          <h1 class="mt-4 text-balance font-black tracking-tight text-ink-950
                     text-[clamp(2.2rem,5vw,4.2rem)] leading-[0.98]">
            This page didn’t rise.
          </h1>

          <p class="mt-4 max-w-xl text-pretty text-base leading-relaxed text-ink-800/80 sm:text-lg">
            The link you followed might be stale, or the page may have been moved.
            Try searching, or head back to the bakery counter.
          </p>

          <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
            <a href="dashboard" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-ink-950 px-5 py-3 text-sm font-semibold text-cream shadow-soft transition
                               hover:-translate-y-0.5 hover:bg-ink-900 active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-orchid-500/80">
              Back to Dashboard
              <svg class="h-4 w-4 opacity-90 transition group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>

            <button id="copyUrl"
              class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white/70 px-5 py-3 text-sm font-semibold text-ink-950 ring-1 ring-black/5 backdrop-blur transition
                     hover:-translate-y-0.5 hover:bg-white active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-orchid-500/70">
              Copy current URL
              <span id="copyHint" class="text-xs font-medium text-ink-800/70">(for support)</span>
            </button>
          </div>

          <!-- Minimal “help” links -->
          <div class="mt-8 grid gap-3 sm:grid-cols-2">
            <a href="/menu" class="reveal group rounded-2xl bg-white/55 p-4 ring-1 ring-black/5 backdrop-blur transition hover:bg-white/75 hover:shadow-soft">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <p class="text-sm font-semibold text-ink-950">Browse the menu</p>
                  <p class="mt-1 text-sm text-ink-800/70">See today’s breads & pastries.</p>
                </div>
                <span class="mt-1 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-orchid-100 text-orchid-700 ring-1 ring-orchid-200 transition group-hover:bg-orchid-200">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 7h14v14H7V7Z" stroke="currentColor" stroke-width="1.8" opacity=".35"/>
                    <path d="M3 3h14v14H3V3Z" stroke="currentColor" stroke-width="1.8"/>
                  </svg>
                </span>
              </div>
            </a>

            <a href="/contact" class="reveal group rounded-2xl bg-white/55 p-4 ring-1 ring-black/5 backdrop-blur transition hover:bg-white/75 hover:shadow-soft">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <p class="text-sm font-semibold text-ink-950">Contact us</p>
                  <p class="mt-1 text-sm text-ink-800/70">We’ll help you find the right page.</p>
                </div>
                <span class="mt-1 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-orchid-100 text-orchid-700 ring-1 ring-orchid-200 transition group-hover:bg-orchid-200">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M4 7l8 6 8-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </div>
            </a>
          </div>
        </div>

        <!-- Right: big 404 “cake stamp” -->
        <aside class="reveal">
          <div class="relative overflow-hidden rounded-[2.25rem] bg-white/55 p-6 shadow-soft ring-1 ring-black/5 backdrop-blur">
            <div class="absolute inset-0 bg-[radial-gradient(600px_300px_at_30%_20%,rgba(255,101,193,.22),transparent_60%),radial-gradient(500px_260px_at_70%_80%,rgba(74,44,42,.14),transparent_60%)]"></div>

            <div class="relative">
              <div class="flex items-end justify-between gap-6">
                <div>
                  <p class="text-xs font-semibold uppercase tracking-[0.22em] text-ink-800/70">Orchid Bakery</p>
                  <p class="mt-1 text-sm text-ink-800/80">Lost & found, but make it sweet.</p>
                </div>

                <div class="floaty grid h-12 w-12 place-items-center rounded-2xl bg-orchid-100 ring-1 ring-orchid-200 text-orchid-700 shadow-glaze">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 2c2.8 2.2 4.2 4.5 4.2 7 0 2.6-1.5 4.6-4.2 6-2.7-1.4-4.2-3.4-4.2-6 0-2.5 1.4-4.8 4.2-7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M7 20c1.4-1.1 3.1-1.7 5-1.7s3.6.6 5 1.7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                  </svg>
                </div>
              </div>

              <div class="mt-7 grid gap-4">
                <div class="relative rounded-[2rem] bg-gradient-to-b from-ink-950 to-ink-900 p-6 text-cream shadow-soft">
                  <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-orchid-500/25 blur-2xl"></div>
                  <div class="absolute -left-10 -bottom-10 h-36 w-36 rounded-full bg-white/10 blur-2xl"></div>

                  <div class="relative">
                    <div class="flex items-baseline justify-between gap-4">
                      <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cream/70">Status</p>
                      <p class="text-xs font-semibold text-cream/70">#404</p>
                    </div>

                    <div class="mt-3 flex items-end justify-between gap-4">
                      <p class="font-black tracking-tight text-[clamp(3.2rem,7vw,5.4rem)] leading-none">
                        404
                      </p>

                      <!-- “Frosting” badge -->
                      <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/10 backdrop-blur">
                        <p class="text-xs font-semibold text-cream/80">Suggestion</p>
                        <p class="mt-1 text-sm font-semibold">Try the homepage.</p>
                      </div>
                    </div>

                    <!-- Decorative cake-ish lines -->
                    <div class="mt-6 grid gap-3">
                      <div class="h-3 rounded-full bg-white/10"></div>
                      <div class="h-3 rounded-full bg-white/10 w-11/12"></div>
                      <div class="h-3 rounded-full bg-white/10 w-10/12"></div>
                    </div>
                  </div>
                </div>

                <!-- Search (client-side demo) -->
                <form id="searchForm" class="rounded-[2rem] bg-white/55 p-5 ring-1 ring-black/5 backdrop-blur">
                  <label for="q" class="block text-sm font-semibold text-ink-950">Search the site</label>
                  <div class="mt-3 flex gap-3">
                    <input id="q" name="q" type="search" placeholder="Try “croissants”, “menu”, “hours”…"
                      class="w-full rounded-2xl bg-white/70 px-4 py-3 text-sm text-ink-950 placeholder:text-ink-800/45 ring-1 ring-black/5 outline-none transition
                             focus:ring-2 focus:ring-orchid-500/60"
                      autocomplete="off" />
                    <button type="submit"
                      class="shrink-0 rounded-2xl bg-orchid-600 px-4 py-3 text-sm font-semibold text-white shadow-glaze ring-1 ring-black/5 transition
                             hover:-translate-y-0.5 hover:bg-orchid-500 active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-orchid-500/70">
                      Search
                    </button>
                  </div>

                  <p id="searchNote" class="mt-3 text-xs text-ink-800/70">
                    Tip: If you’re seeing redirect errors, check your <span class="font-semibold">.htaccess</span> / route rules for the 404 handler.
                  </p>
                </form>
              </div>
            </div>
          </div>

          <p class="mt-4 text-xs text-ink-800/60">
            If this keeps happening, the page might be caught in a redirect loop (your screenshot shows <span class="font-semibold">ERR_TOO_MANY_REDIRECTS</span>).
          </p>
        </aside>
      </section>

      <footer class="reveal mt-12 flex flex-col gap-3 border-t border-black/5 pt-6 text-sm text-ink-800/70 sm:flex-row sm:items-center sm:justify-between">
        <p>© <span id="year"></span> Orchid Royal Bakery. All crumbs reserved.</p>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
          <a class="underline decoration-black/20 underline-offset-4 hover:decoration-black/40" href="/">Home</a>
          <a class="underline decoration-black/20 underline-offset-4 hover:decoration-black/40" href="/contact">Contact</a>
        </div>
      </footer>
    </div>
  </main>

  <script>
    // Year
    document.getElementById('year').textContent = new Date().getFullYear();

    // Staggered reveal on load + on scroll
    const revealEls = Array.from(document.querySelectorAll('.reveal'));
    revealEls.forEach((el, i) => {
      el.style.transitionDelay = `${Math.min(i * 80, 520)}ms`;
    });

    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('is-in');
      });
    }, { threshold: 0.12 });

    revealEls.forEach(el => io.observe(el));

    // Copy URL
    const copyBtn = document.getElementById('copyUrl');
    const copyHint = document.getElementById('copyHint');

    copyBtn?.addEventListener('click', async () => {
      const text = window.location.href;
      try {
        await navigator.clipboard.writeText(text);
        copyHint.textContent = "Copied!";
        copyHint.classList.remove("text-ink-800/70");
        copyHint.classList.add("text-orchid-700");
        setTimeout(() => {
          copyHint.textContent = "(for support)";
          copyHint.classList.add("text-ink-800/70");
          copyHint.classList.remove("text-orchid-700");
        }, 1400);
      } catch (e) {
        // Fallback
        prompt("Copy this URL:", text);
      }
    });

    // Simple search behavior (redirect to /search?q=... if you have it; otherwise to /?q=...)
    const form = document.getElementById('searchForm');
    const input = document.getElementById('q');
    form?.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const q = (input.value || "").trim();
      if (!q) {
        input.focus();
        return;
      }
      // Adjust this to your real route:
      const target = `/search?q=${encodeURIComponent(q)}`;
      window.location.href = target;
    });
  </script>
</body>
</html>