<template>
  <section class="min-h-screen bg-slate-50 text-espresso p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
      <div class="mb-8">
        <button @click="goBack" class="inline-flex items-center gap-2 text-muted hover:text-espresso transition mb-6">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Back to Orders
        </button>

        <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
          <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6">
            <div>
              <h1 class="text-3xl font-black text-espresso mb-2">Order Detail</h1>
              <p class="text-muted">Review the status, shipping, and payment information for your order.</p>
            </div>
            <div class="text-right">
              <p class="text-sm text-muted">Order ID</p>
              <p class="text-xl font-black text-espresso">{{ order?.midtrans_order_id || 'N/A' }}</p>
              <p class="text-sm text-muted mt-2">{{ formatDate(order?.created_at) }}</p>
            </div>
          </div>
        </div>
      </div>

      <div v-if="loading" class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft text-center">
        <div class="flex justify-center mb-4">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-600"></div>
        </div>
        <p class="text-muted font-semibold">Loading order details...</p>
      </div>

      <div v-else-if="order" class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
          <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
            <h2 class="text-xl font-black text-espresso mb-6">Status Timeline</h2>
            <div class="space-y-4">
              <div v-for="(item, index) in timeline" :key="item.label" class="flex gap-4 items-start">
                <div class="flex flex-col items-center">
                  <div :class="item.completed ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-muted'" class="w-10 h-10 rounded-full flex items-center justify-center font-black">
                    {{ item.completed ? '✓' : item.icon }}
                  </div>
                  <div v-if="index < timeline.length - 1" class="w-px flex-1 bg-slate-200 mt-2"></div>
                </div>
                <div class="flex-1 pt-1">
                  <p class="font-black text-espresso">{{ item.label }}</p>
                  <p class="text-sm text-muted mt-1">{{ item.description }}</p>
                  <p v-if="item.date" class="text-xs text-slate-400 mt-2">{{ item.date }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
            <h2 class="text-xl font-black text-espresso mb-6">Shipping & Payment</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-slate-50 p-5 border border-borderSoft">
                  <p class="text-xs text-muted uppercase tracking-[0.12em] font-black mb-2">Courier</p>
                  <p class="text-sm font-black text-espresso">{{ order.shipping_courier || 'Not available' }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5 border border-borderSoft">
                  <p class="text-xs text-muted uppercase tracking-[0.12em] font-black mb-2">Tracking Number</p>
                  <p class="text-sm font-black text-espresso break-all">{{ order.tracking_number || 'Not available' }}</p>
                </div>
              </div>
              <div class="rounded-3xl bg-slate-50 p-5 border border-borderSoft">
                <p class="text-xs text-muted uppercase tracking-[0.12em] font-black mb-2">Payment Status</p>
                <p class="text-sm font-black text-espresso">{{ paymentStatus }}</p>
              </div>
              <div class="rounded-3xl bg-slate-50 p-5 border border-borderSoft">
                <p class="text-xs text-muted uppercase tracking-[0.12em] font-black mb-2">Order Total</p>
                <p class="text-2xl font-black text-terracotta">{{ formatCurrency(order.total_amount) }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
          <h2 class="text-xl font-black text-espresso mb-6">Products</h2>
          <div class="space-y-4">
            <div v-for="item in order.items" :key="item.id" class="grid gap-4 sm:grid-cols-[auto_1fr_auto] items-center rounded-3xl bg-slate-50 p-5 border border-borderSoft">
              <div class="flex items-center gap-4">
                <img v-if="item.product?.image_url" :src="item.product.image_url" class="h-20 w-20 rounded-2xl object-cover" :alt="item.product?.name" />
                <div v-else class="h-20 w-20 rounded-2xl bg-slate-200"></div>
                <div>
                  <p class="font-black text-espresso">{{ item.product?.name || 'Product' }}</p>
                  <p class="text-sm text-muted mt-1">Quantity: {{ item.quantity }}</p>
                </div>
              </div>
              <div class="text-sm text-muted">
                <p>Unit price</p>
                <p class="font-black text-espresso mt-1">{{ formatCurrency(item.price) }}</p>
              </div>
              <div class="text-right text-espresso font-black text-lg">
                {{ formatCurrency(item.price * item.quantity) }}
              </div>
            </div>
          </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.4fr_0.6fr]">
          <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
            <h2 class="text-xl font-black text-espresso mb-6">Shipping Address</h2>
            <div class="rounded-3xl bg-slate-50 p-6 border border-borderSoft">
              <p class="font-black text-espresso mb-2">{{ order.buyer?.profile?.full_name || 'Buyer' }}</p>
              <p class="text-muted leading-relaxed">{{ order.buyer?.profile?.address || 'No address provided' }}</p>
              <p class="text-muted mt-3">Phone: {{ order.buyer?.profile?.phone || order.buyer?.phone_number || '-' }}</p>
            </div>
          </div>

          <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
            <h2 class="text-xl font-black text-espresso mb-6">Actions</h2>
            <div class="space-y-4">
              <button
                v-if="order.status === 'shipped'"
                @click="openTrackingLink"
                class="w-full rounded-3xl bg-blue-600 px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-blue-700 transition-all"
              >
                Track Package
              </button>
              <button
                v-if="order.status === 'pending'"
                @click="payOrder"
                class="w-full rounded-3xl bg-terracotta px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-terracottaDark transition-all"
              >
                Bayar Sekarang
              </button>
              <button
                @click="buyAgain"
                class="w-full rounded-3xl bg-slate-900 px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-slate-800 transition-all"
              >
                Buy Again
              </button>
              <button
                v-if="order.status === 'completed'"
                @click="writeReview"
                class="w-full rounded-3xl bg-emerald-600 px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-emerald-700 transition-all"
              >
                Write Review
              </button>
              <button
                v-if="order.status === 'pending'"
                @click="showCancelModal = true"
                class="w-full rounded-3xl bg-red-600 px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-red-700 transition-all"
              >
                Cancel Order
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft text-center">
        <p class="text-red-600 font-semibold mb-4">Order not found or you don't have access to this order.</p>
        <button @click="goBack" class="inline-flex items-center justify-center rounded-3xl bg-slate-200 px-6 py-3 text-sm font-black text-espresso hover:bg-slate-300 transition-all">
          Back to Orders
        </button>
      </div>
    </div>

    <div v-if="showCancelModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
      <div class="w-full max-w-md rounded-[2rem] bg-surface p-6 shadow-2xl border border-borderSoft">
        <h3 class="text-xl font-black text-espresso mb-3">Cancel Order</h3>
        <p class="text-muted mb-6">Are you sure you want to cancel this order? This action cannot be undone.</p>
        <div class="flex gap-3">
          <button @click="showCancelModal = false" class="flex-1 rounded-3xl border border-borderSoft bg-surface px-4 py-3 text-sm font-black uppercase tracking-widest text-espresso hover:bg-slate-50 transition-all">No, Keep It</button>
          <button @click="cancelOrder" class="flex-1 rounded-3xl bg-red-600 px-4 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-red-700 transition-all">Yes, Cancel</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useNotificationStore } from '@/stores/notificationStore';

const route = useRoute();
const router = useRouter();
const notificationStore = useNotificationStore();
const order = ref(null);
const loading = ref(true);
const showCancelModal = ref(false);

const apiHeaders = () => {
  const token = localStorage.getItem('token');
  const headers = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  };
  if (token) headers.Authorization = `Bearer ${token}`;
  return headers;
};

const payOrder = async () => {
  if (!order.value) return;
  try {
    const res = await fetch(`/api/v1/payment/orders/${order.value.id}/snap-token`, {
      method: 'POST',
      headers: apiHeaders(),
    });
    if (!res.ok) {
      throw new Error('Gagal mendapatkan token pembayaran.');
    }
    const data = await res.json();
    const snapToken = data.snap_token;
    
    if (window.snap?.pay) {
      window.snap.pay(snapToken, {
        onSuccess: () => {
          notificationStore.success('Pembayaran sukses! 🎉');
          fetchOrder();
        },
        onPending: () => {
          notificationStore.info('Menunggu pembayaran Anda...');
          fetchOrder();
        },
        onError: () => {
          notificationStore.error('Pembayaran gagal.');
        },
        onClose: () => {
          notificationStore.warning('Anda menutup pembayaran.');
        }
      });
    } else {
      window.location.href = data.redirect_url;
    }
  } catch (err) {
    console.error('Payment error:', err);
    notificationStore.error(err.message || 'Gagal memproses pembayaran.');
  }
};

const fetchOrder = async () => {
  loading.value = true;
  try {
    const res = await fetch(`/api/v1/orders/${route.params.id}`, {
      headers: apiHeaders(),
    });

    if (!res.ok) {
      order.value = null;
      return;
    }

    const data = await res.json();
    order.value = data.data;
  } catch (err) {
    console.error('Fetch order error:', err);
    order.value = null;
  } finally {
    loading.value = false;
  }
};

const timeline = computed(() => {
  if (!order.value) return [];
  const phases = [
    { status: 'pending', label: 'Pending Payment', description: 'Waiting for payment confirmation', icon: '⏳' },
    { status: 'paid', label: 'Processing', description: 'Order is being prepared', icon: '🔄' },
    { status: 'shipped', label: 'Shipped', description: 'Order is on the way', icon: '📦' },
    { status: 'completed', label: 'Delivered', description: 'Order has been delivered', icon: '✓' },
  ];

  return phases.map((phase) => ({
    ...phase,
    completed: ['pending', 'paid', 'shipped', 'completed'].indexOf(phase.status) <= ['pending', 'paid', 'shipped', 'completed'].indexOf(order.value.status),
    date: phase.status === order.value.status ? formatDate(order.value.updated_at || order.value.created_at) : null,
  }));
});

const paymentStatus = computed(() => {
  if (!order.value) return 'Unknown';
  if (order.value.status === 'pending') return 'Awaiting Payment';
  return 'Paid';
});

const formatDate = (value) => {
  if (!value) return '-';
  const date = new Date(value);
  return new Intl.DateTimeFormat('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  }).format(date);
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(amount);
};

const goBack = () => {
  router.push('/orders');
};

const openTrackingLink = () => {
  if (!order.value?.tracking_number) return;
  const url = `https://cekresi.com/?q=${order.value.tracking_number}`;
  window.open(url, '_blank');
};

const buyAgain = () => {
  if (!order.value) return;
  const buyAgainItems = order.value.items.map((item) => ({ product_id: item.product?.id, quantity: item.quantity }));
  sessionStorage.setItem('buyAgainItems', JSON.stringify(buyAgainItems));
  router.push('/cart?buyAgain=true');
};

const writeReview = () => {
  if (!order.value?.items?.length) return;
  const product = order.value.items[0].product;
  if (!product) return;
  router.push(`/product/${product.id}?review=true`);
};

const cancelOrder = async () => {
  try {
    const res = await fetch(`/api/v1/orders/${route.params.id}/cancel`, {
      method: 'POST',
      headers: apiHeaders(),
    });

    if (!res.ok) {
      console.error('Cancel order failed:', res.status);
      return;
    }

    await fetchOrder();
    showCancelModal.value = false;
  } catch (err) {
    console.error('Cancel order error:', err);
  }
};

onMounted(fetchOrder);
</script>

<style scoped>
.animate-spin {
  border-width: 4px;
}
</style>