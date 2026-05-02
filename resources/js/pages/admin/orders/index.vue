<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
      <div>
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Data Transaksi</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Pantau seluruh riwayat transaksi di platform.</p>
      </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Order ID</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Pembeli</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Total Harga</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Tanggal</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="loading" class="animate-pulse">
              <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Memuat data...</td>
            </tr>
            <tr v-else-if="orders.length === 0">
              <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Tidak ada transaksi.</td>
            </tr>
            <tr v-else v-for="order in orders" :key="order.id" class="hover:bg-slate-50/50 transition-colors">
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-slate-800">#{{ order.id.substring(0,8).toUpperCase() }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-slate-600">{{ order.buyer.name }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm font-bold text-indigo-600">Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</span>
              </td>
              <td class="px-6 py-4">
                <select v-model="order.status" @change="updateStatus(order.id, order.status)" class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase cursor-pointer border-none outline-none focus:ring-2 focus:ring-indigo-100" :class="{
                  'bg-orange-50 text-orange-600': order.status === 'pending',
                  'bg-blue-50 text-blue-600': order.status === 'paid',
                  'bg-purple-50 text-purple-600': order.status === 'shipped',
                  'bg-emerald-50 text-emerald-600': order.status === 'completed',
                  'bg-red-50 text-red-600': order.status === 'cancelled'
                }">
                  <option value="pending">PENDING</option>
                  <option value="paid">PAID</option>
                  <option value="shipped">SHIPPED</option>
                  <option value="completed">COMPLETED</option>
                  <option value="cancelled">CANCELLED</option>
                </select>
              </td>
              <td class="px-6 py-4 text-right">
                <span class="text-[10px] font-bold text-slate-400 uppercase">{{ formatDate(order.created_at) }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const orders = ref([]);
const loading = ref(true);

const fetchOrders = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/admin/orders', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      orders.value = data.data;
    }
  } finally {
    loading.value = false;
  }
};

const updateStatus = async (id, newStatus) => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/orders/${id}/status`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({ status: newStatus })
    });
    
    if (!res.ok) {
      alert('Gagal mengupdate status transaksi.');
      fetchOrders(); // Revert back
    }
  } catch (e) {
    alert('Terjadi kesalahan jaringan.');
    fetchOrders(); // Revert back
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }).format(new Date(dateString));
};

onMounted(() => {
  fetchOrders();
});
</script>
