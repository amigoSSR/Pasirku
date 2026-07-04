<x-layout-store title="Pengaturan Ongkir">
  <div class="p-6 md:p-10 max-w-6xl mx-auto w-full mb-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
      <div>
        <h1 class="text-3xl font-black text-on-surface tracking-tight">Pengaturan Ongkir</h1>
        <p class="text-on-surface-variant text-sm mt-1">Kelola tarif pengiriman berdasarkan jenis kendaraan dan kapasitas.</p>
      </div>
      <button onclick="openModal('addRateModal')" class="bg-primary text-on-primary px-6 py-3 rounded-2xl font-bold text-sm shadow-lg hover:opacity-90 transition-all flex items-center gap-2">
        <span class="material-symbols-outlined">add</span>
        Tambah Tarif
      </button>
    </div>

    @if(session('success'))
      <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
        <span class="material-symbols-outlined">check_circle</span>
        <p class="text-sm font-bold">{{ session('success') }}</p>
      </div>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-surface-container-low/50">
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/20">Jenis Kendaraan</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/20">Kapasitas</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/20">Biaya Ongkir</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/20">Satuan</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/20">Status</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant border-b border-outline-variant/20 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/10">
            @forelse($rates as $rate)
              <tr class="hover:bg-surface-container-low/30 transition-colors">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 {{ $rate->vehicle_type === 'pickup' ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600' }} rounded-xl flex items-center justify-center">
                      <span class="material-symbols-outlined">{{ $rate->vehicle_type === 'pickup' ? 'directions_car' : 'local_shipping' }}</span>
                    </div>
                    <span class="font-bold text-on-surface capitalize">{{ $rate->vehicle_type }}</span>
                  </div>
                </td>
                <td class="px-6 py-5 text-sm font-medium text-on-surface">{{ $rate->capacity }}</td>
                <td class="px-6 py-5 text-sm font-black text-primary">Rp {{ number_format($rate->shipping_cost, 0, ',', '.') }}</td>
                <td class="px-6 py-5">
                   <span class="px-2.5 py-1 rounded-lg bg-surface-container text-[10px] font-bold uppercase text-on-surface-variant">
                     {{ $rate->unit === 'per_trip' ? 'Per Perjalanan' : 'Per KM' }}
                   </span>
                </td>
                <td class="px-6 py-5">
                   <form action="{{ route('shipping-rates.toggle', $rate->id) }}" method="POST">
                     @csrf @method('PATCH')
                     <button type="submit" class="flex items-center gap-2 group">
                       <div class="w-10 h-5 rounded-full relative transition-colors {{ $rate->is_active ? 'bg-green-500' : 'bg-outline-variant' }}">
                         <div class="absolute top-1 {{ $rate->is_active ? 'right-1' : 'left-1' }} w-3 h-3 bg-white rounded-full transition-all"></div>
                       </div>
                       <span class="text-[10px] font-bold uppercase {{ $rate->is_active ? 'text-green-600' : 'text-on-surface-variant' }}">
                         {{ $rate->is_active ? 'Aktif' : 'Nonaktif' }}
                       </span>
                     </button>
                   </form>
                </td>
                <td class="px-6 py-5 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button onclick="openEditModal({{ json_encode($rate) }})" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-lg transition-all">
                      <span class="material-symbols-outlined text-[20px]">edit</span>
                    </button>
                    <form action="{{ route('shipping-rates.destroy', $rate->id) }}" method="POST" onsubmit="return confirm('Hapus tarif ini?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="p-2 text-on-surface-variant hover:text-error hover:bg-error/5 rounded-lg transition-all">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-20 text-center">
                  <span class="material-symbols-outlined text-5xl text-outline-variant mb-4 block">local_shipping</span>
                  <p class="text-on-surface-variant font-medium">Belum ada tarif ongkir yang diatur.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Add Modal --}}
  <div id="addRateModal" class="fixed inset-0 z-[100] hidden" style="display:none">
    <div class="flex items-center justify-center min-h-full w-full p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-surface-container-lowest rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in zoom-in duration-200">
      <div class="px-6 py-5 border-b flex justify-between items-center">
        <h3 class="text-xl font-black text-on-surface">Tambah Tarif Ongkir</h3>
        <button onclick="closeModal('addRateModal')" class="material-symbols-outlined text-on-surface-variant">close</button>
      </div>
      <form action="{{ route('shipping-rates.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Jenis Kendaraan</label>
          <select name="vehicle_type" required class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20">
            <option value="pickup">Pick Up</option>
            <option value="truck">Truk</option>
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Kapasitas Muatan</label>
          <input type="text" name="capacity" required placeholder="Contoh: 1-2 m3" class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20">
        </div>
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Biaya Ongkir (Rp)</label>
          <input type="number" name="shipping_cost" required min="0" placeholder="0" class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20">
        </div>
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Satuan Harga</label>
          <div class="grid grid-cols-2 gap-3">
             <label class="relative flex items-center justify-between p-3 rounded-xl bg-surface-container cursor-pointer border-2 border-transparent has-[:checked]:border-primary/50 has-[:checked]:bg-primary/5 transition-all duration-300 active:scale-95 hover:bg-surface-container-high">
               <input type="radio" name="unit" value="per_trip" checked class="hidden peer">
               <span class="text-xs font-bold text-on-surface peer-checked:text-primary transition-colors duration-300">Per Perjalanan</span>
               <div class="w-5 h-5 rounded-full border-2 border-on-surface-variant/30 flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary transition-all duration-300">
                 <span class="material-symbols-outlined text-[14px] text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 delay-75">check</span>
               </div>
             </label>
             <label class="relative flex items-center justify-between p-3 rounded-xl bg-surface-container cursor-pointer border-2 border-transparent has-[:checked]:border-primary/50 has-[:checked]:bg-primary/5 transition-all duration-300 active:scale-95 hover:bg-surface-container-high">
               <input type="radio" name="unit" value="per_km" class="hidden peer">
               <span class="text-xs font-bold text-on-surface peer-checked:text-primary transition-colors duration-300">Per KM</span>
               <div class="w-5 h-5 rounded-full border-2 border-on-surface-variant/30 flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary transition-all duration-300">
                 <span class="material-symbols-outlined text-[14px] text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 delay-75">check</span>
               </div>
             </label>
          </div>
        </div>
        <div class="pt-4">
          <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-2xl font-black shadow-lg hover:opacity-90 transition-all">SIMPAN TARIF</button>
        </div>
      </form>
    </div>
  </div>
  </div>

  {{-- Edit Modal --}}
  <div id="editRateModal" class="fixed inset-0 z-[100] hidden" style="display:none">
    <div class="flex items-center justify-center min-h-full w-full p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-surface-container-lowest rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
      <div class="px-6 py-5 border-b flex justify-between items-center">
        <h3 class="text-xl font-black text-on-surface">Edit Tarif Ongkir</h3>
        <button onclick="closeModal('editRateModal')" class="material-symbols-outlined text-on-surface-variant">close</button>
      </div>
      <form id="editRateForm" method="POST" class="p-6 space-y-5">
        @csrf @method('PUT')
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Jenis Kendaraan</label>
          <select name="vehicle_type" id="edit_vehicle_type" required class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20">
            <option value="pickup">Pick Up</option>
            <option value="truck">Truk</option>
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Kapasitas Muatan</label>
          <input type="text" name="capacity" id="edit_capacity" required class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20">
        </div>
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Biaya Ongkir (Rp)</label>
          <input type="number" name="shipping_cost" id="edit_shipping_cost" required min="0" class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20">
        </div>
        <div>
          <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Satuan Harga</label>
          <div class="grid grid-cols-2 gap-3">
             <label class="relative flex items-center justify-between p-3 rounded-xl bg-surface-container cursor-pointer border-2 border-transparent has-[:checked]:border-primary/50 has-[:checked]:bg-primary/5 transition-all duration-300 active:scale-95 hover:bg-surface-container-high">
               <input type="radio" name="unit" value="per_trip" id="edit_unit_trip" class="hidden peer">
               <span class="text-xs font-bold text-on-surface peer-checked:text-primary transition-colors duration-300">Per Perjalanan</span>
               <div class="w-5 h-5 rounded-full border-2 border-on-surface-variant/30 flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary transition-all duration-300">
                 <span class="material-symbols-outlined text-[14px] text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 delay-75">check</span>
               </div>
             </label>
             <label class="relative flex items-center justify-between p-3 rounded-xl bg-surface-container cursor-pointer border-2 border-transparent has-[:checked]:border-primary/50 has-[:checked]:bg-primary/5 transition-all duration-300 active:scale-95 hover:bg-surface-container-high">
               <input type="radio" name="unit" value="per_km" id="edit_unit_km" class="hidden peer">
               <span class="text-xs font-bold text-on-surface peer-checked:text-primary transition-colors duration-300">Per KM</span>
               <div class="w-5 h-5 rounded-full border-2 border-on-surface-variant/30 flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary transition-all duration-300">
                 <span class="material-symbols-outlined text-[14px] text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 delay-75">check</span>
               </div>
             </label>
          </div>
        </div>
        <div class="pt-4">
          <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-2xl font-black shadow-lg hover:opacity-90 transition-all">UPDATE TARIF</button>
        </div>
      </form>
    </div>
  </div>
  </div>

  @push('scripts')
  <script>
    function openModal(id) {
      const el = document.getElementById(id);
      el.style.display = 'block';
      document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
      const el = document.getElementById(id);
      el.style.display = 'none';
      document.body.style.overflow = '';
    }
    function openEditModal(rate) {
      document.getElementById('editRateForm').action = `/shipping-rates/${rate.id}`;
      document.getElementById('edit_vehicle_type').value = rate.vehicle_type;
      document.getElementById('edit_capacity').value = rate.capacity;
      document.getElementById('edit_shipping_cost').value = rate.shipping_cost;
      if(rate.unit === 'per_trip') document.getElementById('edit_unit_trip').checked = true;
      else document.getElementById('edit_unit_km').checked = true;
      openModal('editRateModal');
    }
  </script>
  @endpush
</x-layout-store>
