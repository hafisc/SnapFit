<template>
  <div class="w-full mx-auto space-y-5">
    <!-- Header -->
    <div class="bg-white rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between border border-[#E8DCCB]/60 gap-4">
      <div>
        <h2 class="text-lg font-bold text-[#2B1E16]">Daftar Pesanan</h2>
        <p class="text-[11px] text-[#8A7A6C] mt-0.5">Pantau pesanan masuk, pengiriman, dan status pelanggan.</p>
      </div>
      <button @click="exportCSV" class="px-4 py-2.5 bg-[#F8F1E7] text-[#2B1E16] border border-[#E8DCCB] rounded-xl text-[12px] font-bold hover:bg-[#E8DCCB]/50 transition-colors flex items-center gap-1.5 cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
        Ekspor CSV
      </button>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 flex flex-col">
      <!-- Filters -->
      <div class="p-5 border-b border-[#E8DCCB]/60 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex overflow-x-auto no-scrollbar gap-1.5">
          <button v-for="tab in filterTabs" :key="tab" @click="activeTab = tab"
            class="px-4 py-2 rounded-xl text-[11px] font-bold whitespace-nowrap transition-all"
            :class="activeTab === tab ? 'bg-[#B85C38]/10 text-[#B85C38] border border-[#B85C38]/20' : 'text-[#8A7A6C] hover:bg-[#F8F1E7] border border-transparent'">
            {{ tab }}
          </button>
        </div>
        <div class="relative w-full lg:w-56">
          <input type="text" v-model="searchQuery" placeholder="Cari ID atau nama pelanggan..." class="w-full bg-[#FFFCF7] border border-[#E8DCCB] text-[12px] font-medium text-[#2B1E16] rounded-xl pl-9 pr-4 py-2.5 outline-none focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 transition-all placeholder-[#8A7A6C]/60">
          <svg class="w-3.5 h-3.5 text-[#8A7A6C] absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[800px]">
          <thead>
            <tr class="bg-[#FAF6F0]">
              <th class="py-3 px-5 text-[10px] font-bold text-[#8A7A6C] uppercase tracking-wider">Order ID</th>
              <th class="py-3 px-5 text-[10px] font-bold text-[#8A7A6C] uppercase tracking-wider">Pelanggan</th>
              <th class="py-3 px-5 text-[10px] font-bold text-[#8A7A6C] uppercase tracking-wider">Produk</th>
              <th class="py-3 px-5 text-[10px] font-bold text-[#8A7A6C] uppercase tracking-wider">Tanggal</th>
              <th class="py-3 px-5 text-[10px] font-bold text-[#8A7A6C] uppercase tracking-wider">Status</th>
              <th class="py-3 px-5 text-[10px] font-bold text-[#8A7A6C] uppercase tracking-wider text-right">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in filteredOrders" :key="order.id" class="border-b border-[#E8DCCB]/40 last:border-0 hover:bg-[#FAF6F0] transition-colors">
              <td class="py-4 px-5 text-[12px] font-bold text-[#2B1E16]">{{ order.id }}</td>
              <td class="py-4 px-5">
                <p class="text-[12px] font-semibold text-[#2B1E16] truncate max-w-[140px]">{{ order.customer_name }}</p>
              </td>
              <td class="py-4 px-5">
                <div class="flex items-center gap-2.5">
                  <div class="w-9 h-9 bg-[#F8F1E7] rounded-lg overflow-hidden border border-[#E8DCCB]/50 flex-shrink-0">
                    <img v-if="order.product_image" :src="order.product_image" class="w-full h-full object-cover" />
                    <div v-else class="w-full h-full flex items-center justify-center text-[#8A7A6C]">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                  </div>
                  <div>
                    <p class="text-[12px] font-medium text-[#2B1E16] truncate max-w-[160px]">{{ order.product_name }}</p>
                    <p class="text-[10px] text-[#8A7A6C]">Qty: {{ order.qty }}</p>
                  </div>
                </div>
              </td>
              <td class="py-4 px-5 text-[11px] text-[#8A7A6C] font-medium">{{ formatDate(order.created_at) }}</td>
              <td class="py-4 px-5">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold" :class="getStatusClass(order.status)">
                  <span class="w-1.5 h-1.5 rounded-full" :class="getDotClass(order.status)"></span>
                  {{ order.status }}
                </span>
              </td>
              <td class="py-4 px-5 text-right text-[13px] font-bold text-[#2B1E16]">Rp {{ order.total_price.toLocaleString('id-ID') }}</td>
            </tr>

            <!-- Empty -->
            <tr v-if="filteredOrders.length === 0">
              <td colspan="6" class="py-16 text-center">
                <div class="w-14 h-14 bg-[#F8F1E7] rounded-2xl flex items-center justify-center mx-auto mb-3">
                  <svg class="w-6 h-6 text-[#B85C38]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <p class="text-sm font-semibold text-[#2B1E16] mb-1">Tidak ada pesanan ditemukan</p>
                <p class="text-[11px] text-[#8A7A6C]">Pesanan dari marketplace akan muncul di sini setelah pelanggan checkout.</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-5 border-t border-[#E8DCCB]/60 flex items-center justify-between">
        <p class="text-[11px] text-[#8A7A6C] font-medium">{{ filteredOrders.length }} pesanan</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const filterTabs = ['Semua Pesanan', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
const activeTab = ref('Semua Pesanan');
const searchQuery = ref('');
const orders = ref([]);

const fetchOrders = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/orders', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) {
      const data = await res.json();
      orders.value = (data.data || []).map(o => {
        const firstItem = o.items?.[0];
        const statusMap = { pending: 'Menunggu', paid: 'Diproses', shipped: 'Dikirim', completed: 'Selesai', cancelled: 'Dibatalkan' };
        return {
          id: o.midtrans_order_id || `#ORD-${1000 + o.id}`,
          customer_name: o.buyer?.profile?.full_name || o.buyer?.name || 'Pelanggan',
          product_name: o.items?.length > 1 ? `${firstItem?.product?.name || 'Produk'} (+${o.items.length - 1})` : (firstItem?.product?.name || 'Produk'),
          product_image: firstItem?.product?.image_url || null,
          qty: firstItem?.quantity || 1,
          total_price: o.total_amount || 0,
          status: statusMap[o.status] || 'Menunggu',
          created_at: o.created_at,
        };
      });
    }
  } catch (e) { console.error('Failed to fetch orders:', e); }
};

onMounted(() => { fetchOrders(); });

const exportCSV = () => {
  if (filteredOrders.value.length === 0) {
    alert('Tidak ada data pesanan untuk diekspor.');
    return;
  }

  const headers = ['Order ID', 'Pelanggan', 'Produk', 'Tanggal', 'Status', 'Total (Rp)'];
  const rows = filteredOrders.value.map(o => [
    o.id,
    o.customer_name,
    o.product_name,
    formatDate(o.created_at),
    o.status,
    o.total_price
  ]);

  const csvContent = [
    headers.join(','),
    ...rows.map(r => r.map(val => {
      const stringVal = String(val).replace(/"/g, '""');
      return stringVal.includes(',') || stringVal.includes('\n') || stringVal.includes('"') 
        ? `"${stringVal}"` 
        : stringVal;
    }).join(','))
  ].join('\n');

  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.setAttribute('href', url);
  link.setAttribute('download', `Daftar_Pesanan_SnapFit_${new Date().toISOString().slice(0, 10)}.csv`);
  link.style.visibility = 'hidden';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const filteredOrders = computed(() => {
  let result = orders.value;
  if (activeTab.value !== 'Semua Pesanan') result = result.filter(o => o.status === activeTab.value);
  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase();
    result = result.filter(o => o.id.toLowerCase().includes(q) || o.customer_name.toLowerCase().includes(q));
  }
  return result;
});

const formatDate = (d) => new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(d));

const getStatusClass = (s) => ({
  'Menunggu': 'bg-[#F8F1E7] text-[#8A7A6C]',
  'Diproses': 'bg-[#C98A1A]/10 text-[#C98A1A]',
  'Dikirim': 'bg-blue-50 text-blue-600',
  'Selesai': 'bg-[#0F8A4B]/10 text-[#0F8A4B]',
  'Dibatalkan': 'bg-[#D94A38]/10 text-[#D94A38]',
}[s] || 'bg-[#F8F1E7] text-[#8A7A6C]');

const getDotClass = (s) => ({
  'Menunggu': 'bg-[#8A7A6C]',
  'Diproses': 'bg-[#C98A1A]',
  'Dikirim': 'bg-blue-500',
  'Selesai': 'bg-[#0F8A4B]',
  'Dibatalkan': 'bg-[#D94A38]',
}[s] || 'bg-[#8A7A6C]');
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
