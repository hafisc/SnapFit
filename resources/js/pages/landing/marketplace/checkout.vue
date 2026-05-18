<template>
  <section class="min-h-screen bg-slate-50 text-espresso p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
      <div class="mb-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h1 class="text-4xl font-black text-espresso">Checkout</h1>
            <p class="text-muted mt-2">Lengkapi alamat dan pilih pengiriman sebelum melanjutkan ke pembayaran.</p>
          </div>
          <div class="rounded-full bg-sand px-4 py-2 text-sm font-semibold text-orange-700">Source: {{ sourceLabel }}</div>
        </div>
      </div>

      <div class="grid gap-8 lg:grid-cols-[1.7fr_0.9fr]">
        <div class="space-y-6">
          <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
            <div class="flex items-center justify-between mb-6">
              <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-400 font-black">Langkah</p>
                <h2 class="text-2xl font-black text-espresso">{{ stepTitle }}</h2>
              </div>
              <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-black text-espresso">{{ activeStep }} / 3</span>
            </div>

            <div v-if="activeStep === 1" class="space-y-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-espresso font-black">Alamat Pengiriman</p>
                  <p class="text-sm text-muted">Pilih alamat yang akan digunakan untuk pengiriman.</p>
                </div>
                <button @click="toggleAddressForm" class="rounded-full border border-terracotta/30 bg-sand px-4 py-2 text-sm font-black text-orange-700 hover:bg-sand transition-all">{{ showNewAddress ? 'Tutup Form' : 'Tambah Alamat' }}</button>
              </div>

              <div v-if="addresses.length && !showNewAddress" class="grid gap-4 sm:grid-cols-2">
                <button
                  v-for="address in addresses"
                  :key="address.id"
                  @click="selectAddress(address.id)"
                  :class="addressClass(address.id)"
                  class="text-left rounded-3xl border p-5 transition-all"
                >
                  <p class="font-black text-espresso">{{ address.name }}</p>
                  <p class="text-sm text-muted mt-2">{{ address.address }}</p>
                  <p class="text-sm text-muted mt-1">{{ address.city }} • {{ address.postal_code }}</p>
                  <p class="text-sm text-muted mt-1">{{ address.phone }}</p>
                </button>
              </div>

              <div v-if="showNewAddress || !addresses.length" class="space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                  <label class="block">
                    <span class="text-sm font-semibold text-espresso">Nama Penerima</span>
                    <input v-model="addressForm.name" type="text" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20" placeholder="Nama lengkap" />
                  </label>
                  <label class="block">
                    <span class="text-sm font-semibold text-espresso">No. HP</span>
                    <input v-model="addressForm.phone" type="tel" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20" placeholder="081234567890" />
                  </label>
                </div>
                <label class="block">
                  <span class="text-sm font-semibold text-espresso">Alamat Lengkap</span>
                  <textarea v-model="addressForm.address" rows="3" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20" placeholder="Contoh: Jl. Merdeka No. 12"></textarea>
                </label>
                <div class="grid gap-4 sm:grid-cols-2">
                  <label class="block">
                    <span class="text-sm font-semibold text-espresso">Kota</span>
                    <input v-model="addressForm.city" type="text" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20" placeholder="Bandung" />
                  </label>
                  <label class="block">
                    <span class="text-sm font-semibold text-espresso">Kode Pos</span>
                    <input v-model="addressForm.postal_code" type="text" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20" placeholder="40123" />
                  </label>
                </div>
                <p v-if="addressError" class="text-sm text-red-600">{{ addressError }}</p>
                <div class="flex flex-wrap gap-3">
                  <button @click="saveAddress" class="rounded-3xl bg-terracotta px-6 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-terracottaDark transition-all">Simpan Alamat</button>
                  <button type="button" @click="resetAddressForm" class="rounded-3xl border border-borderSoft bg-surface px-6 py-3 text-sm font-black uppercase tracking-widest text-espresso hover:bg-slate-100 transition-all">Batal</button>
                </div>
              </div>
            </div>

            <div v-if="activeStep === 2" class="space-y-6">
              <div>
                <p class="font-black text-espresso">Metode Pengiriman</p>
                <p class="text-sm text-muted">Pilih kurir dan layanan untuk pesanan Anda.</p>
              </div>
              <div class="grid gap-4 sm:grid-cols-2">
                <label class="block">
                  <span class="text-sm font-semibold text-espresso">Kurir</span>
                  <select v-model="selectedCourier" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20">
                    <option v-for="courier in couriers" :key="courier.id" :value="courier.id">{{ courier.label }}</option>
                  </select>
                </label>
                <label class="block">
                  <span class="text-sm font-semibold text-espresso">Layanan</span>
                  <select v-model="selectedService" class="mt-2 w-full rounded-3xl border border-borderSoft bg-slate-50 px-4 py-3 outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20">
                    <option v-for="service in services" :key="service" :value="service">{{ service }}</option>
                  </select>
                </label>
              </div>
              <div class="rounded-[2rem] border border-borderSoft bg-slate-50 p-6">
                <div class="flex items-center justify-between mb-4">
                  <div>
                    <p class="text-sm text-muted">Estimasi Pengiriman</p>
                    <p class="text-lg font-black text-espresso">{{ shippingEstimate }}</p>
                  </div>
                  <div class="text-right">
                    <p class="text-sm text-muted">Biaya</p>
                    <p class="text-2xl font-black text-terracotta">{{ formatCurrency(shippingCost) }}</p>
                  </div>
                </div>
                <button @click="calculateShipping" :disabled="!selectedAddressId" class="w-full rounded-3xl bg-surface px-6 py-3 text-sm font-black text-espresso border border-borderSoft hover:bg-slate-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed">Hitung Ongkos</button>
              </div>
            </div>

            <div v-if="activeStep === 3" class="space-y-6">
              <div>
                <p class="font-black text-espresso">Review Pesanan</p>
                <p class="text-sm text-muted">Pastikan alamat dan pengiriman sudah benar sebelum melanjutkan.</p>
              </div>
              <div class="rounded-[2rem] border border-borderSoft bg-slate-50 p-6">
                <p class="text-sm text-muted mb-2">Alamat Pengiriman</p>
                <p class="font-semibold text-espresso">{{ selectedAddress?.name }}</p>
                <p class="text-sm text-muted">{{ selectedAddress?.address }}, {{ selectedAddress?.city }} {{ selectedAddress?.postal_code }}</p>
                <p class="text-sm text-muted">{{ selectedAddress?.phone }}</p>
              </div>
              <div class="rounded-[2rem] border border-borderSoft bg-slate-50 p-6">
                <div class="flex items-center justify-between mb-4 text-sm text-muted uppercase tracking-[0.18em] font-black">
                  <span>Pengiriman</span>
                  <span>{{ courierLabel }}</span>
                </div>
                <p class="text-sm text-muted">Estimasi: {{ shippingEstimate }}</p>
                <p class="text-sm text-muted">Biaya: {{ formatCurrency(shippingCost) }}</p>
              </div>
              <div class="rounded-[2rem] border border-borderSoft bg-surface p-6">
                <div class="flex justify-between mb-3 text-sm text-muted">
                  <span>Subtotal</span>
                  <span>{{ formatCurrency(subtotal) }}</span>
                </div>
                <div class="flex justify-between mb-3 text-sm text-muted">
                  <span>Ongkir</span>
                  <span>{{ formatCurrency(shippingCost) }}</span>
                </div>
                <div class="border-t border-borderSoft pt-3 flex justify-between text-lg font-black text-espresso">
                  <span>Total</span>
                  <span>{{ formatCurrency(totalPrice) }}</span>
                </div>
              </div>
              <button @click="goToQris" :disabled="!canPay" class="w-full rounded-3xl bg-terracotta px-6 py-4 text-sm font-black uppercase tracking-widest text-white hover:bg-terracottaDark transition-all disabled:opacity-50 disabled:cursor-not-allowed">Lanjut ke QRIS</button>
            </div>
          </div>

          <div class="flex justify-between gap-3">
            <button @click="previousStep" :disabled="activeStep === 1" class="flex-1 rounded-3xl border border-borderSoft bg-surface px-6 py-4 text-sm font-black uppercase tracking-widest text-espresso hover:bg-slate-100 disabled:opacity-50 disabled:cursor-not-allowed transition-all">Kembali</button>
            <button @click="nextStep" :disabled="!canContinue" class="flex-1 rounded-3xl bg-slate-900 px-6 py-4 text-sm font-black uppercase tracking-widest text-white hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all">{{ activeStep < 3 ? 'Lanjutkan' : 'Simpan' }}</button>
          </div>
        </div>

        <aside class="space-y-6">
          <div class="rounded-[2rem] bg-surface p-8 shadow-sm border border-borderSoft">
            <h3 class="text-lg font-black text-espresso mb-4">Ringkasan Pesanan</h3>
            <div class="space-y-4">
              <div v-for="item in selectedItems" :key="`${item.id}-${item.variant}`" class="flex items-center gap-4 rounded-3xl bg-slate-50 p-4">
                <img :src="item.image" class="h-20 w-20 rounded-3xl object-cover" :alt="item.name" />
                <div class="flex-1 min-w-0">
                  <p class="font-black text-espresso line-clamp-2">{{ item.name }}</p>
                  <p v-if="item.variant" class="text-sm text-muted">{{ item.variant }}</p>
                  <p class="text-sm text-muted mt-2">Jumlah: {{ item.quantity }}</p>
                </div>
                <p class="font-black text-espresso">{{ formatCurrency((item.price || 0) * (item.quantity || 1)) }}</p>
              </div>
            </div>
          </div>

          <div class="rounded-[2rem] border border-borderSoft bg-slate-50 p-6">
            <p class="text-sm text-muted mb-3 uppercase tracking-[0.18em] font-black">Detail</p>
            <div class="space-y-3 text-sm text-muted">
              <div class="flex justify-between">
                <span>Items</span>
                <span>{{ selectedItems.length }}</span>
              </div>
              <div class="flex justify-between">
                <span>Subtotal</span>
                <span>{{ formatCurrency(subtotal) }}</span>
              </div>
              <div class="flex justify-between">
                <span>Ongkir</span>
                <span>{{ formatCurrency(shippingCost) }}</span>
              </div>
              <div class="flex justify-between font-black text-espresso text-lg">
                <span>Total</span>
                <span>{{ formatCurrency(totalPrice) }}</span>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';

const router = useRouter();
const route = useRoute();
const cartStore = useCartStore();

const activeStep = ref(1);
const source = ref(route.query.source || 'cart');
const addresses = ref([]);
const showNewAddress = ref(false);
const addressError = ref('');
const selectedAddressId = ref(null);

const addressForm = reactive({
  name: '',
  phone: '',
  address: '',
  city: '',
  postal_code: '',
});

const couriers = [
  { id: 'jne', label: 'JNE' },
  { id: 'jnt', label: 'JNT' },
  { id: 'sicepat', label: 'SiCepat' },
];
const services = ['REG', 'YES', 'OKE'];
const selectedCourier = ref('jne');
const selectedService = ref('REG');
const shippingCost = ref(0);
const shippingEstimate = ref('2-4 hari');

const selectedItems = computed(() => {
  return cartStore.selectedItems.length ? cartStore.selectedItems : cartStore.items;
});

const subtotal = computed(() => {
  return selectedItems.value.reduce((total, item) => total + (item.price || 0) * (item.quantity || 1), 0);
});

const totalPrice = computed(() => subtotal.value + shippingCost.value);

const canProceedStep1 = computed(() => {
  if (showNewAddress.value || !addresses.value.length) {
    return Boolean(addressForm.name && addressForm.phone && addressForm.address && addressForm.city && addressForm.postal_code);
  }
  return Boolean(selectedAddressId.value);
});

const canProceedStep2 = computed(() => selectedAddressId.value && selectedCourier.value && selectedService.value && shippingCost.value > 0);
const canPay = computed(() => selectedAddressId.value && shippingCost.value > 0);
const canContinue = computed(() => {
  if (activeStep.value === 1) return canProceedStep1.value;
  if (activeStep.value === 2) return canProceedStep2.value;
  return true;
});

const sourceLabel = computed(() => {
  if (source.value === 'buy-now') return 'Beli Sekarang';
  if (source.value === 'cart') return 'Keranjang';
  return 'Checkout';
});

const stepTitle = computed(() => {
  if (activeStep.value === 1) return 'Pilih alamat pengiriman';
  if (activeStep.value === 2) return 'Pilih metode pengiriman';
  return 'Review pesanan Anda';
});

const courierLabel = computed(() => {
  const courier = couriers.find(c => c.id === selectedCourier.value);
  return courier ? `${courier.label} - ${selectedService.value}` : selectedService.value;
});

const selectedAddress = computed(() => {
  return addresses.value.find(address => address.id === selectedAddressId.value) || null;
});

const addressClass = (id) => {
  return selectedAddressId.value === id
    ? 'border-terracotta bg-sand'
    : 'border-borderSoft bg-surface hover:border-slate-300';
};

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value);
};

const loadAddresses = () => {
  try {
    const saved = JSON.parse(localStorage.getItem('snapfit_addresses') || '[]');
    addresses.value = saved;
    if (!selectedAddressId.value && saved.length) {
      selectedAddressId.value = saved[0].id;
    }
  } catch {
    addresses.value = [];
  }
};

const saveAddresses = () => {
  localStorage.setItem('snapfit_addresses', JSON.stringify(addresses.value));
};

const resetAddressForm = () => {
  addressForm.name = '';
  addressForm.phone = '';
  addressForm.address = '';
  addressForm.city = '';
  addressForm.postal_code = '';
  addressError.value = '';
  showNewAddress.value = false;
};

const createAddressId = () => {
  return `address-${Date.now()}`;
};

const saveAddress = () => {
  addressError.value = '';

  if (!canProceedStep1.value) {
    addressError.value = 'Lengkapi semua informasi alamat terlebih dahulu.';
    return;
  }

  const newAddress = {
    id: createAddressId(),
    ...addressForm,
  };

  addresses.value.push(newAddress);
  selectedAddressId.value = newAddress.id;
  saveAddresses();
  resetAddressForm();
};

const selectAddress = (addressId) => {
  selectedAddressId.value = addressId;
  showNewAddress.value = false;
};

const toggleAddressForm = () => {
  showNewAddress.value = !showNewAddress.value;
};

const calculateShipping = () => {
  const courierRates = {
    jne: { REG: 15000, YES: 25000, OKE: 12000 },
    jnt: { REG: 14000, YES: 23000, OKE: 11000 },
    sicepat: { REG: 13000, YES: 22000, OKE: 10000 },
  };

  const duration = {
    REG: '2-4 hari',
    YES: '1-2 hari',
    OKE: '3-5 hari',
  };

  shippingCost.value = courierRates[selectedCourier.value]?.[selectedService.value] ?? 0;
  shippingEstimate.value = duration[selectedService.value] || '2-4 hari';
};

const nextStep = () => {
  if (!canContinue.value) return;
  if (activeStep.value < 3) {
    activeStep.value += 1;
    if (activeStep.value === 2) {
      calculateShipping();
    }
  }
};

const previousStep = () => {
  activeStep.value = Math.max(1, activeStep.value - 1);
};

const goToQris = () => {
  router.push({ name: 'marketplace.qris', query: { source: source.value } });
};

onMounted(async () => {
  await cartStore.loadCart();
  loadAddresses();

  if (!cartStore.items.length) {
    router.push('/marketplace');
  }
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
