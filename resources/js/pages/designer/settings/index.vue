<template>
  <div class="w-full animate-in fade-in slide-in-from-bottom-4 duration-500">
    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
      
      <!-- Left Column: Designer Card & Vertical Navigation -->
      <div class="lg:col-span-1 space-y-5">
        
        <!-- Designer Profile Overview Card -->
        <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col items-center text-center shadow-sm relative overflow-hidden">
          <!-- Decorative Top Pattern -->
          <div class="absolute top-0 inset-x-0 h-1.5 bg-[#B85C38]"></div>
          
          <!-- Avatar Uploader -->
          <div @click="triggerFileInput" class="relative w-24 h-24 rounded-3xl bg-[#F8F1E7] overflow-hidden flex items-center justify-center border-4 border-white shadow-md cursor-pointer hover:scale-105 group transition-all duration-300 ring-2 ring-[#B85C38]/20">
            <img v-if="form.avatarUrl" :src="form.avatarUrl" class="w-full h-full object-cover group-hover:opacity-75 transition-opacity" />
            <div v-else class="w-full h-full bg-[#B85C38] flex items-center justify-center font-bold text-3xl text-white group-hover:opacity-75 transition-opacity">
              {{ form.fullName ? form.fullName.charAt(0) : 'D' }}
            </div>
            
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
          
          <!-- Designer details -->
          <h4 class="font-bold text-[#2B1E16] text-base mt-4 leading-tight truncate max-w-full">{{ form.fullName || 'Nama Desainer' }}</h4>
          <p class="text-[11px] text-[#8A7A6C] mt-1 truncate max-w-full">{{ form.email || 'email@desainer.com' }}</p>
          
          <!-- Badges -->
          <div class="flex flex-wrap justify-center gap-1.5 mt-3.5">
            <span class="text-[9px] font-bold uppercase tracking-wider text-[#B85C38] bg-[#B85C38]/10 px-2.5 py-1 rounded-lg border border-[#B85C38]/20">Desainer</span>
            <span class="text-[9px] font-bold uppercase tracking-wider text-[#0F8A4B] bg-[#0F8A4B]/10 px-2.5 py-1 rounded-lg border border-[#0F8A4B]/20">Terverifikasi</span>
          </div>
        </div>

        <!-- Vertical Tab Navigation -->
        <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-2 shadow-sm space-y-1">
          <button v-for="t in tabs" :key="t.key" @click="activeTab = t.key"
            class="w-full text-left px-4 py-3 text-[12px] font-bold rounded-xl transition-all flex items-center gap-3 cursor-pointer outline-none border-0"
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
          
          <!-- Tab Panel: Profil Desainer -->
          <div v-if="activeTab === 'profil'" class="space-y-5">
            <!-- Informasi Personal Form -->
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Informasi Personal</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Nama Lengkap</label>
                  <input v-model="form.fullName" type="text" placeholder="Nama lengkap Anda..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Email</label>
                  <input v-model="form.email" type="email" placeholder="Alamat email kontak..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">No. Telepon</label>
                  <input v-model="form.phone" type="text" placeholder="Contoh: 081234567890" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div>
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Lokasi / Kota</label>
                  <input v-model="form.address" type="text" placeholder="Contoh: Malang, Jawa Timur" class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                </div>
                <div class="md:col-span-2">
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">Bio / Deskripsi</label>
                  <textarea v-model="form.bio" rows="4" placeholder="Ceritakan latar belakang, fokus desain, dan pengalaman kreatif Anda..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all resize-none placeholder-[#8A7A6C]/50"></textarea>
                  <p class="text-[10px] text-[#8A7A6C] font-semibold mt-1.5 text-right">{{ form.bio ? form.bio.length : 0 }}/500</p>
                </div>
              </div>
              
              <!-- Save button -->
              <div class="flex justify-end mt-6 pt-5 border-t border-[#E8DCCB]/40">
                <button @click="saveProfile" :disabled="saveLoading" class="bg-[#B85C38] hover:bg-[#A04E2D] disabled:bg-[#B85C38]/60 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold transition-all flex items-center gap-2 cursor-pointer shadow-sm shadow-[#B85C38]/10 hover:shadow-md active:scale-95 duration-150 outline-none border-0">
                  <svg v-if="saveLoading" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ saveLoading ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
              </div>
            </div>
          </div>

          <!-- Tab Panel: Skill & Keahlian -->
          <div v-if="activeTab === 'skills'" class="space-y-5">
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Keahlian & Bidang Desain</h3>
              
              <p class="text-[11.5px] text-[#8A7A6C] font-medium mb-5 leading-relaxed">
                Kelola daftar keahlian, alat bantu desain, dan bidang spesialisasi yang Anda kuasai. Tag ini akan mempermudah UMKM menemukan profil Anda untuk kolaborasi.
              </p>

              <!-- Skill Tags Container -->
              <div class="flex flex-wrap gap-2 mb-6">
                <span v-for="(skill, idx) in form.skills" :key="idx"
                  class="px-3 py-1.5 bg-[#FAF6F0] text-[#B85C38] text-[11px] font-bold rounded-xl border border-[#B85C38]/20 flex items-center gap-2 group hover:border-[#B85C38]/40 transition-colors">
                  {{ skill }}
                  <button @click="removeSkill(idx)" class="w-4 h-4 bg-[#B85C38]/10 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center text-[10px] text-[#B85C38] transition-colors border-0 p-0 cursor-pointer">✕</button>
                </span>
                <p v-if="form.skills.length === 0" class="text-xs text-[#8A7A6C] italic font-medium">Belum ada skill yang ditambahkan.</p>
              </div>

              <!-- Input and Add -->
              <div class="flex items-center gap-2.5 max-w-lg">
                <input v-model="newSkill" @keyup.enter="addSkill" type="text" placeholder="Ketik keahlian (contoh: Packaging, Figma, Branding)..." class="flex-1 bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl px-4 py-2.5 text-[13px] text-[#2B1E16] font-medium outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/50" />
                <button @click="addSkill" class="px-5 py-2.5 bg-[#2B1E16] hover:bg-[#403025] text-white text-[11px] font-bold uppercase tracking-wider rounded-xl transition-all cursor-pointer border-0 active:scale-95">Tambah</button>
              </div>

              <!-- Save button -->
              <div class="flex justify-end mt-8 pt-5 border-t border-[#E8DCCB]/40">
                <button @click="saveProfile" :disabled="saveLoading" class="bg-[#B85C38] hover:bg-[#A04E2D] disabled:bg-[#B85C38]/60 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold transition-all flex items-center gap-2 cursor-pointer shadow-sm shadow-[#B85C38]/10 hover:shadow-md active:scale-95 duration-150 outline-none border-0">
                  <svg v-if="saveLoading" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ saveLoading ? 'Menyimpan...' : 'Simpan Keahlian' }}
                </button>
              </div>
            </div>
          </div>

          <!-- Tab Panel: Media Sosial -->
          <div v-if="activeTab === 'socials'" class="space-y-5">
            <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 shadow-sm">
              <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5 pb-3 border-b border-[#E8DCCB]/40">Tautan Sosial & Portfolio</h3>
              
              <p class="text-[11.5px] text-[#8A7A6C] font-medium mb-5 leading-relaxed">
                Tambahkan link portofolio eksternal dan media sosial Anda agar mitra UMKM dapat melihat lebih banyak kreasi dan desain yang pernah Anda buat.
              </p>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-for="s in socialFields" :key="s.key">
                  <label class="text-[11px] font-bold text-[#6F6259] block mb-1.5">{{ s.label }}</label>
                  <div class="flex items-center bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl overflow-hidden focus-within:border-[#B85C38] focus-within:ring-2 focus-within:ring-[#B85C38]/10 transition-all">
                    <span class="px-3.5 py-2.5 text-sm border-r border-[#E8DCCB] bg-[#F8F1E7] text-[#2B1E16] font-semibold">{{ s.emoji }}</span>
                    <input v-model="form.socials[s.key]" type="text" :placeholder="s.placeholder" class="flex-1 bg-transparent px-3.5 py-2.5 text-[13px] text-[#2B1E16] font-semibold outline-none placeholder-[#8A7A6C]/40 border-0" />
                  </div>
                </div>
              </div>

              <!-- Save button -->
              <div class="flex justify-end mt-6 pt-5 border-t border-[#E8DCCB]/40">
                <button @click="saveProfile" :disabled="saveLoading" class="bg-[#B85C38] hover:bg-[#A04E2D] disabled:bg-[#B85C38]/60 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold transition-all flex items-center gap-2 cursor-pointer shadow-sm shadow-[#B85C38]/10 hover:shadow-md active:scale-95 duration-150 outline-none border-0">
                  <svg v-if="saveLoading" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ saveLoading ? 'Menyimpan...' : 'Simpan Media Sosial' }}
                </button>
              </div>
            </div>
          </div>

          <!-- Tab Panel: Keamanan Akun -->
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
                <button @click="updatePassword" :disabled="pwdLoading" class="bg-[#2B1E16] hover:bg-[#403025] disabled:bg-[#2B1E16]/60 text-white px-5 py-2.5 rounded-xl text-[11px] font-bold transition-all flex items-center gap-2 cursor-pointer shadow-sm hover:shadow-md active:scale-95 duration-150 outline-none border-0">
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
              <p class="text-[11px] text-[#8A7A6C] font-medium mb-5">Daftar perangkat yang memiliki hak akses aktif login ke akun desainer Anda.</p>
              
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
                  <button v-else @click="removeSession(s.id)" class="text-[10px] font-bold text-[#D94A38] hover:text-[#B83C2D] bg-[#D94A38]/10 hover:bg-[#D94A38]/20 px-2.5 py-1 rounded-lg transition-colors cursor-pointer border-0 outline-none">Hapus Sesi</button>
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
                  <button @click="toggleNotif(idx)" class="w-10 h-5.5 rounded-full transition-colors duration-200 relative cursor-pointer outline-none border-0 p-0" :class="n.enabled ? 'bg-[#B85C38]' : 'bg-[#E8DCCB]'">
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
  { key: 'profil', label: 'Profil Desainer', emoji: '🧑‍🎨' },
  { key: 'skills', label: 'Skill & Keahlian', emoji: '🛠️' },
  { key: 'socials', label: 'Media Sosial', emoji: '🌐' },
  { key: 'keamanan', label: 'Keamanan Akun', emoji: '🔒' },
  { key: 'notifikasi', label: 'Notifikasi', emoji: '🔔' },
];

const loading = ref(false);
const saveLoading = ref(false);
const pwdLoading = ref(false);
const uploadLoading = ref(false);
const fileInput = ref(null);

const form = reactive({
  fullName: '',
  email: '',
  phone: '',
  address: '',
  bio: '',
  avatarUrl: '',
  skills: [],
  socials: { instagram: '', dribbble: '', behance: '', linkedin: '' },
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
  { key: 'instagram', label: 'Instagram', emoji: '📸', placeholder: 'https://instagram.com/username' },
  { key: 'dribbble', label: 'Dribbble', emoji: '🏀', placeholder: 'https://dribbble.com/username' },
  { key: 'behance', label: 'Behance', emoji: '🎨', placeholder: 'https://behance.net/username' },
  { key: 'linkedin', label: 'LinkedIn', emoji: '💼', placeholder: 'https://linkedin.com/in/username' },
];

const sessions = ref([
  { id: 1, device: 'Chrome — Windows 11', location: 'Malang, ID', time: 'Aktif sekarang', emoji: '💻', current: true },
  { id: 2, device: 'Safari — iPhone 15', location: 'Malang, ID', time: '2 jam lalu', emoji: '📱', current: false },
]);

const notifSettings = ref([
  { label: 'Undangan Kolaborasi', desc: 'Notifikasi saat UMKM mengirim undangan baru', enabled: true },
  { label: 'Aktivitas Room', desc: 'Pemberitahuan perubahan dan pesan baru di room Co-Create', enabled: true },
  { label: 'Review & Rating', desc: 'Notifikasi saat menerima ulasan baru dari mitra UMKM', enabled: true },
  { label: 'Newsletter & Update', desc: 'Tips desain mingguan dan fitur platform terbaru', enabled: false },
]);

const newSkill = ref('');
const addSkill = () => {
  const cleanSkill = newSkill.value.trim();
  if (cleanSkill && !form.skills.includes(cleanSkill)) {
    form.skills.push(cleanSkill);
    newSkill.value = '';
  }
};
const removeSkill = (index) => {
  form.skills.splice(index, 1);
};

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
      
      form.fullName = profile.full_name || user.name || '';
      form.email = user.email || '';
      form.phone = profile.phone || '';
      form.address = profile.address || '';
      form.bio = profile.bio || '';
      form.avatarUrl = profile.avatar_url || '';
      form.skills = profile.skills || ['UI/UX Design', 'Packaging', 'Branding', 'Product Photography', 'Figma', 'Adobe Photoshop'];
      
      const socials = profile.socials || {};
      form.socials = {
        instagram: socials.instagram || '',
        dribbble: socials.dribbble || '',
        behance: socials.behance || '',
        linkedin: socials.linkedin || '',
      };
    }
  } catch (e) {
    console.error('Failed to fetch profile:', e);
    triggerToast('Gagal memuat profil desainer.', 'error');
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
        full_name: form.fullName,
        phone: form.phone,
        address: form.address,
        bio: form.bio,
        avatar_url: form.avatarUrl,
        socials: form.socials,
        skills: form.skills,
        name: form.fullName,
        email: form.email,
      })
    });
    const data = await res.json();
    if (res.ok) {
      triggerToast('Profil desainer berhasil disimpan!', 'success');
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
