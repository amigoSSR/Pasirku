<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>QUARRY DIRECT | Messages</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
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

  @include('topbar')

  <div class="flex h-screen pt-[64px]">

    <!-- SideNavBar (Desktop Only) — fixed kiri -->
    <aside class="hidden md:flex flex-col w-64 flex-shrink-0 bg-slate-100 py-8 overflow-y-auto border-r border-slate-200">
      <div class="px-6 mb-8">
        <h2 class="text-2xl font-black text-blue-900">Industrial Hub</h2>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-1">Verified Seller</p>
      </div>
      <nav class="flex-1 space-y-1">
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 transition-colors"
          href="{{ route('MenuUtama') }}">
          <span class="material-symbols-outlined mr-4" data-icon="storefront">storefront</span>
          <span class="font-bold">Marketplace</span>
        </a>
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 transition-colors"
          href="{{ route('ordertracking') }}">
          <span class="material-symbols-outlined mr-4" data-icon="local_shipping">local_shipping</span>
          <span class="font-bold">Active Orders</span>
        </a>
        <a class="flex items-center px-6 py-4 text-blue-900 font-bold border-r-4 border-blue-900 bg-white/50"
          href="#">
          <span class="material-symbols-outlined mr-4" data-icon="forum">forum</span>
          <span>Messages</span>
        </a>
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 transition-colors"
          href="{{ route('Profil') }}">
          <span class="material-symbols-outlined mr-4" data-icon="person">person</span>
          <span class="font-bold">Profile</span>
        </a>
      </nav>
      <div class="px-6 mt-auto">
        <button
          class="w-full bg-gradient-to-br from-primary to-primary-container text-white py-3 px-4 rounded-md font-bold text-sm tracking-tight transition-transform active:scale-95">
          Register Quarry
        </button>
      </div>
    </aside>

    <!-- Area Konten: Chat List + Chat Window -->
    <main class="flex flex-1 overflow-hidden" x-data="chatComponent()" x-init="init()">
        <!-- Chat History Sidebar -->
        <section class="bg-surface-container-low flex flex-col h-full overflow-hidden w-[380px] flex-shrink-0">
            <div class="p-6">
                <h3 class="headline text-2xl font-bold tracking-tight text-on-surface">Conversations</h3>
                <div class="mt-4 relative">
                    <input class="w-full bg-white border-none rounded-lg px-4 py-3 text-sm shadow-sm focus:ring-1 focus:ring-primary/20" placeholder="Filter chats..." type="text" x-model="search" />
                    <span class="material-symbols-outlined absolute right-3 top-3 text-slate-400 text-xl" data-icon="filter_list">filter_list</span>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto space-y-px">
                <template x-for="contact in filteredContacts" :key="contact.ID_Akun">
                    <!-- Chat Item -->
                    <div @click="selectContact(contact)" :class="{'bg-white after:absolute after:left-0 after:top-0 after:h-full after:w-1 after:bg-primary': selectedContact && selectedContact.ID_Akun === contact.ID_Akun, 'hover:bg-white/50': !selectedContact || selectedContact.ID_Akun !== contact.ID_Akun}" class="px-6 py-5 cursor-pointer relative transition-colors">
                        <div class="flex gap-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-12 h-12 rounded-xl object-cover bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-xl uppercase" x-text="contact.Username.charAt(0)"></div>
                                <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-on-surface truncate" x-text="contact.Username"></h4>
                                </div>
                                <p class="text-sm text-on-surface-variant truncate">Mulai percakapan...</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- Active Chat Window -->
        <section class="flex flex-col flex-1 h-full bg-white relative">
            <template x-if="selectedContact">
                <div class="flex flex-col h-full">
                    <!-- Chat Header -->
                    <div class="px-8 py-5 flex justify-between items-center bg-white z-10 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div>
                                <h3 class="headline text-xl font-bold text-on-surface leading-tight" x-text="selectedContact.Username"></h3>
                                <p class="text-xs text-secondary font-bold uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Online
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div class="flex-1 overflow-y-auto p-8 space-y-8 bg-surface-container-lowest" id="messages-container">
                        <template x-for="msg in messages" :key="msg.id">
                            <div class="flex gap-4 max-w-[80%]" :class="msg.sender_id === {{ Auth::id() }} ? 'ml-auto flex-row-reverse' : ''">
                                <div>
                                    <div class="px-5 py-4 shadow-sm" :class="msg.sender_id === {{ Auth::id() }} ? 'bg-gradient-to-br from-primary to-primary-container text-white rounded-l-2xl rounded-br-2xl' : 'bg-surface-container-high text-on-surface rounded-r-2xl rounded-bl-2xl'">
                                        <p class="leading-relaxed" x-text="msg.message"></p>
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-400 mt-2 block uppercase" :class="msg.sender_id === {{ Auth::id() }} ? 'text-right mr-1' : 'ml-1'" x-text="new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-8 bg-white">
                        <form @submit.prevent="sendMessage" class="relative bg-surface-container-low rounded-2xl p-2 flex items-end gap-2 shadow-sm focus-within:ring-2 focus-within:ring-primary/10 transition-shadow">
                            <input x-model="newMessage" class="flex-1 bg-transparent border-none focus:ring-0 py-3 text-on-surface resize-none" placeholder="Ketik pesan..." required autocomplete="off" />
                            <div class="flex items-center gap-1">
                                <button type="submit" class="w-12 h-12 bg-primary text-white rounded-xl flex items-center justify-center shadow-lg hover:bg-primary-container transition-all active:scale-90" :disabled="isSending">
                                    <span class="material-symbols-outlined" data-icon="send">send</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>
            <template x-if="!selectedContact">
                <div class="flex-1 flex flex-col items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined text-6xl mb-4">forum</span>
                    <p>Pilih percakapan untuk mulai mengirim pesan</p>
                </div>
            </template>
        </section>
    </main><!-- end area konten -->

    <script>
        function chatComponent() {
            return {
                contacts: [],
                search: '',
                selectedContact: null,
                messages: [],
                newMessage: '',
                isSending: false,
                pollingInterval: null,

                get filteredContacts() {
                    if (this.search === '') return this.contacts;
                    return this.contacts.filter(contact =>
                        contact.Username.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                init() {
                    this.fetchContacts();
                },

                fetchContacts() {
                    fetch('{{ route('chat.contacts') }}')
                        .then(res => res.json())
                        .then(data => {
                            this.contacts = data;

                            // Restore kontak yang dipilih sebelumnya dari localStorage
                            const savedContactId = localStorage.getItem('chat_selected_contact_id');
                            if (savedContactId) {
                                const saved = data.find(c => c.ID_Akun == savedContactId);
                                if (saved) {
                                    this.selectContact(saved);
                                }
                            }
                        });
                },

                selectContact(contact) {
                    this.selectedContact = contact;

                    // Simpan ke localStorage agar terpilih kembali saat reload
                    localStorage.setItem('chat_selected_contact_id', contact.ID_Akun);

                    this.fetchMessages(true);

                    if (this.pollingInterval) {
                        clearInterval(this.pollingInterval);
                    }

                    // Polling pesan baru setiap 3 detik
                    this.pollingInterval = setInterval(() => {
                        this.fetchMessages(false);
                    }, 3000);
                },

                fetchMessages(scrollToBottom = true) {
                    if (!this.selectedContact) return;

                    fetch(`/chat/messages/${this.selectedContact.ID_Akun}`)
                        .then(res => res.json())
                        .then(data => {
                            const prevLength = this.messages.length;
                            this.messages = data;

                            if (scrollToBottom || prevLength !== data.length) {
                                setTimeout(() => {
                                    const container = document.getElementById('messages-container');
                                    if (container) container.scrollTop = container.scrollHeight;
                                }, 100);
                            }
                        });
                },

                sendMessage() {
                    if (this.newMessage.trim() === '' || !this.selectedContact || this.isSending) return;

                    this.isSending = true;

                    fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: this.selectedContact.ID_Akun,
                            message: this.newMessage
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.messages.push(data);
                        this.newMessage = '';
                        this.isSending = false;

                        setTimeout(() => {
                            const container = document.getElementById('messages-container');
                            if (container) container.scrollTop = container.scrollHeight;
                        }, 50);
                    })
                    .catch(() => {
                        this.isSending = false;
                    });
                }
            }
        }
    </script>

  </div><!-- end flex wrapper -->
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