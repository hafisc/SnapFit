<template>
  <section class="min-h-screen bg-slate-50 text-espresso p-6 lg:p-10">
    <div class="max-w-5xl mx-auto">
      <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <div>
            <div class="flex items-center gap-3 mb-4">
              <router-link to="/marketplace" class="text-muted hover:text-espresso transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </router-link>
              <div>
                <h1 class="text-3xl font-black text-espresso">Pesanan Saya</h1>
                <p class="text-muted">Lihat semua pesanan dan status pengiriman Anda.</p>
              </div>
            </div>
          </div>

          <div class="w-full sm:w-auto">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search by Order ID or Product Name"
              class="w-full sm:w-80 px-4 py-3 rounded-2xl border border-borderSoft focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent"
            />
          </div>
        </div>

        <div class="flex flex-wrap gap-2">
          <button
            v-for="status in statusOptions"
            :key="status.value"
            @click="selectedStatus = status.value"
            :class="[
              'px-4 py-2 rounded-full text-sm font-semibold transition-all',
              selectedStatus === status.value
                ? 'bg-terracotta text-white shadow-lg'
                : 'bg-slate-100 text-espresso hover:bg-slate-200'
            ]"
          >
            {{ status.label }}
          </button>
        </div>
      </div>

      <div v-if="loading" class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft text-center">
        <p class="text-muted">Memuat pesanan...</p>
      </div>

      <div v-else-if="!filteredOrders.length" class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft text-center">
        <div class="py-10">
          <svg class="mx-auto mb-4 h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <h2 class="text-xl font-black text-espresso mb-2">Belum ada pesanan</h2>
          <p class="text-muted mb-6">Anda belum membuat pesanan apapun. Mulai berbelanja sekarang!</p>
          <router-link to="/marketplace" class="inline-flex items-center justify-center rounded-3xl bg-terracotta px-6 py-3 text-sm font-black text-white hover:bg-terracottaDark transition-all">
            Lihat Produk
          </router-link>
        </div>
      </div>

      <div v-else class="space-y-4">
        <div v-for="order in filteredOrders" :key="order.id" class="rounded-[2rem] bg-surface p-6 shadow-sm border border-borderSoft">
          <div class="flex items-start justify-between gap-4 mb-4">
            <div>
              <div class="flex items-baseline gap-2 mb-2">
                <p class="text-sm text-muted">Order ID:</p>
                <p class="font-black text-espresso">{{ order.midtrans_order_id }}</p>
              </div>
              <div class="flex items-baseline gap-2 mb-2">
                <p class="text-sm text-muted">Tanggal:</p>
                <p class="text-sm text-muted">{{ formatDate(order.created_at) }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-2xl font-black text-terracotta">{{ formatCurrency(order.total_amount) }}</p>
              <span :class="statusBadge(order.status)" class="inline-block mt-2 rounded-full px-4 py-1 text-xs font-black uppercase tracking-wider">
                {{ statusLabel(order.status) }}
              </span>
            </div>
          </div>

          <div class="border-t border-borderSoft pt-4">
            <p class="text-sm text-muted mb-3">Produk yang dipesan:</p>
            <div class="space-y-3">
              <div v-for="item in order.items" :key="item.id" class="flex items-center gap-4 rounded-[1.5rem] bg-slate-50 p-4">
                <img v-if="item.product?.image_url" :src="item.product.image_url" class="h-16 w-16 rounded-2xl object-cover" :alt="item.product?.name" />
                <div v-else class="h-16 w-16 rounded-2xl bg-slate-200"></div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-espresso truncate">{{ item.product?.name || 'Produk' }}</p>
                  <p class="text-sm text-muted">Jumlah: {{ item.quantity }}</p>
                </div>
                <p class="font-black text-espresso">{{ formatCurrency(item.price * item.quantity) }}</p>
              </div>
            </div>
          </div>

          <div class="border-t border-borderSoft mt-4 pt-4">
            <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <p class="text-xs text-muted uppercase tracking-[0.1em] font-black mb-2">Status Pembayaran</p>
                <p class="text-sm font-semibold text-espresso">
                  {{ paymentStatus(order.status) }}
                </p>
              </div>
              <div>
                <p class="text-xs text-muted uppercase tracking-[0.1em] font-black mb-2">Status Pengiriman</p>
                <p class="text-sm font-semibold text-espresso">
                  {{ shippingStatus(order.status) }}
                </p>
              </div>
            </div>
          </div>

          <div class="border-t border-borderSoft mt-4 pt-4 flex gap-3">
            <button @click="viewOrderDetail(order.id)" class="flex-1 rounded-3xl border border-borderSoft bg-surface px-4 py-3 text-sm font-black uppercase tracking-widest text-espresso hover:bg-slate-100 transition-all">
              Lihat Detail
            </button>
            <button v-if="order.status === 'pending'" @click="goToPayment(order.id)" class="flex-1 rounded-3xl bg-terracotta px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-terracottaDark transition-all">
              Bayar Sekarang
            </button>
            <button v-else class="flex-1 rounded-3xl bg-slate-200 px-4 py-3 text-sm font-black uppercase tracking-widest text-muted cursor-not-allowed">
              {{ order.status === 'paid' ? 'Sedang Dikirim' : 'Pesanan Selesai' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const orders = ref([]);
const loading = ref(true);
const searchQuery = ref('');
const selectedStatus = ref('all');

const statusOptions = [
  { value: 'all', label: 'All' },
  { value: 'pending', label: 'Pending' },
  { value: 'paid', label: 'Processing' },
  { value: 'shipped', label: 'Shipped' },
  { value: 'completed', label: 'Completed' },
  { value: 'cancelled', label: 'Cancelled' },
];

const filteredOrders = computed(() => {
  return orders.value.filter(order => {
    const matchesStatus = selectedStatus.value === 'all' || order.status === selectedStatus.value;
    const matchesSearch = !searchQuery.value ||
      order.midtrans_order_id.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      order.items.some(item => item.product?.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
    return matchesStatus && matchesSearch;
  });
});

const apiHeaders = () => {
  const token = localStorage.getItem('token');
  const headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  };
  if (token) headers.Authorization = `Bearer ${token}`;
  return headers;
};

const fetchOrders = async () => {
  loading.value = true;
  try {
    const res = await fetch('/api/v1/orders', {
      headers: apiHeaders(),
    });

    if (!res.ok) {
      console.error('Failed to fetch orders:', res.status);
      orders.value = [];
      return;
    }

    const data = await res.json();
    orders.value = data.data || [];
  } catch (err) {
    console.error('Fetch orders error:', err);
    orders.value = [];
  } finally {
    loading.value = false;
  }
};

const formatDate = (dateString) => {
  try {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    }).format(date);
  } catch {
    return dateString;
  }
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(amount);
};

const statusLabel = (status) => {
  const labels = {
    pending: '⏳ Menunggu Pembayaran',
    paid: '✓ Sedang Diproses',
    shipped: '📦 Sedang Dikirim',
    completed: '✓ Selesai',
    cancelled: '✕ Dibatalkan',
  };
  return labels[status] || status;
};

const statusBadge = (status) => {
  const badges = {
    pending: 'bg-yellow-100 text-yellow-700',
    paid: 'bg-blue-100 text-blue-700',
    shipped: 'bg-purple-100 text-purple-700',
    completed: 'bg-emerald-100 text-emerald-700',
    cancelled: 'bg-red-100 text-red-700',
  };
  return badges[status] || 'bg-slate-100 text-espresso';
};

const paymentStatus = (status) => {
  const statuses = {
    pending: 'Belum dibayar',
    paid: 'Sudah dibayar',
    shipped: 'Sudah dibayar',
    completed: 'Sudah dibayar',
  };
  return statuses[status] || 'Belum diketahui';
};

const shippingStatus = (status) => {
  const statuses = {
    pending: 'Belum dikirim',
    paid: 'Sedang diproses',
    shipped: 'Dalam perjalanan',
    completed: 'Sudah diterima',
  };
  return statuses[status] || 'Belum diketahui';
};

const viewOrderDetail = (orderId) => {
  router.push({ name: 'marketplace.order.detail', params: { id: orderId } });
};

const goToPayment = (orderId) => {
  router.push({ name: 'marketplace.qris', query: { order_id: orderId } });
};

onMounted(() => {
  fetchOrders();
});
</script>

<style scoped>
/* Additional styles if needed */
</style>
