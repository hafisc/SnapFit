<template>
  <div class="w-full">
    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
      
      <!-- Left Column: Shop Card & Vertical Navigation -->
      <div class="lg:col-span-1 space-y-5">
        
        <!-- Shop Profile Overview Card -->
        <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col items-center text-center shadow-sm relative overflow-hidden">
          <!-- Decorative Top Pattern -->
          <div class="absolute top-0 inset-x-0 h-1.5 bg-[#B85C38]"></div>
          
          <!-- Avatar Uploader -->
          <div @click="triggerFileInput" class="relative w-24 h-24 rounded-full bg-[#F8F1E7] overflow-hidden flex items-center justify-center border-4 border-white shadow-md cursor-pointer hover:scale-105 group transition-all duration-300 ring-2 ring-[#B85C38]/20">
            <img v-if="form.avatarUrl" :src="form.avatarUrl" class="w-full h-full object-cover group-hover:opacity-75 transition-opacity" />
            <svg v-else class="w-10 h-10 text-[#8A7A6C] group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.5a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75h-3.5a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
            </svg>
            
            <!-- Uploading spinner overlay -->
            <div v-if="uploadLoading" class="absolute inset-0 bg-[#2B1E16]/40 flex items-center justify-center">
              <svg class="animate-spin h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </div>
            
            <!-- Hover overlay -->
            <div class="absolute inset-0 bg-[#2B1E16]/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity" v-if="!uploadLoading">
              <span class="text-[9px] font-bold text-white uppercase tracking-wider text-center px-1">Ubah Foto</span>
            </div>
          </div>
          <input type="file" ref="fileInput" @change="handleAvatarUpload" class="hidden" accept="image/*" />
          
          <!-- Shop details -->
          <h4 class="font-bold text-[#2B1E16] text-base mt-4 leading-tight truncate max-w-full">{{ form.shopName || 'Nama Toko' }}</h4>
          <p class="text-[11px] text-[#8A7A6C] mt-1 truncate max-w-full">{{ form.email || 'email@toko.com' }}</p>
          
          <!-- Badges -->
          <div class="flex flex-wrap justify-center gap-1.5 mt-3.5">
            <span class="text-[9px] font-bold uppercase tracking-wider text-[#B85C38] bg-[#B85C38]/10 px-2.5 py-1 rounded-full">{{ form.category }}</span>
            <span class="text-[9px] font-bold uppercase tracking-wider text-[#0F8A4B] bg-[#0F8A4B]/10 px-2.5 py-1 rounded-full">UMKM Aktif</span>
          </div>
        </div>

        <!-- Vertical Tab Navigation -->
        <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-2 shadow-sm space-y-1">
          <button v-for="t in tabs" :key="t.key" @click="activeTab = t.key"
            class="w-full text-left px-4 py-3 text-[12px] font-bold rounded-xl transition-all flex items-center gap-3 cursor-pointer outline-none"
            :class="activeTab === t.key ? 'bg-[#B85C38]/10 text-[#B85C38]' : 'text-[#8A7A6C] hover:bg-[#F8F1E7] hover:text-[#2B1E16]'">
            <span class="text-base">{{ t.emoji }}</span>
            <span class="flex-1">{{ t.label }}</span>
            <svg v-if="activeTab === t.key" class="w-3.5 h-3.5 text-[#B85C38]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>

      <!-- Right Column: Settings Content Panels -->
      <div class="lg:col-span-3">
        
        <!-- Loading Skeleton -->
        <div v-if="loading" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 animate-pulse">
          <div class="h-4 w-1/4 bg-[#F8F1E7] rounded mb-5"></div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="i in 6" :key="i" class="space-y-2">
              <div class="h-2.5 w-1/4 bg-[#F8F1E7] rounded"></div>
              <div class="h-9 w-full bg-[#F8F1E7] rounded-lg"></div>
            </div>
          </div>
        </div>

        <!-- Form Sections (Loaded dynamically based on activeTab) -->
        <div v-else class="space-y-5">
          
          <!-- Tab Panel: Profil Toko -->
          <div v-if="activeTab === 'profil'" class="space-y-5">
            <!-- Informasi Toko Form -->
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Informasi Toko</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Nama Toko</label>
                  <input v-model="form.shopName" type="text" placeholder="Nama usaha/toko..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Email Toko</label>
                  <input v-model="form.email" type="email" placeholder="Alamat email kontak..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">No. Telepon</label>
                  <input v-model="form.phone" type="text" placeholder="Contoh: 0812-3456-7890" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Kategori Usaha</label>
                  <select v-model="form.category" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none cursor-pointer focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all">
                    <option value="batik">Batik</option>
                    <option value="kerajinan">Kerajinan</option>
                    <option value="fashion">Fashion</option>
                    <option value="aksesoris">Aksesoris</option>
                    <option value="dekorasi">Dekorasi</option>
                  </select>
                </div>
                <div class="md:col-span-2">
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Deskripsi Toko</label>
                  <textarea v-model="form.description" rows="3" placeholder="Ceritakan sejarah atau keunikan produk lokal toko Anda..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all resize-none placeholder-[#8A7A6C]/50"></textarea>
                </div>
                <div class="md:col-span-2">
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Alamat Lengkap</label>
                  <input v-model="form.address" type="text" placeholder="Jalan, RT/RW, Kota, Provinsi..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
              </div>
              
              <!-- Save button -->
              <div class="flex justify-end mt-6 pt-5 border-t border-[#E8DCCB]/40">
                <button @click="saveProfile" :disabled="saveLoading" class="bg-[#B85C38] hover:bg-[#A04E2D] disabled:bg-[#B85C38]/60 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold transition-all flex items-center gap-2 cursor-pointer shadow-sm shadow-[#B85C38]/10 hover:shadow-md active:scale-95 duration-150 outline-none">
                  <svg v-if="saveLoading" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ saveLoading ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
              </div>
            </div>

            <!-- Sosial Media Card -->
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Tautan Sosial Media</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-for="s in socialFields" :key="s.key">
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">{{ s.label }}</label>
                  <div class="flex items-center bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl overflow-hidden focus-within:border-[#B85C38] focus-within:ring-2 focus-within:ring-[#B85C38]/10 transition-all">
                    <span class="px-3.5 py-2.5 text-sm border-r border-[#E8DCCB] bg-[#F8F1E7] text-[#2B1E16]">{{ s.emoji }}</span>
                    <input v-model="form.socials[s.key]" type="text" :placeholder="s.placeholder" class="flex-1 bg-transparent px-3.5 py-2.5 text-[13px] text-[#2B1E16] font-semibold outline-none placeholder-[#8A7A6C]/40" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab Panel: Keamanan -->
          <div v-if="activeTab === 'keamanan'" class="space-y-5">
            <!-- Ubah Password Form -->
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Perbarui Password</h3>
              <div class="space-y-4 max-w-md">
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Password Lama</label>
                  <input v-model="passwordForm.currentPassword" type="password" placeholder="Password akun saat ini..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/40" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Password Baru</label>
                  <input v-model="passwordForm.password" type="password" placeholder="Minimal 8 karakter..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/40" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Konfirmasi Password Baru</label>
                  <input v-model="passwordForm.passwordConfirmation" type="password" placeholder="Ulangi input password baru..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/40" />
                </div>
              </div>
              <div class="flex justify-end mt-6 pt-5 border-t border-[#E8DCCB]/40">
                <button @click="updatePassword" :disabled="pwdLoading" class="bg-[#2B1E16] hover:bg-[#403025] disabled:bg-[#2B1E16]/60 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold transition-all flex items-center gap-2 cursor-pointer shadow-sm hover:shadow-md active:scale-95 duration-150 outline-none">
                  <svg v-if="pwdLoading" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ pwdLoading ? 'Memproses...' : 'Ubah Password' }}
                </button>
              </div>
            </div>

            <!-- Active Sessions Card -->
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-1">Sesi Perangkat</h3>
              <p class="text-[11px] text-[#8A7A6C] font-medium mb-5">Daftar perangkat yang memiliki hak akses login ke akun UMKM ini.</p>
              <div class="space-y-4">
                <div v-for="s in sessions" :key="s.id" class="flex items-center justify-between py-3.5 border-b border-[#E8DCCB]/40 last:border-0">
                  <div class="flex items-center gap-4">
                    <span class="w-10 h-10 rounded-xl bg-[#F8F1E7] flex items-center justify-center text-lg text-[#2B1E16]">{{ s.emoji }}</span>
                    <div>
                      <p class="text-[12px] font-bold text-[#2B1E16]">{{ s.device }}</p>
                      <p class="text-[10px] text-[#8A7A6C]">{{ s.location }} · {{ s.time }}</p>
                    </div>
                  </div>
                  <span v-if="s.current" class="text-[10px] font-bold text-[#0F8A4B] bg-[#0F8A4B]/10 px-2.5 py-1 rounded-lg">Sesi Sekarang</span>
                  <button v-else @click="removeSession(s.id)" class="text-[10px] font-bold text-[#D94A38] hover:text-[#B83C2D] bg-[#D94A38]/10 hover:bg-[#D94A38]/20 px-2.5 py-1 rounded-lg transition-colors cursor-pointer outline-none">Hapus Sesi</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab Panel: Notifikasi -->
          <div v-if="activeTab === 'notifikasi'" class="space-y-5">
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Preferensi Notifikasi</h3>
              <div class="space-y-1">
                <div v-for="(n, idx) in notifSettings" :key="n.label" class="flex items-center justify-between py-4 border-b border-[#E8DCCB]/40 last:border-0">
                  <div class="pr-4">
                    <p class="text-[12px] font-bold text-[#2B1E16]">{{ n.label }}</p>
                    <p class="text-[10px] text-[#8A7A6C] mt-0.5">{{ n.desc }}</p>
                  </div>
                  <button @click="toggleNotif(idx)" class="w-10 h-5.5 rounded-full transition-colors duration-200 relative cursor-pointer outline-none" :class="n.enabled ? 'bg-[#B85C38]' : 'bg-[#E8DCCB]'">
                    <span class="absolute top-0.5 w-4.5 h-4.5 bg-white rounded-full shadow-sm transition-all duration-200" :style="{ left: n.enabled ? '19px' : '2px' }"></span>
                  </button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      
    </div>

    <!-- Toast Notification -->
    <transition name="fade">
      <div v-if="toast.show" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3.5 rounded-2xl shadow-xl border backdrop-blur-md transition-all duration-300 transform translate-y-0"
        :class="toast.type === 'success' ? 'bg-[#0F8A4B]/95 border-[#0F8A4B]/20 text-white' : 'bg-[#D94A38]/95 border-[#D94A38]/20 text-white'">
        <span class="text-base">{{ toast.type === 'success' ? '✨' : '⚠️' }}</span>
        <p class="text-[12px] font-bold tracking-wide">{{ toast.message }}</p>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

const activeTab = ref('profil');
const tabs = [
  { key: 'profil', label: 'Profil Toko', emoji: '🏬' },
  { key: 'keamanan', label: 'Keamanan Akun', emoji: '🔒' },
  { key: 'notifikasi', label: 'Notifikasi', emoji: '🔔' },
];

const loading = ref(false);
const saveLoading = ref(false);
const pwdLoading = ref(false);
const uploadLoading = ref(false);
const fileInput = ref(null);

const form = reactive({
  shopName: '',
  email: '',
  phone: '',
  category: 'batik',
  description: '',
  address: '',
  avatarUrl: '',
  socials: { instagram: '', tokopedia: '', shopee: '', whatsapp: '' },
});

const passwordForm = reactive({
  currentPassword: '',
  password: '',
  passwordConfirmation: '',
});

const toast = ref({
  show: false,
  message: '',
  type: 'success',
});

const triggerToast = (message, type = 'success') => {
  toast.value.message = message;
  toast.value.type = type;
  toast.value.show = true;
  setTimeout(() => {
    toast.value.show = false;
  }, 4000);
};

const socialFields = [
  { key: 'instagram', label: 'Instagram', emoji: '📸', placeholder: '@username' },
  { key: 'tokopedia', label: 'Tokopedia', emoji: '🟢', placeholder: 'Nama Toko' },
  { key: 'shopee', label: 'Shopee', emoji: '🟠', placeholder: 'Username' },
  { key: 'whatsapp', label: 'WhatsApp', emoji: '💬', placeholder: '08xxxxxxxxxx' },
];

const sessions = ref([
  { id: 1, device: 'Chrome — Windows 11', location: 'Malang, ID', time: 'Aktif sekarang', emoji: '💻', current: true },
  { id: 2, device: 'Safari — iPhone 15', location: 'Malang, ID', time: '2 jam lalu', emoji: '📱', current: false },
]);

const notifSettings = ref([
  { label: 'Pesanan Baru', desc: 'Notifikasi saat ada pesanan masuk', enabled: true },
  { label: 'Chat Pembeli', desc: 'Pesan dari calon pembeli', enabled: true },
  { label: 'Co-Create Update', desc: 'Update dari room kolaborasi', enabled: true },
  { label: 'AI Studio Selesai', desc: 'Notif saat rendering AI selesai', enabled: false },
  { label: 'Promo & Tips', desc: 'Tips penjualan dan promo platform', enabled: false },
]);

const fetchProfile = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/profile', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      }
    });
    if (res.ok) {
      const data = await res.json();
      const user = data.user;
      const profile = user.profile || {};
      
      form.shopName = profile.business_name || user.name || '';
      form.email = user.email || '';
      form.phone = profile.phone || '';
      form.category = profile.category || 'batik';
      form.description = profile.bio || '';
      form.address = profile.address || '';
      form.avatarUrl = profile.avatar_url || '';
      
      const socials = profile.socials || {};
      form.socials = {
        instagram: socials.instagram || '',
        tokopedia: socials.tokopedia || '',
        shopee: socials.shopee || '',
        whatsapp: socials.whatsapp || '',
      };
    }
  } catch (e) {
    console.error('Failed to fetch profile:', e);
    triggerToast('Gagal memuat profil toko.', 'error');
  } finally {
    loading.value = false;
  }
};

const saveProfile = async () => {
  saveLoading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/profile', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        full_name: form.shopName,
        business_name: form.shopName,
        phone: form.phone,
        category: form.category,
        bio: form.description,
        address: form.address,
        avatar_url: form.avatarUrl,
        socials: form.socials,
        name: form.shopName,
        email: form.email,
      })
    });
    const data = await res.json();
    if (res.ok) {
      triggerToast('Profil toko berhasil disimpan!', 'success');
      window.dispatchEvent(new CustomEvent('profile-updated'));
    } else {
      triggerToast(data.message || 'Gagal menyimpan profil.', 'error');
    }
  } catch (e) {
    console.error('Failed to save profile:', e);
    triggerToast('Terjadi kesalahan koneksi.', 'error');
  } finally {
    saveLoading.value = false;
  }
};

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleAvatarUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  if (file.size > 2 * 1024 * 1024) {
    triggerToast('Ukuran file maksimal adalah 2MB.', 'error');
    return;
  }

  const formData = new FormData();
  formData.append('image', file);

  uploadLoading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/upload/avatar', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
      body: formData
    });
    const data = await res.json();
    if (res.ok) {
      form.avatarUrl = data.avatar_url;
      triggerToast('Foto profil berhasil diperbarui.', 'success');
      window.dispatchEvent(new CustomEvent('profile-updated'));
    } else {
      triggerToast(data.message || 'Gagal mengunggah foto.', 'error');
    }
  } catch (e) {
    console.error('Failed to upload avatar:', e);
    triggerToast('Terjadi kesalahan saat mengunggah.', 'error');
  } finally {
    uploadLoading.value = false;
    event.target.value = ''; // clear input
  }
};

const updatePassword = async () => {
  if (!passwordForm.currentPassword || !passwordForm.password || !passwordForm.passwordConfirmation) {
    triggerToast('Semua field password wajib diisi.', 'error');
    return;
  }
  if (passwordForm.password !== passwordForm.passwordConfirmation) {
    triggerToast('Konfirmasi password baru tidak sesuai.', 'error');
    return;
  }

  pwdLoading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/auth/change-password', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        current_password: passwordForm.currentPassword,
        password: passwordForm.password,
        password_confirmation: passwordForm.passwordConfirmation,
      })
    });
    const data = await res.json();
    if (res.ok) {
      triggerToast('Password berhasil diperbarui!', 'success');
      passwordForm.currentPassword = '';
      passwordForm.password = '';
      passwordForm.passwordConfirmation = '';
    } else {
      triggerToast(data.message || 'Gagal mengubah password.', 'error');
    }
  } catch (e) {
    console.error('Failed to update password:', e);
    triggerToast('Gagal memproses password.', 'error');
  } finally {
    pwdLoading.value = false;
  }
};

const removeSession = (id) => {
  sessions.value = sessions.value.filter(s => s.id !== id);
  triggerToast('Sesi perangkat berhasil dihentikan.', 'success');
};

const toggleNotif = (index) => {
  notifSettings.value[index].enabled = !notifSettings.value[index].enabled;
  triggerToast(`Preferensi "${notifSettings.value[index].label}" berhasil diperbarui.`, 'success');
};

onMounted(() => {
  fetchProfile();
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(1rem) scale(0.95);
}
</style>
