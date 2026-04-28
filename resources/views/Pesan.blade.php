<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>QUARRY DIRECT | Messages</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Public+Sans:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <style>
   html {
      font-size: 90%;
    }
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    body {
      font-family: 'Public Sans', sans-serif;
    }

    h1, h2, h3, h4, .headline {
      font-family: 'Manrope', sans-serif;
    }

    .strata-grid {
      display: grid;
      grid-template-columns: 256px 380px 1fr;
      height: 100vh;
    }

    @media (max-width: 1024px) {
      .strata-grid {
        grid-template-columns: 80px 1fr;
      }

      .sidebar-text {
        display: none;
      }
    }

    @media (max-width: 768px) {
      .strata-grid {
        grid-template-columns: 1fr;
      }

      .side-nav-desktop {
        display: none;
      }
    }
  </style>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "surface-variant": "#d3e4fe",
            "on-surface": "#0b1c30",
            "on-secondary-fixed-variant": "#623f18",
            "primary-container": "#005fb8",
            "on-background": "#0b1c30",
            "on-tertiary-container": "#fcd1c4",
            "surface": "#f8f9ff",
            "surface-dim": "#cbdbf5",
            "secondary": "#7d562d",
            "surface-container-low": "#eff4ff",
            "on-primary-fixed": "#001b3d",
            "inverse-on-surface": "#eaf1ff",
            "surface-tint": "#005db5",
            "inverse-surface": "#213145",
            "outline": "#727783",
            "on-primary-fixed-variant": "#00468b",
            "on-tertiary-fixed-variant": "#5d4037",
            "tertiary-container": "#78584e",
            "background": "#f8f9ff",
            "error": "#ba1a1a",
            "on-primary": "#ffffff",
            "surface-container-highest": "#d3e4fe",
            "on-secondary": "#ffffff",
            "primary-fixed": "#d6e3ff",
            "on-secondary-container": "#7a532a",
            "on-error-container": "#93000a",
            "surface-container-lowest": "#ffffff",
            "secondary-fixed-dim": "#f0bd8b",
            "tertiary-fixed-dim": "#e7bdb1",
            "on-primary-container": "#cadcff",
            "error-container": "#ffdad6",
            "on-secondary-fixed": "#2c1600",
            "primary-fixed-dim": "#a8c8ff",
            "surface-container": "#e5eeff",
            "on-surface-variant": "#424752",
            "secondary-container": "#ffca98",
            "surface-container-high": "#dce9ff",
            "on-tertiary-fixed": "#2c160e",
            "primary": "#00488d",
            "outline-variant": "#c2c6d4",
            "surface-bright": "#f8f9ff",
            "tertiary": "#5e4138",
            "inverse-primary": "#a8c8ff",
            "secondary-fixed": "#ffdcbd",
            "on-tertiary": "#ffffff",
            "tertiary-fixed": "#ffdbd0",
            "on-error": "#ffffff",
          },
          borderRadius: {
            "DEFAULT": "0.125rem",
            "lg": "0.25rem",
            "xl": "0.5rem",
            "full": "0.75rem",
          },
          fontFamily: {
            "headline": ["Manrope"],
            "body": ["Public Sans"],
            "label": ["Public Sans"],
          },
        },
      },
    };
  </script>
</head>

<body class="bg-background text-on-background antialiased overflow-hidden">

  <!-- TopNavBar -->
  <header
    class="fixed top-0 left-0 w-full z-50 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-lg flex justify-between items-center px-6 py-3">
    <div class="flex items-center gap-4">
      <span class="text-xl font-black tracking-tighter text-blue-900 dark:text-blue-100">QUARRY DIRECT</span>
    </div>
    <div class="hidden md:flex items-center gap-8 flex-1 max-w-xl mx-12">
      <div class="relative w-full">
        <input
          class="w-full bg-surface-container-high border-none rounded-xl px-4 py-2 text-on-surface-variant focus:ring-2 focus:ring-primary"
          placeholder="Search orders or materials..." type="text" />
      </div>
    </div>
    <div class="flex items-center gap-4">
      <button
        class="material-symbols-outlined p-2 text-blue-900 hover:bg-slate-200/50 rounded-full transition-transform duration-150 scale-95"
        data-icon="notifications">notifications</button>
      <button
        class="material-symbols-outlined p-2 text-blue-900 bg-blue-100/50 rounded-full transition-transform duration-150 scale-95"
        data-icon="chat_bubble">chat_bubble</button>
      <div class="w-10 h-10 rounded-full bg-surface-container-highest overflow-hidden">
        <img
          alt="Profile"
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuBom06Nk1iSHcgqjxc4u9qswCF3jzOGMN-pGvQFg6Ue6g5Q_Q_z7M8TDKOEwUAGjxRn6e3IppPgvkFcUMv64g_zPhwZADCJnLxKhlrU8BiGXbwWeZs8RWwS9RY3dvD6qbIxWha_-niBsmZfmBjqg0YWR7z1RBiVyjK_xhA9gO6GGE6YCu0JSeNk1njxmZonOMRWiALP1o1HHdUNj3ZedH6HVMfhY-kmHm-C-HXZ1FTuYJWrzPNpIPilJCdfToCgVmXYV06h8Q55tw" />
      </div>
    </div>
  </header>

  <main class="strata-grid pt-[64px]">

    <!-- SideNavBar (Desktop Only) -->
    <aside
      class="side-nav-desktop hidden md:flex flex-col h-full py-8 bg-slate-100 dark:bg-slate-950 border-r-0 overflow-y-auto">
      <div class="px-6 mb-8">
        <h2 class="text-2xl font-black text-blue-900 dark:text-white">Industrial Hub</h2>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-1">Verified Seller</p>
      </div>
      <nav class="flex-1 space-y-1">
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors group"
          href="{{ route('home') }}">
          <span class="material-symbols-outlined mr-4" data-icon="storefront">storefront</span>
          <span class="font-bold text-slate-500">Marketplace</span>
        </a>
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors group"
          href="#">
          <span class="material-symbols-outlined mr-4" data-icon="local_shipping">local_shipping</span>
          <span class="font-bold text-slate-500">Active Orders</span>
        </a>
        <a class="flex items-center px-6 py-4 text-blue-900 dark:text-white font-bold border-r-4 border-blue-900 dark:border-blue-400 bg-white/50 dark:bg-white/5 group"
          href="#">
          <span class="material-symbols-outlined mr-4" data-icon="forum">forum</span>
          <span class="sidebar-text">Messages</span>
        </a>
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors group"
          href="#">
          <span class="material-symbols-outlined mr-4" data-icon="settings">settings</span>
          <span class="font-bold text-slate-500">Settings</span>
        </a>
      </nav>
      <div class="px-6 mt-auto">
        <button
          class="w-full bg-gradient-to-br from-primary to-primary-container text-white py-3 px-4 rounded-md font-bold text-sm tracking-tight transition-transform active:scale-95">
          Register Quarry
        </button>
      </div>
    </aside>

    <!-- Chat History Sidebar -->
    <section class="bg-surface-container-low flex flex-col h-full overflow-hidden">
      <div class="p-6">
        <h3 class="headline text-2xl font-bold tracking-tight text-on-surface">Conversations</h3>
        <div class="mt-4 relative">
          <input
            class="w-full bg-white border-none rounded-lg px-4 py-3 text-sm shadow-sm focus:ring-1 focus:ring-primary/20"
            placeholder="Filter chats..." type="text" />
          <span class="material-symbols-outlined absolute right-3 top-3 text-slate-400 text-xl"
            data-icon="filter_list">filter_list</span>
        </div>
      </div>
      <div class="flex-1 overflow-y-auto space-y-px">

        <!-- Chat Item Active -->
        <div
          class="bg-white px-6 py-5 cursor-pointer relative after:absolute after:left-0 after:top-0 after:h-full after:w-1 after:bg-primary">
          <div class="flex gap-4">
            <div class="relative flex-shrink-0">
              <img
                alt="Shop Owner"
                class="w-12 h-12 rounded-xl object-cover"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDkaBfjIM1e72HvJx70tmc621JEc-hDI43sC4KtGoVKx4U_ocmrAlqlMRzpI_zqbt1U_kyK0myFL8O_1SJvn3lWab_dLD4A4YQ-o-2Uqo2shyz1XED7mLR6WH14EbnczY-N8kd4G1ivN4TN4DQqRjsH_pljSdVMzDegWzDVHr6KSO0MaNcVjINuE6mYMs0IVzqIHZuj2jR40wFYbL6UO_n7-tTcAUbj9phi786ORCySlgE8qp3R5DWHN1dvjExWoLTBg5AMqx8ITA" />
              <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-start mb-1">
                <h4 class="font-bold text-on-surface truncate">Atlas Aggregates</h4>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">14:20</span>
              </div>
              <p class="text-sm text-primary font-semibold truncate italic">"The washed river sand is ready for..."</p>
              <div class="mt-2 flex items-center gap-2">
                <span
                  class="px-2 py-0.5 bg-blue-50 text-[10px] font-bold text-primary rounded-full uppercase tracking-widest">Order
                  #QU-298</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Item -->
        <div class="hover:bg-white/50 px-6 py-5 cursor-pointer transition-colors">
          <div class="flex gap-4">
            <img
              alt="Shop Owner"
              class="w-12 h-12 rounded-xl object-cover"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuB4qg5eeNx_dbV3UlaI_30hVjMmGPPo6eXnIahAhfhLyTyjz-f0fN_tf5iXEhx35tRGCGOGa5QlStLk_4e19xvGllXwvkTu9QVgc0BecN0OJ9AQzfnE4TjAEZNg6nzYBR_pntS1bqsfIP7jUjXWTUV_rhscWnSO6VHMlmpXyoVeS6z7gcBvd7JOvVvhiS2PiXDYTEmjeTY_flwYnBrQ_AG76WUh4mmahV51N7tFQIVHpG3JntQPgkeOfLXmur4PxftcYhU5EEG6TQ" />
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-start mb-1">
                <h4 class="font-bold text-on-surface truncate">Summit Materials</h4>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Yesterday</span>
              </div>
              <p class="text-sm text-on-surface-variant truncate">Quote for 50 tons of silica sand is attached.</p>
            </div>
          </div>
        </div>

        <!-- Chat Item -->
        <div class="hover:bg-white/50 px-6 py-5 cursor-pointer transition-colors">
          <div class="flex gap-4">
            <img
              alt="Shop Owner"
              class="w-12 h-12 rounded-xl object-cover"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuAbf2W4u_YhQzbEKfiF0zmKg0fAp3lOUGlSIraBYmykL3JzwSlc8w2rFiQf3gU-lWabZBNmUiQr1Ty6qL3sIGvDbDKSeW8ANqYZiEft9JzZvQUUSuOshZSxGCMO6ATS6xWtAzGjs0N0dZmZcJ31XWkzdC6Akeya-QH2KU2dxms1Mj9H8kbq4VNz-YMEivTKQtUBfZ_bGRoQoQ_DjtQ5VhZjSSh3EZVS8BR6fkwljfb7On--UP74-uexhP6UAZKMBS043XOPsvS2-A" />
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-start mb-1">
                <h4 class="font-bold text-on-surface truncate">Stone &amp; Silt Co.</h4>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Mon</span>
              </div>
              <p class="text-sm text-on-surface-variant truncate">Confirming the delivery window for Thursday.</p>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- Active Chat Window -->
    <section class="flex flex-col h-full bg-white">

      <!-- Chat Header -->
      <div class="px-8 py-5 flex justify-between items-center bg-white z-10">
        <div class="flex items-center gap-4">
          <div>
            <h3 class="headline text-xl font-bold text-on-surface leading-tight">Atlas Aggregates</h3>
            <p class="text-xs text-secondary font-bold uppercase tracking-wider flex items-center gap-1">
              <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
              Online | verified supplier
            </p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors material-symbols-outlined"
            data-icon="search">search</button>
          <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors material-symbols-outlined"
            data-icon="call">call</button>
          <button
            class="px-4 py-2 bg-slate-100 text-slate-700 font-bold text-sm rounded-lg hover:bg-slate-200 transition-colors">Order
            Details</button>
        </div>
      </div>

      <!-- Messages Area -->
      <div class="flex-1 overflow-y-auto p-8 space-y-8 bg-surface-container-lowest">

        <!-- Timestamp Separator -->
        <div class="flex items-center gap-4 py-4">
          <div class="flex-1 h-px bg-slate-200"></div>
          <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Wednesday, October 25</span>
          <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <!-- Recipient Message -->
        <div class="flex gap-4 max-w-[80%]">
          <img
            alt="Atlas Aggregates"
            class="w-8 h-8 rounded-lg mt-1"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuArESAFROPv0MO1Y1fz_yY5I9FhD8n0-TOZmHhth-rkXU6A-yFmkpS6ogj38z0aHkHqA9aMIR06TmzG98B26rth_5T-6d0Ppum3V8PZT_GQWeQk3SryDhM07BUt2PkDZybARdqZ2zcE2RRifdzmicHN10Wi0rHSPveSWgHGDTbjABTv0905vC2T8kqLawFDMOsM4wbKl91XTzFyBqaA9vtph97VGFCT9ar6BXInEznytYuhleCqi3uZm9_XRAHOX5-zBlpe4AA_RA" />
          <div>
            <div class="bg-surface-container-high px-5 py-4 rounded-r-2xl rounded-bl-2xl">
              <p class="text-on-surface leading-relaxed">Hello! We've received your request for the fine-grade washed
                river sand. We have 40 tons currently in stock at our North Quarry location.</p>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 mt-2 block ml-1 uppercase">10:45 AM</span>
          </div>
        </div>

        <!-- User Message -->
        <div class="flex flex-row-reverse gap-4 max-w-[80%] ml-auto">
          <div class="flex flex-col items-end">
            <div
              class="bg-gradient-to-br from-primary to-primary-container text-white px-5 py-4 rounded-l-2xl rounded-br-2xl shadow-md">
              <p class="leading-relaxed">That's great. Can you confirm if this matches the ASTM C33 specifications for
                concrete sand? Also, what's the earliest delivery window for the full 40 tons?</p>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 mt-2 block mr-1 uppercase">11:12 AM · Sent</span>
          </div>
        </div>

        <!-- Recipient Message with Attachment -->
        <div class="flex gap-4 max-w-[80%]">
          <img
            alt="Atlas Aggregates"
            class="w-8 h-8 rounded-lg mt-1"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD7m1xuIm8GwLdXapFo_L0x37yjjXR4C5IqpFSs8o5HA14DuwdCx30KJ7iEFAAa2vhAK0vnMpVDonltCp_t1M4i566Dfph78ELt8rn8tZpETgnWuVgLIn1xDLqXvKe6WiTymlbQoj5dhjWAVE0LHJA12EHmPFeGkco8ogh8uQMxwjYmc4U-EmkrSRJbn-Dnn-gzvRw_-1HjF0WGx3MYI-RdDRsTBCKozk5gOIPibAozWaPkRSixDHoF9Uzq4KPTspNZTNnCCRv4cQ" />
          <div>
            <div class="bg-surface-container-high px-5 py-4 rounded-r-2xl rounded-bl-2xl space-y-4">
              <p class="text-on-surface leading-relaxed">Yes, it fully complies with ASTM C33. I've attached the latest
                lab report from yesterday's batch. We can schedule a three-truck convoy for tomorrow morning between
                08:00 and 10:00.</p>
              <div
                class="bg-white rounded-xl p-3 border border-slate-200 flex items-center gap-3 cursor-pointer hover:border-primary/30 transition-colors">
                <span class="material-symbols-outlined text-red-500 text-3xl"
                  data-icon="picture_as_pdf">picture_as_pdf</span>
                <div class="flex-1">
                  <p class="text-xs font-bold text-on-surface truncate">Lab_Report_WashedSand_B22.pdf</p>
                  <p class="text-[10px] text-slate-500 uppercase font-semibold">1.2 MB · PDF Document</p>
                </div>
                <span class="material-symbols-outlined text-slate-400" data-icon="download">download</span>
              </div>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 mt-2 block ml-1 uppercase">14:15 PM</span>
          </div>
        </div>

        <!-- Recipient Typing Indicator -->
        <div class="flex gap-4 max-w-[80%]">
          <img
            alt="Atlas Aggregates"
            class="w-8 h-8 rounded-lg"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_y3hbp68JPBHmf7kmgflNxC8lXpw_TzmpbKe9WEM9L6TwPY4mG_bOfpjSwFyOKSVdveByTJ0FqV055g3y8UvJ8fOGlAVt3_9ED31P1EkP0CbuySjMdoD6XFnuOP72OxWH1cpEkiaLCnXgWFG4wM4VD8Igs0QSWWJhm8W0qskl9NnOmQR-l_W6bOQt_HrzjLUudyP5hvetkjnHs7Sec9VnUKxSSnQQm1g48eS2wmYbvhVsMHv0Ma4L1vY3W5QjlDzbW0NqZ15ZOA" />
          <div class="bg-slate-100 px-4 py-2 rounded-full flex gap-1 items-center">
            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span>
            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
          </div>
        </div>

      </div>

      <!-- Chat Input -->
      <div class="p-8 bg-white">
        <div
          class="relative bg-surface-container-low rounded-2xl p-2 flex items-end gap-2 shadow-sm focus-within:ring-2 focus-within:ring-primary/10 transition-shadow">
          <button class="p-3 text-slate-400 hover:text-primary transition-colors material-symbols-outlined"
            data-icon="attach_file">attach_file</button>
          <textarea
            class="flex-1 bg-transparent border-none focus:ring-0 py-3 text-on-surface resize-none max-h-32 min-h-[48px]"
            placeholder="Type your message about Order #QU-298..." rows="1"></textarea>
          <div class="flex items-center gap-1">
            <button class="p-3 text-slate-400 hover:text-primary transition-colors material-symbols-outlined"
              data-icon="mood">mood</button>
            <button
              class="w-12 h-12 bg-primary text-white rounded-xl flex items-center justify-center shadow-lg hover:bg-primary-container transition-all active:scale-90">
              <span class="material-symbols-outlined" data-icon="send">send</span>
            </button>
          </div>
        </div>
      </div>

    </section>

  </main>

  <!-- BottomNavBar (Mobile Only) -->
  <nav
    class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-slate-50/80 backdrop-blur-xl flex justify-around items-center px-4 pb-6 pt-2 shadow-[0px_-8px_24px_rgba(11,28,48,0.05)] rounded-t-xl">
    <div class="flex flex-col items-center justify-center text-slate-500 px-6 py-1">
      <span class="material-symbols-outlined" data-icon="trolley">trolley</span>
      <span class="text-[10px] font-bold uppercase mt-1">Home</span>
    </div>
    <div class="flex flex-col items-center justify-center text-slate-500 px-6 py-1">
      <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
      <span class="text-[10px] font-bold uppercase mt-1">Cart</span>
    </div>
    <div class="flex flex-col items-center justify-center text-slate-500 px-6 py-1">
      <span class="material-symbols-outlined" data-icon="forum"
        style="font-variation-settings: 'FILL' 1;">forum</span>
      <span class="text-[10px] font-bold uppercase mt-1">Messages</span>
    </div>
    <div class="flex flex-col items-center justify-center text-slate-500 px-6 py-1">
      <span class="material-symbols-outlined" data-icon="person">person</span>
      <span class="text-[10px] font-bold uppercase mt-1">Profile</span>
    </div>
  </nav>

</body>

</html>