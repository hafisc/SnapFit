<template>
  <div class="space-y-5 max-w-[1400px]">
    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="s in orderStats" :key="s.label" class="bg-surface rounded-2xl border border-borderSoft/60 p-5">
        <p class="text-[11px] text-slate-400 font-medium mb-2">{{ s.label }}</p>
        <p class="text-[20px] font-bold text-espresso leading-none">{{ s.value }}</p>
        <p class="text-[10px] font-semibold mt-1" :class="s.changeClass">{{ s.change }}</p>
      </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
      <div class="flex bg-slate-100 rounded-lg p-0.5">
        <button v-for="t in statusTabs" :key="t.key" @click="statusFilter = t.key"
          class="px-3 py-2 text-[11px] font-semibold rounded-md transition-all"
          :class="statusFilter === t.key ? 'bg-surface text-espresso shadow-sm' : 'text-slate-400 hover:text-muted'">
          {{ t.label }}
        </button>
      </div>
      <div class="flex-1"></div>
      <div class="flex items-center bg-surface rounded-lg px-3.5 py-2.5 gap-2 border border-borderSoft/60">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        <input v-model="search" type="text" placeholder="Cari order..." class="bg-transparent outline-none text-[12px] font-medium text-muted w-44 placeholder:text-slate-400" />
      </div>
    </div>

    <!-- Table -->
    <div class="bg-surface rounded-2xl border border-borderSoft/60 overflow-hidden">
      <table class="w-full text-left">
        <thead>
          <tr class="border-b border-borderSoft">
            <th class="px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Order</th>
            <th class="px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Pembeli</th>
            <th class="px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">Produk</th>
            <th class="px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Total</th>
            <th class="px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
            <th class="px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-right hidden lg:table-cell">Tanggal</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <tr v-for="o in filteredOrders" :key="o.id" class="hover:bg-slate-50/60 transition-colors group">
            <td class="px-5 py-3.5">
              <span class="text-[12px] font-bold text-espresso font-mono">{{ o.orderId }}</span>
            </td>
            <td class="px-5 py-3.5">
              <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md bg-slate-100 flex items-center justify-center text-[10px] font-bold text-muted flex-shrink-0">{{ o.buyer.charAt(0) }}</div>
                <span class="text-[12px] font-medium text-espresso truncate">{{ o.buyer }}</span>
              </div>
            </td>
            <td class="px-5 py-3.5 hidden md:table-cell">
              <span class="text-[11px] text-muted truncate block max-w-[200px]">{{ o.product }}</span>
            </td>
            <td class="px-5 py-3.5">
              <span class="text-[12px] font-bold text-espresso">Rp {{ o.total.toLocaleString('id-ID') }}</span>
            </td>
            <td class="px-5 py-3.5">
              <select v-model="o.status" @change="updateStatus(o.id, o.status)" class="text-[10px] font-bold uppercase tracking-wide rounded-md px-2.5 py-1 border-none outline-none cursor-pointer" :class="statusClass(o.status)">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="shipped">Shipped</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </td>
            <td class="px-5 py-3.5 text-right hidden lg:table-cell">
              <span class="text-[11px] text-slate-400 font-medium">{{ o.date }}</span>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="px-5 py-3.5 border-t border-borderSoft flex items-center justify-between">
        <p class="text-[11px] text-slate-400 font-medium">{{ filteredOrders.length }} pesanan</p>
        <div class="flex items-center gap-1">
          <button class="w-8 h-8 rounded-md bg-slate-800 text-white text-[11px] font-bold">1</button>
          <button class="w-8 h-8 rounded-md text-slate-400 hover:bg-slate-100 text-[11px] font-bold">2</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const search = ref('');
const statusFilter = ref('all');
const statusTabs = [
  { key: 'all', label: 'Semua' },
  { key: 'pending', label: 'Pending' },
  { key: 'paid', label: 'Paid' },
  { key: 'shipped', label: 'Shipped' },
  { key: 'completed', label: 'Completed' },
];

const orderStats = ref([
  { label: 'Total Pesanan', value: '0', change: '', changeClass: 'text-emerald-500' },
  { label: 'Pending', value: '0', change: '', changeClass: 'text-amber-500' },
  { label: 'Revenue', value: 'Rp 0', change: '', changeClass: 'text-emerald-500' },
]);

const orders = ref([]);

const fetchOrders = async () => {
  try {
    const token = localStorage.getItem('token') || '';
    const url = new URL(window.location.origin + '/api/v1/admin/orders');
    if (statusFilter.value !== 'all') url.searchParams.append('status', statusFilter.value);
    
    const res = await fetch(url, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    
    if (res.ok) {
      const data = await res.json();
      orders.value = data.data.map(o => ({
        id: o.id,
        orderId: `#SF-${1000 + o.id}`,
        buyer: o.buyer?.name || 'Unknown',
        product: o.items?.[0]?.product?.name ? `${o.items[0].product.name} ${o.items.length > 1 ? `(+${o.items.length - 1} lainnya)` : ''}` : 'Produk Custom',
        total: o.total_amount,
        status: o.status,
        date: new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }).format(new Date(o.created_at))
      }));
    }
    
    // Also fetch stats just for orders if possible, or use stats API
    const statRes = await fetch('/api/v1/admin/stats', { headers: { 'Authorization': `Bearer ${token}` }});
    if (statRes.ok) {
        const sdata = await statRes.json();
        orderStats.value[0].value = sdata.orders.total.toString();
        orderStats.value[1].value = sdata.orders.pending.toString();
        const rev = Number(sdata.orders.revenue || 0);
        orderStats.value[2].value = 'Rp ' + (rev > 1000000 ? (rev/1000000).toFixed(1) + 'M' : rev.toLocaleString('id-ID'));
    }
  } catch (e) {
    console.error('Failed to fetch orders:', e);
  }
};

onMounted(() => {
  fetchOrders();
});

const filteredOrders = computed(() => {
  let r = orders.value;
  if (search.value) r = r.filter(o => o.buyer.toLowerCase().includes(search.value.toLowerCase()) || o.orderId.toLowerCase().includes(search.value.toLowerCase()));
  return r;
});

watch(statusFilter, () => {
  fetchOrders();
});

const statusClass = (s) => ({
  pending: 'bg-amber-50 text-amber-600',
  paid: 'bg-blue-50 text-blue-600',
  shipped: 'bg-violet-50 text-violet-600',
  completed: 'bg-emerald-50 text-emerald-600',
  cancelled: 'bg-red-50 text-red-500',
}[s] || 'bg-slate-100 text-muted');

const updateStatus = async (id, status) => {
    try {
        const token = localStorage.getItem('token') || '';
        await fetch(`/api/v1/admin/orders/${id}/status`, {
            method: 'PATCH',
            headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' },
            body: JSON.stringify({ status })
        });
        fetchOrders();
    } catch(e) {}
};
</script>
