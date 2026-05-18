<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full">
    
    <!-- Page Header -->
    <div class="bg-surface rounded-2xl p-8 flex flex-col sm:flex-row sm:items-center justify-between border border-borderSoft shadow-sm relative overflow-hidden gap-4">
      <div class="relative z-10">
        <h2 class="text-3xl font-bold text-espresso tracking-tight mb-1">Daftar Pesanan</h2>
        <p class="text-muted font-medium text-sm">Kelola dan pantau semua pesanan dari pelangganmu di satu tempat.</p>
      </div>
      <div class="relative z-10">
        <button class="bg-slate-50 hover:bg-slate-100 text-muted border border-borderSoft px-6 py-3 rounded-xl text-xs font-bold tracking-wider uppercase transition-colors flex items-center justify-center gap-2 shadow-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
          Export CSV
        </button>
      </div>
      <!-- Decorative Blur -->
      <div class="absolute -right-10 -top-10 w-40 h-40 bg-sand rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    </div>

    <!-- Main Card -->
    <div class="bg-surface rounded-2xl border border-borderSoft shadow-sm flex flex-col relative z-20">
      
      <!-- Toolbar & Filters -->
      <div class="p-6 border-b border-borderSoft flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        
        <!-- Filter Tabs -->
        <div class="flex overflow-x-auto no-scrollbar gap-2 pb-2 lg:pb-0">
          <button 
            v-for="tab in filterTabs" 
            :key="tab"
            @click="activeTab = tab"
            class="px-5 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-wider whitespace-nowrap transition-all"
            :class="activeTab === tab ? 'bg-sand text-terracotta border border-terracotta/30 shadow-sm' : 'bg-transparent text-slate-400 hover:bg-slate-50 hover:text-muted border border-transparent'"
          >
            {{ tab }}
          </button>
        </div>

        <!-- Search & Sort -->
        <div class="flex items-center gap-3">
          <div class="relative w-full lg:w-64">
            <input type="text" placeholder="Cari ID atau nama pelanggan..." class="w-full bg-slate-50 border border-borderSoft text-sm font-medium text-espresso rounded-xl pl-10 pr-4 py-2.5 outline-none focus:border-orange-500 transition-colors placeholder-slate-400">
            <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </div>
          <button class="w-11 h-11 flex items-center justify-center bg-slate-50 border border-borderSoft rounded-xl text-muted hover:bg-slate-100 transition-colors flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" /></svg>
          </button>
        </div>
      </div>

      <!-- Table Container -->
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
          <thead>
            <tr class="bg-slate-50/50">
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-24">Order ID</th>
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Produk</th>
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-32">Tanggal</th>
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-40">Status</th>
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right w-40">Total Tagihan</th>
              <th class="py-4 px-6 md:px-8 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center w-20">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-for="order in filteredOrders" :key="order.id" class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors group">
              <td class="py-5 px-6 md:px-8 font-bold text-espresso">{{ order.id }}</td>
              <td class="py-5 px-6 md:px-8">
                <p class="font-bold text-espresso truncate max-w-[150px]">{{ order.customer_name }}</p>
                <p class="text-xs font-medium text-slate-400">{{ order.customer_city }}</p>
              </td>
              <td class="py-5 px-6 md:px-8">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden border border-borderSoft flex-shrink-0">
                    <img v-if="order.product_image" :src="order.product_image" class="w-full h-full object-cover" />
                  </div>
                  <div>
                    <p class="font-bold text-espresso truncate max-w-[200px]">{{ order.product_name }}</p>
                    <p class="text-xs font-medium text-slate-400">Qty: {{ order.qty }}</p>
                  </div>
                </div>
              </td>
              <td class="py-5 px-6 md:px-8">
                <p class="font-bold text-muted">{{ formatDate(order.created_at) }}</p>
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ formatTime(order.created_at) }}</p>
              </td>
              <td class="py-5 px-6 md:px-8">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border shadow-sm" :class="getStatusClass(order.status)">
                  <span class="w-1.5 h-1.5 rounded-full" :class="getDotClass(order.status)"></span>
                  <span class="text-[10px] font-bold tracking-wider uppercase">{{ order.status }}</span>
                </div>
              </td>
              <td class="py-5 px-6 md:px-8 text-right font-bold text-espresso text-base">
                Rp {{ order.total_price.toLocaleString('id-ID') }}
              </td>
              <td class="py-5 px-6 md:px-8 text-center">
                <button class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-surface border border-borderSoft text-slate-400 hover:text-terracotta hover:border-terracotta/30 hover:bg-sand transition-all shadow-sm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </button>
              </td>
            </tr>
            
            <tr v-if="filteredOrders.length === 0">
              <td colspan="7" class="py-16 text-center">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center text-2xl mx-auto mb-4 border border-borderSoft">🛒</div>
                <p class="text-muted font-bold mb-1">Tidak ada pesanan ditemukan</p>
                <p class="text-xs text-slate-400">Coba ubah filter status atau kata kunci pencarian.</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-6 border-t border-borderSoft flex items-center justify-between">
        <p class="text-xs font-bold text-slate-400">Menampilkan <span class="text-espresso">1 - 10</span> dari <span class="text-espresso">24</span> pesanan</p>
        <div class="flex items-center gap-2">
          <button disabled class="w-8 h-8 rounded-lg border border-borderSoft flex items-center justify-center text-slate-300 bg-slate-50 cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button class="w-8 h-8 rounded-lg border border-terracotta/30 flex items-center justify-center text-terracotta bg-sand font-bold text-xs shadow-sm">1</button>
          <button class="w-8 h-8 rounded-lg border border-borderSoft flex items-center justify-center text-muted hover:bg-slate-50 font-bold text-xs transition-colors">2</button>
          <button class="w-8 h-8 rounded-lg border border-borderSoft flex items-center justify-center text-muted hover:bg-slate-50 font-bold text-xs transition-colors">3</button>
          <button class="w-8 h-8 rounded-lg border border-borderSoft flex items-center justify-center text-muted hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const filterTabs = ['Semua Pesanan', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
const activeTab = ref('Semua Pesanan');

// Fetch real orders from API
const orders = ref([]);

const fetchOrders = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/orders', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      orders.value = data.data.map(o => {
        const firstItem = o.items && o.items.length > 0 ? o.items[0] : null;
        const pName = firstItem && firstItem.product ? firstItem.product.name : 'Produk Custom';
        const pImg = firstItem && firstItem.product ? firstItem.product.image_url : null;
        
        // Map English status to Indonesian to match tabs
        const statusMap = {
          'pending': 'Menunggu Pembayaran',
          'paid': 'Diproses',
          'shipped': 'Dikirim',
          'completed': 'Selesai',
          'cancelled': 'Dibatalkan'
        };
        
        return {
          id: `#ORD-${1000 + o.id}`,
          customer_name: o.buyer?.name || 'Unknown',
          customer_city: '-', // Backend doesn't have city yet
          product_name: o.items?.length > 1 ? `${pName} (+${o.items.length - 1} item)` : pName,
          product_image: pImg,
          qty: firstItem ? firstItem.quantity : 1,
          total_price: o.total_amount,
          status: statusMap[o.status] || 'Menunggu Pembayaran',
          created_at: o.created_at
        };
      });
    }
  } catch (error) {
    console.error('Failed to fetch orders:', error);
  }
};

import { onMounted } from 'vue';
onMounted(() => {
  fetchOrders();
});

const filteredOrders = computed(() => {
  if (activeTab.value === 'Semua Pesanan') return orders.value;
  return orders.value.filter(o => o.status === activeTab.value);
});

// Helper Formatting
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(date);
};

const formatTime = (dateString) => {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit' }).format(date);
};

// Styling Logics
const getStatusClass = (status) => {
  const maps = {
    'Menunggu Pembayaran': 'bg-slate-50 border-borderSoft text-muted',
    'Diproses': 'bg-sand border-terracotta/30 text-terracotta',
    'Dikirim': 'bg-blue-50 border-blue-200 text-blue-600',
    'Selesai': 'bg-emerald-50 border-emerald-200 text-emerald-600',
    'Dibatalkan': 'bg-red-50 border-red-200 text-red-600',
  };
  return maps[status] || 'bg-slate-50 border-borderSoft text-muted';
};

const getDotClass = (status) => {
  const maps = {
    'Menunggu Pembayaran': 'bg-slate-400',
    'Diproses': 'bg-terracotta animate-pulse',
    'Dikirim': 'bg-blue-500',
    'Selesai': 'bg-emerald-500',
    'Dibatalkan': 'bg-red-500',
  };
  return maps[status] || 'bg-slate-400';
};
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
