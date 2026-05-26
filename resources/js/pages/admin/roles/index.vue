<template>
  <div class="space-y-6 max-w-[1400px]">
    <!-- Tab Navigation -->
    <div class="flex bg-[#F8F1E7]/60 border border-[#E8DCCB] rounded-2xl p-1 gap-1 max-w-md">
      <button @click="currentTab = 'matrix'" 
        class="flex-1 py-2.5 text-[11px] font-bold uppercase tracking-wider rounded-xl transition-all"
        :class="currentTab === 'matrix' ? 'bg-[#B85C38] text-white shadow-sm' : 'text-[#8A7A6C] hover:bg-[#F8F1E7] hover:text-[#2B1E16]'">
        Matriks Hak Akses
      </button>
      <button @click="currentTab = 'verification'" 
        class="flex-1 py-2.5 text-[11px] font-bold uppercase tracking-wider rounded-xl transition-all"
        :class="currentTab === 'verification' ? 'bg-[#B85C38] text-white shadow-sm' : 'text-[#8A7A6C] hover:bg-[#F8F1E7] hover:text-[#2B1E16]'">
        Verifikasi Pendaftaran
      </button>
    </div>

    <!-- TAB 1: PERMISSION MATRIX -->
    <div v-if="currentTab === 'matrix'" class="space-y-5 animate-in fade-in duration-300">
      <!-- Roles Overview -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div v-for="r in roles" :key="r.name"
          class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-5 cursor-pointer hover:shadow-md transition-all group"
          :class="selectedRole === r.name ? 'ring-2 ring-[#B85C38]/30 border-[#B85C38]/30' : ''" @click="selectedRole = r.name">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-[#FAFAF8] border border-[#E8DCCB]/40">
              <span class="text-lg">{{ r.emoji }}</span>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md" :class="r.countBg">{{ r.count }} user</span>
          </div>
          <h3 class="text-[14px] font-bold text-[#2B1E16] mb-0.5 group-hover:text-[#B85C38] transition-colors">{{ r.label }}</h3>
          <p class="text-[11px] text-slate-400 font-medium leading-relaxed">{{ r.desc }}</p>
        </div>
      </div>

      <!-- Permission Matrix Table -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 overflow-hidden">
        <div class="px-6 py-5 border-b border-[#E8DCCB]/60 flex items-center justify-between bg-[#FFFCF7]">
          <div>
            <h3 class="text-[14px] font-bold text-[#2B1E16]">Permission Matrix</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Kelola hak akses untuk role: <span class="text-[#B85C38] font-bold capitalize">{{ selectedRole }}</span></p>
          </div>
          <button @click="savePermissions" class="px-4 py-2 bg-[#2B1E16] hover:bg-[#1E140E] text-white text-[11px] font-bold rounded-xl transition-colors shadow-sm">
            Simpan Perubahan
          </button>
        </div>

        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-[#E8DCCB]/60 bg-[#FFFCF7]/40">
              <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 w-1/3">Modul</th>
              <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Lihat</th>
              <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Buat</th>
              <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Edit</th>
              <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Hapus</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#E8DCCB]/30">
            <tr v-for="perm in currentPermissions" :key="perm.module" class="hover:bg-slate-50/60 transition-colors">
              <td class="px-6 py-3.5">
                <div class="flex items-center gap-2.5">
                  <span class="text-sm">{{ perm.emoji }}</span>
                  <div>
                    <p class="text-[12px] font-semibold text-[#2B1E16]">{{ perm.module }}</p>
                    <p class="text-[10px] text-slate-400">{{ perm.desc }}</p>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3.5 text-center">
                <button @click="perm.view = !perm.view" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                  :class="perm.view ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                  <svg v-if="perm.view" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </td>
              <td class="px-4 py-3.5 text-center">
                <button @click="perm.create = !perm.create" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                  :class="perm.create ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                  <svg v-if="perm.create" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </td>
              <td class="px-4 py-3.5 text-center">
                <button @click="perm.edit = !perm.edit" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                  :class="perm.edit ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                  <svg v-if="perm.edit" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </td>
              <td class="px-4 py-3.5 text-center">
                <button @click="perm.delete = !perm.delete" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                  :class="perm.delete ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                  <svg v-if="perm.delete" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- TAB 2: ROLE APPLICATION VERIFICATION -->
    <div v-else-if="currentTab === 'verification'" class="space-y-5 animate-in fade-in duration-300">
      <!-- Filter status -->
      <div class="flex items-center justify-between bg-white px-5 py-3 rounded-2xl border border-[#E8DCCB]/60">
        <div class="flex items-center gap-2">
          <span class="text-[11px] font-bold uppercase tracking-wider text-[#8A7A6C]">Filter Status:</span>
          <div class="flex gap-1">
            <button v-for="f in filterStatuses" :key="f.value" @click="selectedStatus = f.value; fetchApplications()"
              class="px-3 py-1 text-[10px] font-bold rounded-lg border transition-all capitalize"
              :class="selectedStatus === f.value ? 'bg-[#B85C38] text-white border-transparent' : 'bg-slate-50 text-muted border-[#E8DCCB]/60 hover:bg-slate-100'">
              {{ f.label }}
            </button>
          </div>
        </div>
        <button @click="fetchApplications" class="p-2 text-[#8A7A6C] hover:text-[#B85C38] transition-colors" title="Refresh">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3 3L22 4" /></svg>
        </button>
      </div>

      <!-- Main Applications List -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 overflow-hidden">
        <div v-if="loadingApps" class="p-20 text-center">
          <div class="w-10 h-10 border-3 border-[#E8DCCB] border-t-[#B85C38] rounded-full animate-spin mx-auto mb-4"></div>
          <p class="text-xs text-[#8A7A6C] font-semibold">Memuat pengajuan pendaftaran...</p>
        </div>

        <div v-else-if="applications.length === 0" class="p-20 text-center bg-[#FFFCF7]/30">
          <div class="text-5xl mb-4">📋</div>
          <h3 class="text-sm font-bold text-[#2B1E16] mb-1">Tidak Ada Pengajuan</h3>
          <p class="text-xs text-slate-400 font-medium">Belum ada pengajuan pendaftaran role yang sesuai dengan filter ini.</p>
        </div>

        <div v-else class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="border-b border-[#E8DCCB]/60 bg-[#FFFCF7]/40">
                <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Pemohon</th>
                <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Role Diminta</th>
                <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Verifikasi AI</th>
                <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pengajuan</th>
                <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#E8DCCB]/30">
              <template v-for="app in applications" :key="app.id">
                <!-- Main row -->
                <tr class="hover:bg-slate-50/60 transition-colors cursor-pointer" @click="toggleRow(app.id)">
                  <td class="px-6 py-4">
                    <div>
                      <p class="text-[12px] font-bold text-[#2B1E16]">{{ app.user?.name }}</p>
                      <p class="text-[10px] text-slate-400">{{ app.user?.email }}</p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-md"
                      :class="app.requested_role === 'umkm' ? 'bg-[#F8F1E7] text-[#B85C38]' : 'bg-blue-50 text-blue-600'">
                      {{ app.requested_role === 'umkm' ? '🏪 UMKM' : '🎨 Desainer' }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[11px]"
                        :class="getScoreClass(app.ai_score)">
                        {{ app.ai_score || 'N/A' }}
                      </span>
                      <p class="text-[10px] text-[#2B1E16]/80 font-medium truncate max-w-[200px]">{{ app.ai_summary || 'Menunggu AI...' }}</p>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-[11px] font-medium text-slate-400">
                    {{ formatDate(app.submitted_at) }}
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-full"
                      :class="getStatusClass(app.status)">
                      {{ getStatusLabel(app.status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right" @click.stop>
                    <div v-if="app.status === 'need_review' || app.status === 'ai_reviewing'" class="flex items-center justify-end gap-1.5">
                      <button @click="approveApp(app.id)" class="px-2.5 py-1.5 bg-[#B85C38] hover:bg-[#964726] text-white text-[10px] font-bold rounded-lg transition-colors">
                        Setujui
                      </button>
                      <button @click="openRejectModal(app)" class="px-2.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 text-[10px] font-bold rounded-lg transition-colors border border-red-200">
                        Tolak
                      </button>
                    </div>
                    <div v-else class="text-[11px] font-medium text-slate-400 italic">
                      {{ app.status === 'approved' ? 'Telah Disetujui' : 'Telah Ditolak' }}
                    </div>
                  </td>
                </tr>

                <!-- Expandable Details row -->
                <tr v-if="expandedRows.includes(app.id)" class="bg-[#FAFAF8]/50">
                  <td colspan="6" class="px-8 py-5 border-t border-[#E8DCCB]/40">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[12px]">
                      <!-- Left column: Questionnaire data -->
                      <div class="space-y-4">
                        <h4 class="font-bold text-[#2B1E16] border-b border-[#E8DCCB] pb-1.5 uppercase tracking-wider text-[10px]">Data Pengajuan</h4>
                        
                        <div class="grid grid-cols-3 gap-2">
                          <template v-if="app.requested_role === 'umkm'">
                            <span class="text-slate-400 font-semibold">Nama Toko:</span>
                            <span class="col-span-2 text-[#2B1E16] font-bold">{{ app.data?.store_name }}</span>
                            
                            <span class="text-slate-400 font-semibold">Owner:</span>
                            <span class="col-span-2 text-[#2B1E16]">{{ app.data?.owner_name }}</span>
                            
                            <span class="text-slate-400 font-semibold">Kategori:</span>
                            <span class="col-span-2"><span class="px-2 py-0.5 bg-slate-100 rounded text-[10px]">{{ app.data?.category }}</span></span>

                            <span class="text-slate-400 font-semibold">Kota Asal:</span>
                            <span class="col-span-2 text-[#2B1E16]">{{ app.data?.origin_city }}</span>

                            <span class="text-slate-400 font-semibold">Alamat Lengkap:</span>
                            <span class="col-span-2 text-[#2B1E16]">{{ app.data?.address }}</span>

                            <span class="text-slate-400 font-semibold">No. WhatsApp:</span>
                            <span class="col-span-2 text-[#2B1E16] font-mono">{{ app.data?.whatsapp }}</span>

                            <span class="text-slate-400 font-semibold">Deskripsi:</span>
                            <span class="col-span-2 text-[#2B1E16] leading-relaxed">{{ app.data?.description }}</span>

                            <span class="text-slate-400 font-semibold">Brand Story:</span>
                            <span class="col-span-2 text-[#2B1E16] leading-relaxed">{{ app.data?.brand_story || '-' }}</span>
                          </template>

                          <template v-else>
                            <span class="text-slate-400 font-semibold">Nama Display:</span>
                            <span class="col-span-2 text-[#2B1E16] font-bold">{{ app.data?.display_name }}</span>

                            <span class="text-slate-400 font-semibold">Kota Domisili:</span>
                            <span class="col-span-2 text-[#2B1E16]">{{ app.data?.city }}</span>

                            <span class="text-slate-400 font-semibold">Keahlian (Skills):</span>
                            <span class="col-span-2 flex flex-wrap gap-1">
                              <span v-for="sk in app.data?.skills" :key="sk" class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[9px] font-bold">{{ sk }}</span>
                            </span>

                            <span class="text-slate-400 font-semibold">Tools Desain:</span>
                            <span class="col-span-2 flex flex-wrap gap-1">
                              <span v-for="tl in app.data?.tools" :key="tl" class="px-2 py-0.5 bg-[#F8F1E7] text-[#B85C38] rounded text-[9px] font-bold">{{ tl }}</span>
                            </span>

                            <span class="text-slate-400 font-semibold">Bio:</span>
                            <span class="col-span-2 text-[#2B1E16] leading-relaxed">{{ app.data?.bio }}</span>

                            <span class="text-slate-400 font-semibold">Pengalaman:</span>
                            <span class="col-span-2 text-[#2B1E16] leading-relaxed">{{ app.data?.experience }}</span>

                            <span class="text-slate-400 font-semibold">Rate Jasa:</span>
                            <span class="col-span-2 text-[#2B1E16]">{{ app.data?.rate || '-' }}</span>

                            <span class="text-slate-400 font-semibold">No. WhatsApp:</span>
                            <span class="col-span-2 text-[#2B1E16] font-mono">{{ app.data?.whatsapp }}</span>
                          </template>
                        </div>

                        <!-- Documents & Media Links -->
                        <div class="mt-4 pt-3 border-t border-[#E8DCCB]/40 space-y-2">
                          <h5 class="font-bold text-[#2B1E16] text-[10px] uppercase tracking-wider">Tautan & Lampiran</h5>
                          <div class="flex flex-wrap gap-2">
                            <a v-if="app.data?.instagram" :href="app.data?.instagram" target="_blank" class="px-3 py-1.5 bg-slate-50 border border-[#E8DCCB]/60 rounded-lg hover:border-[#B85C38] hover:text-[#B85C38] transition-colors flex items-center gap-1.5">
                              📸 Instagram
                            </a>
                            <a v-if="app.data?.website" :href="app.data?.website" target="_blank" class="px-3 py-1.5 bg-slate-50 border border-[#E8DCCB]/60 rounded-lg hover:border-[#B85C38] hover:text-[#B85C38] transition-colors flex items-center gap-1.5">
                              🌐 Website
                            </a>
                            <a v-if="app.data?.portfolio_url" :href="app.data?.portfolio_url" target="_blank" class="px-3 py-1.5 bg-slate-50 border border-[#E8DCCB]/60 rounded-lg hover:border-[#B85C38] hover:text-[#B85C38] transition-colors flex items-center gap-1.5">
                              🖼️ Portofolio
                            </a>
                            <a v-if="app.data?.identity_document_url" :href="app.data?.identity_document_url" target="_blank" class="px-3 py-1.5 bg-[#B85C38]/10 text-[#B85C38] border border-[#B85C38]/20 rounded-lg hover:bg-[#B85C38]/20 transition-all flex items-center gap-1.5 font-semibold">
                              📇 Lihat KTP / Dokumen Identitas
                            </a>
                            <a v-if="app.data?.sample_product_image" :href="app.data?.sample_product_image" target="_blank" class="px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg hover:bg-blue-100 transition-all flex items-center gap-1.5 font-semibold">
                              🛍️ Foto Produk Sampel
                            </a>
                            <a v-if="app.data?.sample_work_url" :href="app.data?.sample_work_url" target="_blank" class="px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg hover:bg-blue-100 transition-all flex items-center gap-1.5 font-semibold">
                              🎨 Karya Sampel / Dribbble
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- Right column: AI verification results -->
                      <div class="space-y-4 bg-[#FFFCF7] p-4 rounded-xl border border-[#E8DCCB]/60">
                        <h4 class="font-bold text-[#2B1E16] border-b border-[#E8DCCB] pb-1.5 uppercase tracking-wider text-[10px] flex items-center gap-1.5">
                          <span>🤖 Laporan Verifikasi AI Groq</span>
                        </h4>
                        
                        <div class="space-y-3">
                          <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Ringkasan Analisis</p>
                            <p class="text-[#2B1E16] font-medium leading-relaxed mt-0.5">{{ app.ai_summary || 'Menunggu verifikasi AI selesai.' }}</p>
                          </div>

                          <div v-if="app.ai_issues && app.ai_issues.length > 0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-red-500">Temuan Masalah / Warning</p>
                            <ul class="list-disc pl-4 mt-1 space-y-1.5 text-red-700/80 font-medium">
                              <li v-for="(iss, idx) in app.ai_issues" :key="idx">{{ iss }}</li>
                            </ul>
                          </div>

                          <div v-if="app.ai_recommendations && app.ai_recommendations.length > 0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Rekomendasi Tindakan</p>
                            <ul class="list-disc pl-4 mt-1 space-y-1 text-emerald-700/80 font-medium">
                              <li v-for="(rec, idx) in app.ai_recommendations" :key="idx">{{ rec }}</li>
                            </ul>
                          </div>

                          <div v-if="app.rejection_reason" class="bg-red-50 border border-red-200 p-3 rounded-lg">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-red-600">Alasan Penolakan Admin</p>
                            <p class="text-red-700 font-medium mt-0.5">{{ app.rejection_reason }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="applications.length > 0 && totalPages > 1" class="px-6 py-4 border-t border-[#E8DCCB]/60 flex items-center justify-between bg-[#FFFCF7]/20">
          <p class="text-[11px] font-medium text-slate-400">Menampilkan halaman {{ currentPage }} dari {{ totalPages }}</p>
          <div class="flex gap-1">
            <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 bg-slate-50 border border-[#E8DCCB]/60 hover:bg-slate-100 rounded-lg text-[10px] font-bold transition-all disabled:opacity-45">‹ Prev</button>
            <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 bg-slate-50 border border-[#E8DCCB]/60 hover:bg-slate-100 rounded-lg text-[10px] font-bold transition-all disabled:opacity-45">Next ›</button>
          </div>
        </div>
      </div>
    </div>

    <!-- REJECTION MODAL -->
    <div v-if="showRejectModal" class="fixed inset-0 bg-[#2B1E16]/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-2xl border border-[#E8DCCB] shadow-2xl p-6 max-w-md w-full animate-in zoom-in-95 duration-200">
        <h3 class="text-sm font-bold text-[#2B1E16] mb-2 uppercase tracking-wider">Tolak Pengajuan Pendaftaran</h3>
        <p class="text-xs text-slate-400 font-medium mb-4">Mohon berikan alasan penolakan. Alasan ini akan dikirimkan ke pemohon.</p>
        
        <textarea v-model="rejectionReason" rows="4" placeholder="Contoh: Dokumen KTP tidak terbaca jelas atau deskripsi usaha kurang lengkap..."
          class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl p-3 text-[12px] font-medium text-[#2B1E16] outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all mb-4 resize-none"></textarea>
        
        <div class="flex justify-end gap-2 text-[10px] font-bold uppercase tracking-wider">
          <button @click="showRejectModal = false" class="px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-muted rounded-xl transition-all border border-[#E8DCCB]/60">Batal</button>
          <button @click="submitRejection" :disabled="!rejectionReason.trim()" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all disabled:opacity-45">Kirim Penolakan</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const currentTab = ref('matrix');
const selectedRole = ref('admin');

// Matrix data (existing layout)
const roles = [
  { name: 'admin', label: 'Administrator', desc: 'Akses penuh ke semua fitur platform.', emoji: '🛡️', count: 2, bgClass: 'bg-slate-100', countBg: 'bg-slate-100 text-muted' },
  { name: 'umkm', label: 'UMKM Kreator', desc: 'Kelola produk, pesanan, dan studio AI.', emoji: '🏪', count: 142, bgClass: 'bg-sand', countBg: 'bg-sand text-terracotta' },
  { name: 'desainer', label: 'Desainer', desc: 'Kolaborasi Co-Create dan portofolio.', emoji: '🎨', count: 67, bgClass: 'bg-blue-50', countBg: 'bg-blue-50 text-blue-600' },
  { name: 'pembeli', label: 'Pembeli', desc: 'Beli produk dan AR Try-On.', emoji: '🛒', count: 48, bgClass: 'bg-emerald-50', countBg: 'bg-emerald-50 text-emerald-600' },
];

const permissionsMap = {
  admin: [
    { module: 'Dashboard', desc: 'Analitik & overview', emoji: '📊', view: true, create: true, edit: true, delete: true },
    { module: 'Users', desc: 'Manajemen pengguna', emoji: '👥', view: true, create: true, edit: true, delete: true },
    { module: 'Products', desc: 'Moderasi produk', emoji: '📦', view: true, create: true, edit: true, delete: true },
    { module: 'Orders', desc: 'Transaksi & pembayaran', emoji: '🛍️', view: true, create: true, edit: true, delete: true },
    { module: 'Analytics', desc: 'Metrik global', emoji: '📈', view: true, create: true, edit: true, delete: true },
    { module: 'Roles', desc: 'Hak akses', emoji: '🔐', view: true, create: true, edit: true, delete: true },
  ],
  umkm: [
    { module: 'Dashboard', desc: 'Ringkasan UMKM', emoji: '📊', view: true, create: false, edit: false, delete: false },
    { module: 'Products', desc: 'Produk sendiri', emoji: '📦', view: true, create: true, edit: true, delete: true },
    { module: 'Orders', desc: 'Pesanan masuk', emoji: '🛍️', view: true, create: false, edit: true, delete: false },
    { module: 'AI Studio', desc: 'Generate desain AI', emoji: '🤖', view: true, create: true, edit: false, delete: false },
    { module: 'Co-Create', desc: 'Room kolaborasi', emoji: '🎨', view: true, create: true, edit: true, delete: false },
    { module: 'Profile', desc: 'Profil toko', emoji: '🏪', view: true, create: false, edit: true, delete: false },
  ],
  desainer: [
    { module: 'Dashboard', desc: 'Ringkasan desainer', emoji: '📊', view: true, create: false, edit: false, delete: false },
    { module: 'Co-Create', desc: 'Room kolaborasi', emoji: '🎨', view: true, create: false, edit: true, delete: false },
    { module: 'Portfolio', desc: 'Portofolio desain', emoji: '🖼️', view: true, create: true, edit: true, delete: true },
    { module: 'History', desc: 'Riwayat kolaborasi', emoji: '📋', view: true, create: false, edit: false, delete: false },
    { module: 'Profile', desc: 'Profil desainer', emoji: '👤', view: true, create: false, edit: true, delete: false },
    { module: 'Invitations', desc: 'Undangan masuk', emoji: '📩', view: true, create: false, edit: true, delete: false },
  ],
  pembeli: [
    { module: 'Marketplace', desc: 'Browse & beli produk', emoji: '🛒', view: true, create: false, edit: false, delete: false },
    { module: 'Orders', desc: 'Pesanan saya', emoji: '🛍️', view: true, create: true, edit: false, delete: false },
    { module: 'AR Try-On', desc: 'Coba produk via AR', emoji: '📱', view: true, create: true, edit: false, delete: false },
    { module: 'Reviews', desc: 'Ulasan produk', emoji: '⭐', view: true, create: true, edit: true, delete: true },
    { module: 'Profile', desc: 'Profil pembeli', emoji: '👤', view: true, create: false, edit: true, delete: false },
    { module: 'Wishlist', desc: 'Produk favorit', emoji: '❤️', view: true, create: true, edit: false, delete: true },
  ],
};

const currentPermissions = computed(() => permissionsMap[selectedRole.value] || []);

const savePermissions = () => {
  alert('Perubahan hak akses matrix berhasil disimpan di database!');
};

// --- Tab 2: Verification Logic ---
const filterStatuses = [
  { label: 'Semua', value: '' },
  { label: 'Perlu Review', value: 'need_review' },
  { label: 'Verifikasi AI', value: 'ai_reviewing' },
  { label: 'Disetujui', value: 'approved' },
  { label: 'Ditolak', value: 'rejected' },
];

const selectedStatus = ref('need_review');
const applications = ref([]);
const loadingApps = ref(true);
const expandedRows = ref([]);

const currentPage = ref(1);
const totalPages = ref(1);

const showRejectModal = ref(false);
const rejectionReason = ref('');
const activeAppToReject = ref(null);

const toggleRow = (id) => {
  if (expandedRows.value.includes(id)) {
    expandedRows.value = expandedRows.value.filter(x => x !== id);
  } else {
    expandedRows.value.push(id);
  }
};

const fetchApplications = async () => {
  loadingApps.value = true;
  expandedRows.value = [];
  try {
    const token = localStorage.getItem('token');
    const url = `/api/v1/admin/role-applications?status=${selectedStatus.value}&page=${currentPage.value}`;
    const res = await fetch(url, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (res.ok) {
      const data = await res.json();
      applications.value = data.data || [];
      totalPages.value = data.pagination?.last_page || 1;
    }
  } catch (e) {
    console.error('Gagal mengambil data pengajuan role:', e);
  } finally {
    loadingApps.value = false;
  }
};

const approveApp = async (id) => {
  if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan pendaftaran role ini?')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/role-applications/${id}/approve`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (res.ok) {
      alert('Pendaftaran berhasil disetujui!');
      fetchApplications();
    }
  } catch (e) {
    console.error('Gagal menyetujui pengajuan:', e);
  }
};

const openRejectModal = (app) => {
  activeAppToReject.value = app;
  rejectionReason.value = '';
  showRejectModal.value = true;
};

const submitRejection = async () => {
  if (!activeAppToReject.value) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/role-applications/${activeAppToReject.value.id}/reject`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ rejection_reason: rejectionReason.value })
    });
    if (res.ok) {
      alert('Pengajuan pendaftaran berhasil ditolak.');
      showRejectModal.value = false;
      fetchApplications();
    }
  } catch (e) {
    console.error('Gagal menolak pengajuan:', e);
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
    fetchApplications();
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
    fetchApplications();
  }
};

// Utilities
const formatDate = (dateStr) => {
  if (!dateStr) return '-';
  const d = new Date(dateStr);
  return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
};

const getStatusClass = (status) => {
  switch (status) {
    case 'approved': return 'bg-emerald-50 text-emerald-600';
    case 'rejected': return 'bg-red-50 text-red-600';
    case 'need_review': return 'bg-amber-50 text-amber-600';
    case 'ai_reviewing': return 'bg-blue-50 text-blue-600 animate-pulse';
    default: return 'bg-slate-100 text-slate-500';
  }
};

const getStatusLabel = (status) => {
  switch (status) {
    case 'approved': return 'Disetujui';
    case 'rejected': return 'Ditolak';
    case 'need_review': return 'Perlu Review';
    case 'ai_reviewing': return 'Proses AI';
    default: return status;
  }
};

const getScoreClass = (score) => {
  if (!score) return 'bg-slate-100 text-slate-400';
  if (score >= 80) return 'bg-emerald-50 text-emerald-600 border border-emerald-200';
  if (score >= 50) return 'bg-amber-50 text-amber-500 border border-amber-200';
  return 'bg-red-50 text-red-500 border border-red-200';
};

onMounted(() => {
  fetchApplications();
});
</script>

<style scoped>
/* Transisi transparan */
.animate-in {
  animation: fadeIn 0.25s ease-out forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(4px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
