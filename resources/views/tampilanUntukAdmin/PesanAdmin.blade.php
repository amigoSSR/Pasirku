<x-layout-admin title="Pesan Admin" :fullHeight="true">

  {{-- Full-height chat layout --}}
  <div class="flex flex-1 overflow-hidden h-full" x-data="chatComponent()" x-init="init()">

    {{-- Chat List Sidebar --}}
    <section class="bg-surface-container-low flex flex-col h-full overflow-hidden w-[340px] lg:w-[380px] flex-shrink-0 border-r border-outline-variant/30">
      <div class="p-5 border-b border-outline-variant/30">
        <h2 class="font-headline text-xl font-bold text-on-surface mb-1">Customer Support</h2>
        <p class="text-xs text-on-surface-variant mb-4">Balas pesan dari pengguna platform</p>
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
          <input class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all"
            placeholder="Cari pengguna..." type="text" x-model="search" />
        </div>
      </div>

      <div class="flex-1 overflow-y-auto divide-y divide-outline-variant/10">
        <template x-for="contact in filteredContacts" :key="contact.id">
          <div @click="selectContact(contact)"
            :class="{'bg-primary/5 border-l-4 border-l-primary': selectedContact && selectedContact.id === contact.id,
                     'hover:bg-surface-container border-l-4 border-l-transparent': !selectedContact || selectedContact.id !== contact.id}"
            class="px-5 py-4 cursor-pointer transition-all duration-200">
            <div class="flex gap-3">
              <div class="relative flex-shrink-0">
                <div class="w-11 h-11 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center font-headline font-bold text-lg uppercase"
                  x-text="contact.name.charAt(0)"></div>
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-surface-container-low rounded-full"></span>
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="font-bold text-sm text-on-surface truncate" x-text="contact.name"></h4>
                <p class="text-xs text-on-surface-variant truncate mt-0.5">Klik untuk membuka obrolan</p>
              </div>
            </div>
          </div>
        </template>

        <template x-if="filteredContacts.length === 0 && contacts.length === 0">
          <div class="text-center py-12 text-on-surface-variant px-5">
            <span class="material-symbols-outlined text-4xl block mb-2 opacity-30">forum</span>
            <p class="text-sm font-semibold">Belum ada pesan masuk</p>
            <p class="text-xs mt-1 opacity-70">Pengguna belum menghubungi admin</p>
          </div>
        </template>

        <template x-if="filteredContacts.length === 0 && contacts.length > 0">
          <div class="text-center py-12 text-on-surface-variant">
            <span class="material-symbols-outlined text-4xl block mb-2 opacity-30">search_off</span>
            <p class="text-sm font-semibold">Tidak ditemukan</p>
          </div>
        </template>
      </div>
    </section>

    {{-- Chat Window --}}
    <section class="flex flex-col flex-1 h-full bg-surface-container-lowest relative overflow-hidden">

      <template x-if="selectedContact">
        <div class="flex flex-col h-full">
          {{-- Chat Header --}}
          <div class="px-6 py-4 flex justify-between items-center bg-surface-container-lowest border-b border-outline-variant/30 shadow-sm z-10">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center font-headline font-bold text-base uppercase"
                x-text="selectedContact.name.charAt(0)"></div>
              <div>
                <h3 class="font-headline font-bold text-on-surface text-sm" x-text="selectedContact.name"></h3>
                <p class="text-xs text-green-600 font-bold flex items-center gap-1">
                  <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse inline-block"></span>
                  Pengguna Aktif
                </p>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-xs text-on-surface-variant bg-surface-container px-3 py-1 rounded-full font-semibold">
                Customer Support
              </span>
            </div>
          </div>

          {{-- Messages --}}
          <div class="flex-1 overflow-y-auto p-6 space-y-5 bg-surface-container" id="messages-container">
            <div class="flex justify-center mb-4">
              <span class="bg-surface-container-lowest border border-outline-variant/30 text-on-surface-variant text-xs font-semibold px-4 py-1.5 rounded-full shadow-sm">
                Percakapan diamankan
              </span>
            </div>
            <template x-for="msg in messages" :key="msg.id">
              <div class="flex gap-3 max-w-[80%]" :class="msg.sender_id === {{ Auth::id() }} ? 'ml-auto flex-row-reverse' : ''">
                <div>
                  <div class="px-4 py-3 shadow-sm text-sm leading-relaxed"
                    :class="msg.sender_id === {{ Auth::id() }}
                      ? 'bg-primary text-on-primary rounded-l-2xl rounded-br-2xl'
                      : 'bg-surface-container-lowest text-on-surface rounded-r-2xl rounded-bl-2xl border border-outline-variant/20'"
                    x-text="msg.message"></div>
                  <span class="text-[10px] font-semibold text-on-surface-variant mt-1.5 block uppercase"
                    :class="msg.sender_id === {{ Auth::id() }} ? 'text-right mr-1' : 'ml-1'"
                    x-text="new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                </div>
              </div>
            </template>
          </div>

          {{-- Chat Input --}}
          <div class="p-5 bg-surface-container-lowest border-t border-outline-variant/30">
            <form @submit.prevent="sendMessage" class="relative bg-surface-container-low rounded-2xl p-2 flex items-end gap-2 border border-outline-variant/30 focus-within:ring-2 focus-within:ring-primary/20 transition-all">
              <input x-model="newMessage"
                class="flex-1 bg-transparent border-none focus:ring-0 py-2.5 px-2 text-sm text-on-surface resize-none outline-none placeholder:text-on-surface-variant"
                placeholder="Balas pesan..." required autocomplete="off" />
              <button type="submit"
                class="w-11 h-11 bg-primary text-on-primary rounded-xl flex items-center justify-center shadow-sm hover:bg-primary-container transition-all active:scale-90"
                :disabled="isSending">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">send</span>
              </button>
            </form>
          </div>
        </div>
      </template>

      <template x-if="!selectedContact">
        <div class="flex-1 flex flex-col items-center justify-center text-on-surface-variant h-full">
          <div class="w-20 h-20 bg-surface-container rounded-full flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-4xl opacity-30">support_agent</span>
          </div>
          <p class="font-semibold text-sm">Pilih pengguna untuk mulai membalas</p>
          <p class="text-xs mt-1 opacity-60">Semua pesan masuk dari pengguna ditampilkan di sini</p>
        </div>
      </template>

    </section>

  </div>

  @push('scripts')
  <script>
    function chatComponent() {
      return {
        contacts: [], search: '', selectedContact: null, messages: [], newMessage: '', isSending: false, pollingInterval: null,
        get filteredContacts() {
          if (this.search === '') return this.contacts;
          return this.contacts.filter(c => c.name.toLowerCase().includes(this.search.toLowerCase()));
        },
        init() {
          this.fetchContacts();
        },
        fetchContacts() {
          fetch('{{ route('chat.rooms') }}')
            .then(res => res.json())
            .then(data => {
              this.contacts = data;
              const savedId = localStorage.getItem('chat_admin_room_id');
              if (savedId) {
                const saved = data.find(c => c.id == savedId);
                if (saved) this.selectContact(saved);
              }
            });
        },
        selectContact(contact) {
          this.selectedContact = contact;
          localStorage.setItem('chat_admin_room_id', contact.id);
          this.fetchMessages(true);
          if (this.pollingInterval) clearInterval(this.pollingInterval);
          this.pollingInterval = setInterval(() => this.fetchMessages(false), 3000);
        },
        fetchMessages(scrollToBottom = true) {
          if (!this.selectedContact) return;
          const tokoParam = this.selectedContact.toko_id ? `&toko_id=${this.selectedContact.toko_id}` : '';
          const userParam = this.selectedContact.user_id ? `&user_id=${this.selectedContact.user_id}` : '';
          fetch(`{{ route('chat.messages') }}?t=1${tokoParam}${userParam}`)
            .then(res => res.json())
            .then(data => {
              const prevLength = this.messages.length;
              this.messages = data;
              if (scrollToBottom || prevLength !== data.length) {
                setTimeout(() => { const c = document.getElementById('messages-container'); if (c) c.scrollTop = c.scrollHeight; }, 100);
              }
            });
        },
        sendMessage() {
          if (this.newMessage.trim() === '' || !this.selectedContact || this.isSending) return;
          this.isSending = true;
          fetch('{{ route('chat.send') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({
              receiver_id: this.selectedContact.user_id,
              toko_id: null,
              message: this.newMessage
            })
          })
          .then(res => res.json())
          .then(data => {
            this.messages.push(data); this.newMessage = ''; this.isSending = false;
            setTimeout(() => { const c = document.getElementById('messages-container'); if (c) c.scrollTop = c.scrollHeight; }, 50);
          })
          .catch(() => { this.isSending = false; });
        }
      }
    }
  </script>
  @endpush

</x-layout-admin>
