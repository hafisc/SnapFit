<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full max-w-4xl">
    <!-- Header -->
    <div>
      <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Profil</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Kelola informasi akun dan preferensi Anda</p>
    </div>

    <!-- Profile Card -->
    <section class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden">
      <!-- Banner -->
      <div class="h-36 bg-gradient-to-r from-orange-500 to-orange-600 relative">
        <div class="absolute -bottom-12 left-8">
          <div class="w-24 h-24 rounded-3xl bg-white border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
            <div class="w-full h-full bg-orange-500 flex items-center justify-center font-bold text-3xl text-white">
              {{ form.fullName ? form.fullName.charAt(0) : 'D' }}
            </div>
          </div>
          <button class="absolute -bottom-1 -right-1 w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-xl flex items-center justify-center shadow-md transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
          </button>
        </div>
      </div>

      <div class="pt-16 pb-8 px-8">
        <h3 class="text-xl font-bold text-slate-800">{{ form.fullName || 'Designer' }}</h3>
        <p class="text-sm text-slate-500 font-medium">{{ form.email }}</p>
      </div>
    </section>

    <!-- Personal Info -->
    <section class="bg-white rounded-2xl border border-slate-200/60 p-6 md:p-8">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Personal</h3>
          <p class="text-xs text-slate-400 font-medium mt-1">Data diri dan kontak</p>
        </div>
        <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-3 py-1.5 rounded-lg border border-orange-100">Desainer</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Nama Lengkap</label>
          <input v-model="form.fullName" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Email</label>
          <input v-model="form.email" type="email" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">No. Telepon</label>
          <input v-model="form.phone" type="tel" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Lokasi</label>
          <input v-model="form.location" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
        <div class="md:col-span-2">
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Bio / Deskripsi</label>
          <textarea v-model="form.bio" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all resize-none"></textarea>
          <p class="text-[10px] text-slate-400 font-medium mt-1.5 text-right">{{ form.bio.length }}/500</p>
        </div>
      </div>
    </section>

    <!-- Skills & Expertise -->
    <section class="bg-white rounded-2xl border border-slate-200/60 p-6 md:p-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Skill & Keahlian</h3>
          <p class="text-xs text-slate-400 font-medium mt-1">Tambahkan keahlian Anda</p>
        </div>
      </div>

      <div class="flex flex-wrap gap-2 mb-4">
        <span v-for="(skill, idx) in form.skills" :key="idx"
          class="px-3 py-1.5 bg-orange-50 text-orange-600 text-[11px] font-bold rounded-xl border border-orange-100 flex items-center gap-2 group">
          {{ skill }}
          <button @click="removeSkill(idx)" class="w-4 h-4 bg-orange-200 hover:bg-red-400 hover:text-white rounded-full flex items-center justify-center text-[10px] text-orange-500 transition-colors">✕</button>
        </span>
      </div>

      <div class="flex items-center gap-2">
        <input v-model="newSkill" @keyup.enter="addSkill" type="text" placeholder="Tambah skill baru..." class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        <button @click="addSkill" class="px-5 py-3 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold uppercase tracking-wider rounded-2xl transition-colors">Tambah</button>
      </div>
    </section>

    <!-- Social Links -->
    <section class="bg-white rounded-2xl border border-slate-200/60 p-6 md:p-8">
      <div class="mb-6">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Link Sosial Media</h3>
        <p class="text-xs text-slate-400 font-medium mt-1">Tampilkan di profil publik Anda</p>
      </div>

      <div class="space-y-4">
        <div v-for="social in socialLinks" :key="social.key" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" :class="social.bgClass">{{ social.emoji }}</div>
          <div class="flex-1">
            <input v-model="form.socials[social.key]" type="url" :placeholder="social.placeholder" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
          </div>
        </div>
      </div>
    </section>

    <!-- Password Change -->
    <section class="bg-white rounded-2xl border border-slate-200/60 p-6 md:p-8">
      <div class="mb-6">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Ubah Password</h3>
        <p class="text-xs text-slate-400 font-medium mt-1">Pastikan menggunakan password yang kuat</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Password Lama</label>
          <input v-model="passwordForm.current" type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
        <div></div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Password Baru</label>
          <input v-model="passwordForm.newPassword" type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
        <div>
          <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">Konfirmasi Password</label>
          <input v-model="passwordForm.confirm" type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
        </div>
      </div>

      <button class="mt-6 px-6 py-3.5 bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-colors">
        Update Password
      </button>
    </section>

    <!-- Notification Preferences -->
    <section class="bg-white rounded-2xl border border-slate-200/60 p-6 md:p-8">
      <div class="mb-6">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Preferensi Notifikasi</h3>
        <p class="text-xs text-slate-400 font-medium mt-1">Atur notifikasi yang ingin Anda terima</p>
      </div>

      <div class="space-y-5">
        <div v-for="pref in notifPreferences" :key="pref.key" class="flex items-center justify-between py-2">
          <div>
            <p class="text-sm font-bold text-slate-800">{{ pref.label }}</p>
            <p class="text-xs text-slate-500 font-medium">{{ pref.desc }}</p>
          </div>
          <button @click="pref.enabled = !pref.enabled"
            class="w-12 h-7 rounded-full transition-colors duration-200 relative flex-shrink-0"
            :class="pref.enabled ? 'bg-orange-500' : 'bg-slate-200'">
            <span class="absolute top-1 left-1 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200"
              :class="pref.enabled ? 'translate-x-5' : ''"></span>
          </button>
        </div>
      </div>
    </section>

    <!-- Save Actions -->
    <div class="flex items-center justify-end gap-3 pb-8">
      <button class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-colors">Batal</button>
      <button @click="saveProfile" class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all shadow-sm active:scale-95">
        {{ saving ? 'Menyimpan...' : 'Simpan Perubahan' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const saving = ref(false);
const newSkill = ref('');
const user = JSON.parse(localStorage.getItem('user') || '{}');

const form = reactive({
  fullName: user.name || 'Reza Firmansyah',
  email: user.email || 'reza@snapfit.id',
  phone: '083456789012',
  location: 'Malang, Jawa Timur',
  bio: 'Desainer grafis dan produk dengan 5 tahun pengalaman di industri kreatif. Spesialisasi dalam packaging, branding, dan konten visual untuk UMKM.',
  skills: ['UI/UX Design', 'Packaging', 'Branding', 'Product Photography', 'Social Media', 'Typography', 'Illustration', 'Logo Design', 'Figma', 'Adobe Photoshop'],
  socials: { instagram: '', dribbble: '', behance: '', linkedin: '' },
});

const passwordForm = reactive({ current: '', newPassword: '', confirm: '' });

const socialLinks = [
  { key: 'instagram', emoji: '📸', placeholder: 'https://instagram.com/username', bgClass: 'bg-pink-50' },
  { key: 'dribbble', emoji: '🏀', placeholder: 'https://dribbble.com/username', bgClass: 'bg-rose-50' },
  { key: 'behance', emoji: '🎨', placeholder: 'https://behance.net/username', bgClass: 'bg-blue-50' },
  { key: 'linkedin', emoji: '💼', placeholder: 'https://linkedin.com/in/username', bgClass: 'bg-sky-50' },
];

const notifPreferences = reactive([
  { key: 'invitation', label: 'Undangan Kolaborasi', desc: 'Notifikasi saat UMKM mengirim undangan', enabled: true },
  { key: 'room', label: 'Aktivitas Room', desc: 'Update dari room kolaborasi aktif', enabled: true },
  { key: 'review', label: 'Review & Rating', desc: 'Notifikasi saat menerima review baru', enabled: true },
  { key: 'newsletter', label: 'Newsletter', desc: 'Tips desain dan info platform terbaru', enabled: false },
]);

const addSkill = () => {
  if (newSkill.value.trim() && !form.skills.includes(newSkill.value.trim())) {
    form.skills.push(newSkill.value.trim());
    newSkill.value = '';
  }
};
const removeSkill = (idx) => { form.skills.splice(idx, 1); };

const saveProfile = async () => {
  saving.value = true;
  setTimeout(() => { saving.value = false; }, 1500);
};
</script>
