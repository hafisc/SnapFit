<template>
  <div class="space-y-5 max-w-[900px]">
    <!-- Tabs -->
    <div class="flex bg-[#F8F1E7] rounded-lg p-0.5 w-fit">
      <button v-for="t in tabs" :key="t.key" @click="activeTab = t.key"
        class="px-4 py-2 text-[11px] font-semibold rounded-md transition-all"
        :class="activeTab === t.key ? 'bg-white text-[#2B1E16] shadow-sm' : 'text-[#8A7A6C] hover:text-[#6F6259]'">{{ t.label }}</button>
    </div>

    <!-- Profile Section -->
    <div v-if="activeTab === 'profil'" class="space-y-4">
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Informasi Toko</h3>
        <div class="flex items-center gap-5 mb-6">
          <div class="w-20 h-20 rounded-2xl bg-[#F8F1E7] flex items-center justify-center text-3xl border-2 border-dashed border-[#B85C38]/30 cursor-pointer hover:bg-[#F8F1E7] transition-colors">
            📷
          </div>
          <div>
            <p class="text-[13px] font-semibold text-[#2B1E16] mb-1">Foto Profil Toko</p>
            <p class="text-[11px] text-[#8A7A6C]">JPG, PNG max 2MB. Rekomendasi 400x400px</p>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Nama Toko</label>
            <input v-model="form.shopName" type="text" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Email</label>
            <input v-model="form.email" type="email" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">No. Telepon</label>
            <input v-model="form.phone" type="text" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Kategori Usaha</label>
            <select v-model="form.category" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none cursor-pointer focus:border-[#B85C38] transition-all">
              <option value="batik">Batik</option>
              <option value="kerajinan">Kerajinan</option>
              <option value="fashion">Fashion</option>
              <option value="aksesoris">Aksesoris</option>
              <option value="dekorasi">Dekorasi</option>
            </select>
          </div>
          <div class="md:col-span-2">
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Deskripsi Toko</label>
            <textarea v-model="form.description" rows="3" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all resize-none"></textarea>
          </div>
          <div class="md:col-span-2">
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Alamat</label>
            <input v-model="form.address" type="text" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
        </div>
        <div class="flex justify-end mt-5 pt-5 border-t border-[#E8DCCB]">
          <button class="bg-[#B85C38] hover:bg-[#B85C38] text-white px-5 py-2.5 rounded-lg text-[11px] font-bold transition-colors">Simpan Perubahan</button>
        </div>
      </div>

      <!-- Social Links -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Sosial Media</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div v-for="s in socialFields" :key="s.key">
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">{{ s.label }}</label>
            <div class="flex items-center bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg overflow-hidden">
              <span class="px-3 text-sm border-r border-[#E8DCCB] bg-[#F8F1E7]">{{ s.emoji }}</span>
              <input v-model="form.socials[s.key]" type="text" :placeholder="s.placeholder" class="flex-1 bg-transparent px-3 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Password Section -->
    <div v-if="activeTab === 'keamanan'" class="space-y-4">
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Ubah Password</h3>
        <div class="space-y-4 max-w-md">
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Password Lama</label>
            <input type="password" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Password Baru</label>
            <input type="password" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
          <div>
            <label class="text-[11px] font-semibold text-[#6F6259] block mb-1.5">Konfirmasi Password</label>
            <input type="password" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-lg px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all" />
          </div>
        </div>
        <div class="flex justify-end mt-5 pt-5 border-t border-[#E8DCCB]">
          <button class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-lg text-[11px] font-bold transition-colors">Update Password</button>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-2">Sesi Aktif</h3>
        <p class="text-[11px] text-[#8A7A6C] font-medium mb-4">Perangkat yang sedang login ke akun Anda</p>
        <div class="space-y-3">
          <div v-for="s in sessions" :key="s.device" class="flex items-center justify-between py-3 border-b border-[#E8DCCB]/40 last:border-0">
            <div class="flex items-center gap-3">
              <span class="text-lg">{{ s.emoji }}</span>
              <div>
                <p class="text-[12px] font-semibold text-[#2B1E16]">{{ s.device }}</p>
                <p class="text-[10px] text-[#8A7A6C]">{{ s.location }} · {{ s.time }}</p>
              </div>
            </div>
            <span v-if="s.current" class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded">Saat Ini</span>
            <button v-else class="text-[10px] font-semibold text-red-500 hover:text-red-600">Hapus</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Notifications Section -->
    <div v-if="activeTab === 'notifikasi'" class="space-y-4">
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Preferensi Notifikasi</h3>
        <div class="space-y-4">
          <div v-for="n in notifSettings" :key="n.label" class="flex items-center justify-between py-3 border-b border-[#E8DCCB]/40 last:border-0">
            <div>
              <p class="text-[12px] font-semibold text-[#2B1E16]">{{ n.label }}</p>
              <p class="text-[10px] text-[#8A7A6C]">{{ n.desc }}</p>
            </div>
            <button @click="n.enabled = !n.enabled" class="w-11 h-6 rounded-full transition-colors relative" :class="n.enabled ? 'bg-[#B85C38]' : 'bg-slate-200'">
              <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-all" :class="n.enabled ? 'left-5.5' : 'left-0.5'" :style="{ left: n.enabled ? '22px' : '2px' }"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const activeTab = ref('profil');
const tabs = [
  { key: 'profil', label: 'Profil Toko' },
  { key: 'keamanan', label: 'Keamanan' },
  { key: 'notifikasi', label: 'Notifikasi' },
];

const form = reactive({
  shopName: 'Batik Sari Malang',
  email: 'batiksari@gmail.com',
  phone: '0812-3456-7890',
  category: 'batik',
  description: 'UMKM batik tulis dan batik cap khas Malang dengan pewarna alami tradisional. Berdiri sejak 2018.',
  address: 'Jl. Soekarno Hatta No. 12, Kota Malang, Jawa Timur',
  socials: { instagram: '@batiksarimalang', tokopedia: 'Batik Sari Malang', shopee: 'batiksarimalang', whatsapp: '081234567890' },
});

const socialFields = [
  { key: 'instagram', label: 'Instagram', emoji: '📸', placeholder: '@username' },
  { key: 'tokopedia', label: 'Tokopedia', emoji: '🟢', placeholder: 'Nama toko' },
  { key: 'shopee', label: 'Shopee', emoji: '🟠', placeholder: 'Username' },
  { key: 'whatsapp', label: 'WhatsApp', emoji: '💬', placeholder: '08xxxxxxxxxx' },
];

const sessions = [
  { device: 'Chrome — Windows 11', location: 'Malang, ID', time: 'Aktif sekarang', emoji: '💻', current: true },
  { device: 'Safari — iPhone 15', location: 'Malang, ID', time: '2 jam lalu', emoji: '📱', current: false },
];

const notifSettings = ref([
  { label: 'Pesanan Baru', desc: 'Notifikasi saat ada pesanan masuk', enabled: true },
  { label: 'Chat Pembeli', desc: 'Pesan dari calon pembeli', enabled: true },
  { label: 'Co-Create Update', desc: 'Update dari room kolaborasi', enabled: true },
  { label: 'AI Studio Selesai', desc: 'Notif saat rendering AI selesai', enabled: false },
  { label: 'Promo & Tips', desc: 'Tips penjualan dan promo platform', enabled: false },
]);
</script>
