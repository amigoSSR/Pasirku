<x-layout-store title="Store Messages" :fullHeight="true">

  {{-- Full-height chat layout: no standard header, sidebar+topbar from layout --}}
  <div class="flex flex-1 overflow-hidden h-full" x-data="chatComponent()" x-init="init()">

    {{-- Contact List Panel --}}
    <section class="bg-surface-container-lowest border-r border-outline-variant/30 flex flex-col h-full w-[320px] lg:w-[360px] shrink-0 shadow-sm z-10">
      <div class="p-5 border-b border-outline-variant/20">
        <h3 class="font-headline text-xl font-bold text-on-surface mb-1">Messages</h3>
        <p class="text-xs text-on-surface-variant mb-4">Chat dengan pelanggan & supplier</p>
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
          <input class="w-full bg-surface-container-low border border-outline-variant/50 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Cari percakapan..." type="text" x-model="search" />
        </div>
      </div>

      <div class="flex-1 overflow-y-auto divide-y divide-outline-variant/10">
        <template x-for="contact in filteredContacts" :key="contact.id">
          <div @click="selectContact(contact)"
               :class="selectedContact && selectedContact.id === contact.id
                  ? 'bg-primary/5 border-l-4 border-l-primary'
                  : 'bg-transparent border-l-4 border-l-transparent hover:bg-surface-container-low'"
               class="px-5 py-4 cursor-pointer transition-all duration-200">
            <div class="flex items-center gap-3">
              <div class="relative shrink-0">
                <div class="w-11 h-11 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-base uppercase shadow-sm" x-text="contact.name.charAt(0)"></div>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-surface-container-lowest rounded-full"></span>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex justify-between items-baseline mb-0.5">
                  <h4 class="font-semibold text-on-surface truncate text-[14px]" :class="selectedContact && selectedContact.id === contact.id ? 'text-primary' : ''" x-text="contact.name"></h4>
                  <span class="text-[10px] font-semibold text-on-surface-variant shrink-0 ml-2">Baru saja</span>
                </div>
                <p class="text-[12px] text-on-surface-variant truncate">Mulai percakapan...</p>
              </div>
            </div>
          </div>
        </template>
        <template x-if="filteredContacts.length === 0">
          <div class="p-8 text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-4xl mb-2 block opacity-40">search_off</span>
            <p class="text-sm">Tidak ada percakapan ditemukan.</p>
          </div>
        </template>
      </div>
    </section>

    {{-- Chat Window --}}
    <section class="flex flex-col flex-1 h-full relative bg-[#f4f2f0]">
      <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: radial-gradient(#944a00 1px, transparent 1px); background-size: 20px 20px;"></div>

      <template x-if="selectedContact">
        <div class="flex flex-col h-full relative z-10">
          {{-- Chat Header --}}
          <div class="px-6 py-4 flex justify-between items-center bg-surface-container-lowest border-b border-outline-variant/30 shadow-sm z-20">
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold uppercase shadow-sm" x-text="selectedContact.name.charAt(0)"></div>
              <div>
                <h3 class="font-headline text-base font-bold text-on-surface leading-tight" x-text="selectedContact.name"></h3>
                <p class="text-[11px] text-green-600 font-bold uppercase tracking-wider flex items-center gap-1 mt-0.5">
                  <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Sedang Online
                </p>
              </div>
            </div>
            <div class="flex gap-1">
              <button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">receipt_long</span>
              </button>
              <button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">more_vert</span>
              </button>
            </div>
          </div>

          {{-- Messages Area --}}
          <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
            <div class="flex justify-center mb-4">
              <span class="bg-surface-container border border-outline-variant/50 text-on-surface-variant text-xs font-semibold px-4 py-1.5 rounded-full shadow-sm">
                Percakapan diamankan dengan enkripsi end-to-end
              </span>
            </div>
            <template x-for="msg in messages" :key="msg.id">
              <div class="flex w-full" :class="msg.sender_id === {{ Auth::id() }} ? 'justify-end' : 'justify-start'">
                <div class="max-w-[72%] flex flex-col" :class="msg.sender_id === {{ Auth::id() }} ? 'items-end' : 'items-start'">
                  <div class="px-5 py-3 shadow-sm text-[14px]"
                       :class="msg.sender_id === {{ Auth::id() }}
                          ? 'bg-primary text-on-primary rounded-2xl rounded-tr-sm'
                          : 'bg-surface-container-lowest border border-outline-variant/30 text-on-surface rounded-2xl rounded-tl-sm'">
                    <p class="leading-relaxed whitespace-pre-wrap break-words" x-text="msg.message"></p>
                  </div>
                  <span class="text-[10px] font-bold text-on-surface-variant mt-1.5 flex items-center gap-1"
                        :class="msg.sender_id === {{ Auth::id() }} ? 'flex-row-reverse' : ''">
                    <span x-text="new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                    <span x-show="msg.sender_id === {{ Auth::id() }}" class="material-symbols-outlined text-[14px] text-primary">done_all</span>
                  </span>
                </div>
              </div>
            </template>
          </div>

          {{-- Chat Input --}}
          <div class="p-4 bg-surface-container-lowest border-t border-outline-variant/30 z-20">
            <form @submit.prevent="sendMessage" class="flex items-end gap-3 max-w-4xl mx-auto">
              <button type="button" class="shrink-0 w-11 h-11 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">attach_file</span>
              </button>
              <div class="flex-1 bg-surface-container-low border border-outline-variant/50 rounded-2xl flex items-end p-1.5 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                <textarea x-model="newMessage" @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()" class="flex-1 bg-transparent border-none focus:ring-0 py-2.5 px-3 text-sm text-on-surface resize-none max-h-32 min-h-[44px]" placeholder="Ketik pesan... (Shift+Enter untuk baris baru)" rows="1"></textarea>
              </div>
              <button type="submit" class="shrink-0 w-12 h-12 bg-primary text-on-primary rounded-2xl flex items-center justify-center shadow-md hover:opacity-90 hover:-translate-y-0.5 transition-all active:scale-95 disabled:opacity-50" :disabled="isSending || newMessage.trim() === ''">
                <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1">send</span>
              </button>
            </form>
          </div>
        </div>
      </template>

      <template x-if="!selectedContact">
        <div class="flex-1 flex flex-col items-center justify-center text-on-surface-variant relative z-10 h-full">
          <div class="w-20 h-20 bg-surface-container border border-outline-variant/30 rounded-full flex items-center justify-center mb-5 shadow-sm">
            <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings:'FILL' 1">forum</span>
          </div>
          <h3 class="font-headline text-2xl font-bold text-on-surface mb-2">Pesan Toko</h3>
          <p class="text-sm max-w-xs text-center">Pilih salah satu kontak dari daftar di sebelah kiri untuk mulai membaca atau membalas pesan.</p>
        </div>
      </template>
    </section>
  </div>

  @push('scripts')
  <script>
    function chatComponent() {
      return {
        contacts: [], search: '', selectedContact: null,
        messages: [], newMessage: '', isSending: false, pollingInterval: null,
        get filteredContacts() {
          if (!this.search) return this.contacts;
          return this.contacts.filter(c => c.name.toLowerCase().includes(this.search.toLowerCase()));
        },
        init() { this.fetchContacts(); },
        fetchContacts() {
          fetch('{{ route('chat.rooms') }}').then(r => r.json()).then(data => {
            this.contacts = data;
            const saved = localStorage.getItem('chat_selected_room_id');
            if (saved) { const c = data.find(c => c.id == saved); if (c) this.selectContact(c); }
          });
        },
        selectContact(contact) {
          this.selectedContact = contact;
          localStorage.setItem('chat_selected_room_id', contact.id);
          this.fetchMessages(true);
          if (this.pollingInterval) clearInterval(this.pollingInterval);
          this.pollingInterval = setInterval(() => this.fetchMessages(false), 3000);
        },
        fetchMessages(scroll = true) {
          if (!this.selectedContact) return;
          const tokoParam = this.selectedContact.toko_id ? `&toko_id=${this.selectedContact.toko_id}` : '';
          const userParam = this.selectedContact.user_id ? `&user_id=${this.selectedContact.user_id}` : '';
          
          fetch(`{{ route('chat.messages') }}?t=1${tokoParam}${userParam}`).then(r => r.json()).then(data => {
            const prev = this.messages.length; this.messages = data;
            if (scroll || prev !== data.length) setTimeout(() => {
              const el = document.getElementById('messages-container');
              if (el) el.scrollTop = el.scrollHeight;
            }, 100);
          });
        },
        sendMessage() {
          if (!this.newMessage.trim() || !this.selectedContact || this.isSending) return;
          this.isSending = true;
          fetch('{{ route('chat.send') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ 
                receiver_id: this.selectedContact.user_id, 
                toko_id: this.selectedContact.toko_id,
                message: this.newMessage.trim() 
            })
          }).then(r => r.json()).then(data => {
            this.messages.push(data); this.newMessage = ''; this.isSending = false;
            setTimeout(() => { const el = document.getElementById('messages-container'); if (el) el.scrollTop = el.scrollHeight; }, 50);
          }).catch(() => { this.isSending = false; });
        }
      }
    }
  </script>
  @endpush

</x-layout-store>