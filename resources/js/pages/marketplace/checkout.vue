<template>
  <section class="min-h-screen bg-slate-50 text-slate-900 p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
      <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
          <router-link to="/marketplace/cart" class="text-slate-500 hover:text-slate-900 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </router-link>
          <div>
            <h1 class="text-3xl font-black text-slate-900">Checkout</h1>
            <p class="text-slate-600">Selesaikan pesanan Anda dalam 4 langkah cepat.</p>
          </div>
        </div>

        <div class="grid grid-cols-4 gap-3 text-xs uppercase tracking-[0.25em] font-black text-slate-500">
          <div :class="stepClass(1)">1. Alamat Pengiriman</div>
          <div :class="stepClass(2)">2. Metode Pengiriman</div>
          <div :class="stepClass(3)">3. Metode Pembayaran</div>
          <div :class="stepClass(4)">4. Review & Pesan</div>
        </div>
      </div>

      <div class="grid gap-8 lg:grid-cols-[1fr_380px]">
        <div class="space-y-6">
          <div v-if="orderSuccess" class="rounded-[2rem] bg-white p-8 shadow-sm border border-slate-200">
            <div class="text-center py-10">
              <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-3xl text-emerald-700">✓</div>
              <h2 class="text-2xl font-black text-slate-900 mb-3">Pesanan Berhasil Dibuat!</h2>
              <p class="text-slate-600 mb-6">Nomor pesanan Anda: <span class="font-semibold text-slate-900">{{ orderResponse.order_number ?? orderResponse.id }}</span></p>
              <div class="flex flex-col gap-3 sm:flex-row justify-center">
                <router-link to="/marketplace" class="inline-flex items-center justify-center rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black text-white hover:bg-orange-700 transition-all">
                  Kembali ke Marketplace
                </router-link>
                <button @click="goToOrders" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black text-slate-900 hover:bg-slate-50 transition-all">
                  Lihat Pesanan Saya
                </button>
              </div>
            </div>
          </div>

          <div v-else class="space-y-6">
            <!-- Step 1 -->
            <div v-show="activeStep === 1" class="rounded-[2rem] bg-white p-8 shadow-sm border border-slate-200">
              <div class="flex items-center justify-between mb-6">
                <div>
                  <h2 class="text-xl font-black text-slate-900">Alamat Pengiriman</h2>
                  <p class="text-sm text-slate-500">Pilih alamat tujuan atau tambahkan alamat baru.</p>
                </div>
                <button @click="toggleNewAddress" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition-all">
                  {{ showNewAddressForm ? 'Tutup Form' : 'Tambah Alamat Baru' }}
                </button>
              </div>

              <div v-if="addresses.length && !showNewAddressForm" class="grid gap-4 sm:grid-cols-2">
                <div
                  v-for="address in addresses"
                  :key="address.id"
                  @click="selectAddress(address.id)"
                  :class="[addressButtonClass(address.id), 'relative cursor-pointer']"
                >
                  <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-orange-100 text-orange-600 font-black">A</span>
                    <div class="text-left">
                      <p class="font-black text-slate-900">{{ address.name }}</p>
                      <p class="text-sm text-slate-500">{{ address.phone }}</p>
                    </div>
                  </div>
                  <p class="text-sm text-slate-600 leading-7">{{ address.address }}</p>
                  <button
                    v-if="address.id !== 'profile'"
                    type="button"
                    @click.stop="removeAddress(address.id)"
                    class="absolute right-4 top-4 text-xs font-semibold text-red-600 hover:text-red-800"
                  >
                    Hapus
                  </button>
                </div>
              </div>

              <div v-if="!addresses.length || showNewAddressForm" class="space-y-4 mt-4">
                <div class="rounded-3xl bg-blue-50 border border-blue-200 p-4">
                  <p class="text-sm text-blue-700">Silakan lengkapi informasi alamat pengiriman Anda untuk melanjutkan checkout.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                  <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Nama Penerima</span>
                    <input v-model="addressForm.name" type="text" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="Nama lengkap" />
                  </label>
                  <label class="block">
                    <span class="text-sm font-semibold text-slate-700">No. HP</span>
                    <input v-model="addressForm.phone" type="tel" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="0812xxxxxxx" />
                  </label>
                </div>
                <label class="block">
                  <span class="text-sm font-semibold text-slate-700">Alamat Lengkap</span>
                  <textarea v-model="addressForm.address" rows="3" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="Contoh: Jl. Merdeka No. 12"></textarea>
                </label>
                <div class="grid gap-4 sm:grid-cols-2">
                  <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Kota</span>
                    <input v-model="addressForm.city" type="text" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="Bandung" />
                  </label>
                  <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Kode Pos</span>
                    <input v-model="addressForm.postal_code" type="text" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" placeholder="40123" />
                  </label>
                </div>
                <div v-if="addressError" class="rounded-3xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ addressError }}</div>
                <div class="flex flex-wrap gap-3">
                  <button @click="saveAddress" class="rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-orange-700 transition-all">Simpan Alamat</button>
                  <button type="button" @click="resetNewAddressForm" class="rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 hover:bg-slate-100 transition-all">Batal</button>
                </div>
              </div>

              <div class="mt-6 flex justify-between">
                <button @click="previousStep" class="rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 hover:bg-slate-100 transition-all">Kembali</button>
                <button @click="nextStep" :disabled="!canProceedStep1" class="rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all">Lanjutkan ke Pengiriman</button>
              </div>
            </div>

            <!-- Step 2 -->
            <div v-show="activeStep === 2" class="rounded-[2rem] bg-white p-8 shadow-sm border border-slate-200">
              <div class="mb-6">
                <h2 class="text-xl font-black text-slate-900">Metode Pengiriman</h2>
                <p class="text-sm text-slate-500">Pilih kurir dan layanan pengiriman untuk pesanan Anda.</p>
              </div>

              <div class="grid gap-4 sm:grid-cols-2">
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Kurir</label>
                  <select v-model="selectedCourier" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <option v-for="courier in couriers" :key="courier.id" :value="courier.id">{{ courier.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Layanan</label>
                  <select v-model="selectedService" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <option v-for="service in services" :key="service" :value="service">{{ service }}</option>
                  </select>
                </div>
              </div>

              <div class="mt-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                <div class="flex items-center justify-between mb-4">
                  <div>
                    <p class="text-slate-500 text-sm">Estimasi Pengiriman</p>
                    <p class="text-lg font-black text-slate-900">{{ shippingEstimate || 'Pilih layanan' }}</p>
                  </div>
                  <div>
                    <p class="text-slate-500 text-sm">Biaya</p>
                    <p class="text-2xl font-black text-orange-600">{{ formatCurrency(shippingCost) }}</p>
                  </div>
                </div>
                <button @click="calculateShipping" :disabled="!selectedAddress" class="rounded-3xl bg-white px-6 py-3 text-sm font-black text-slate-900 border border-slate-200 hover:bg-slate-100 transition-all w-full">
                  {{ shippingCost ? 'Biaya Terhitung' : 'Hitung Biaya Pengiriman' }}
                </button>
              </div>

              <div v-if="shippingError" class="rounded-3xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ shippingError }}</div>

              <div class="mt-6 flex justify-between">
                <button @click="previousStep" class="rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 hover:bg-slate-100 transition-all">Kembali</button>
                <button @click="nextStep" :disabled="!canProceedStep2" class="rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all">Lanjutkan ke Pembayaran</button>
              </div>
            </div>

            <!-- Step 3 -->
            <div v-show="activeStep === 3" class="rounded-[2rem] bg-white p-8 shadow-sm border border-slate-200">
              <div class="mb-6">
                <h2 class="text-xl font-black text-slate-900">Metode Pembayaran</h2>
                <p class="text-sm text-slate-500">Pilih cara pembayaran yang nyaman bagi Anda.</p>
              </div>

              <div class="grid gap-4">
                <label v-for="method in paymentMethods" :key="method.id" class="flex cursor-pointer items-center gap-4 rounded-[1.75rem] border p-4 transition-all duration-200" :class="selectedPaymentMethod === method.id ? 'border-orange-400 bg-orange-50 shadow-sm' : 'border-slate-200 bg-white hover:border-slate-300'">
                  <input type="radio" name="paymentMethod" :value="method.id" v-model="selectedPaymentMethod" class="h-4 w-4 text-orange-600" />
                  <div>
                    <p class="font-black text-slate-900">{{ method.label }}</p>
                    <p class="text-sm text-slate-500">{{ method.subtitle }}</p>
                  </div>
                </label>
              </div>

              <div class="mt-6 flex justify-between">
                <button @click="previousStep" class="rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 hover:bg-slate-100 transition-all">Kembali</button>
                <button @click="nextStep" :disabled="!canProceedStep3" class="rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all">Lanjutkan ke Review</button>
              </div>
            </div>

            <!-- Step 4 -->
            <div v-show="activeStep === 4" class="rounded-[2rem] bg-white p-8 shadow-sm border border-slate-200">
              <div class="mb-6">
                <h2 class="text-xl font-black text-slate-900">Review Pesanan</h2>
                <p class="text-sm text-slate-500">Periksa kembali detail pesanan sebelum melakukan pembayaran.</p>
              </div>

              <div class="space-y-6">
                <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                  <p class="text-sm text-slate-500 mb-2">Alamat Pengiriman</p>
                  <p class="font-semibold text-slate-900">{{ selectedAddress?.name }}</p>
                  <p class="text-sm text-slate-600">{{ selectedAddress?.phone }}</p>
                  <p class="text-sm text-slate-600">{{ selectedAddress?.address }}, {{ selectedAddress?.city }}, {{ selectedAddress?.postal_code }}</p>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                  <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-slate-500">Pengiriman</p>
                    <p class="text-sm font-bold text-slate-900">{{ selectedCourier.toUpperCase() }} - {{ selectedService }}</p>
                  </div>
                  <p class="text-sm text-slate-600">Estimasi: {{ shippingEstimate || '-' }}</p>
                  <p class="text-sm text-slate-600">Biaya: {{ formatCurrency(shippingCost) }}</p>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                  <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-slate-500">Metode Pembayaran</p>
                    <p class="text-sm font-bold text-slate-900">{{ paymentLabel }}</p>
                  </div>
                  <p class="text-sm text-slate-600">Pilih metode untuk menyelesaikan pembayaran pesanan Anda.</p>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6">
                  <div class="flex items-center justify-between mb-4 text-slate-500 text-sm uppercase tracking-[0.2em] font-black">
                    <span>Produk</span>
                    <span>Subtotal</span>
                  </div>
                  <div class="space-y-4">
                    <div v-for="item in checkoutItems" :key="`${item.id}-${item.variant}`" class="flex flex-col gap-2 rounded-3xl border border-slate-100 bg-slate-50 p-4">
                      <div class="flex items-start gap-4">
                        <img :src="item.image" class="h-20 w-20 rounded-3xl object-cover" :alt="item.name" />
                        <div class="flex-1 min-w-0">
                          <p class="font-black text-slate-900 line-clamp-2">{{ item.name }}</p>
                          <p v-if="item.variant" class="text-sm text-slate-500">{{ item.variant }}</p>
                          <p class="text-sm text-slate-500">Jumlah: {{ item.quantity }}</p>
                        </div>
                        <p class="font-black text-slate-900">{{ formatCurrency(item.price * item.quantity) }}</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                  <div class="flex justify-between mb-3 text-sm text-slate-600">
                    <span>Subtotal</span>
                    <span>{{ formatCurrency(subtotal) }}</span>
                  </div>
                  <div class="flex justify-between mb-3 text-sm text-slate-600">
                    <span>Ongkir</span>
                    <span>{{ formatCurrency(shippingCost) }}</span>
                  </div>
                  <div class="border-t border-slate-200 pt-3 flex justify-between text-lg font-black text-slate-900">
                    <span>Total Pembayaran</span>
                    <span>{{ formatCurrency(totalPrice) }}</span>
                  </div>
                </div>

                <label class="flex items-start gap-3 rounded-3xl border border-slate-200 bg-white p-4">
                  <input type="checkbox" v-model="termsAccepted" class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500" />
                  <div>
                    <p class="font-black text-slate-900">Saya telah membaca dan menyetujui syarat & ketentuan</p>
                    <p class="text-sm text-slate-500">Dengan mencentang, Anda setuju pada aturan pembelian dan pengiriman.</p>
                  </div>
                </label>

                <div v-if="orderError" class="rounded-3xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ orderError }}</div>

                <div class="flex flex-col gap-3 sm:flex-row justify-between">
                  <button @click="previousStep" class="rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 hover:bg-slate-100 transition-all">Kembali</button>
                  <button @click="createOrder" :disabled="!termsAccepted || isPlacingOrder || !selectedAddress" class="rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                    {{ isPlacingOrder ? 'Memproses Pesanan...' : 'Place Order' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <aside class="space-y-6">
          <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-black text-slate-900 mb-4">Ringkasan Pesanan</h2>
            <div class="space-y-3 text-sm text-slate-600">
              <div class="flex justify-between">
                <span>Item</span>
                <span>{{ checkoutItems.length }}</span>
              </div>
              <div class="flex justify-between">
                <span>Subtotal</span>
                <span>{{ formatCurrency(subtotal) }}</span>
              </div>
              <div class="flex justify-between">
                <span>Pengiriman</span>
                <span>{{ formatCurrency(shippingCost) }}</span>
              </div>
              <div class="flex justify-between font-black text-slate-900 text-lg">
                <span>Total</span>
                <span>{{ formatCurrency(totalPrice) }}</span>
              </div>
            </div>
          </div>

          <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
            <h3 class="font-black text-slate-900 mb-3">Status Checkout</h3>
            <div class="space-y-3 text-sm text-slate-600">
              <p><span class="font-semibold text-slate-900">Alamat:</span> {{ selectedAddress?.city ?? '-' }}</p>
              <p><span class="font-semibold text-slate-900">Kurir:</span> {{ selectedCourier.toUpperCase() }}</p>
              <p><span class="font-semibold text-slate-900">Layanan:</span> {{ selectedService }}</p>
              <p><span class="font-semibold text-slate-900">Pembayaran:</span> {{ paymentLabel }}</p>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';

const router = useRouter();
const cartStore = useCartStore();

const activeStep = ref(1);
const orderSuccess = ref(false);
const orderResponse = ref(null);
const orderError = ref('');
const shippingError = ref('');
const isPlacingOrder = ref(false);

const addresses = ref([]);
const selectedAddressId = ref(null);
const showNewAddressForm = ref(false);
const addressError = ref('');

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
const shippingEstimate = ref('');

const shippingRates = {
  jne: { REG: 15000, YES: 25000, OKE: 12000 },
  jnt: { REG: 14000, YES: 23000, OKE: 11000 },
  sicepat: { REG: 13000, YES: 22000, OKE: 10000 },
};

const serviceEtas = {
  REG: '2-4 hari',
  YES: '1-2 hari',
  OKE: '3-5 hari',
};

const ADDRESS_STORAGE_KEY = 'snapfit_checkout_addresses';

const loadSavedAddresses = () => {
  try {
    const saved = localStorage.getItem(ADDRESS_STORAGE_KEY);
    return saved ? JSON.parse(saved) : [];
  } catch (error) {
    console.error('Failed to load saved addresses:', error);
    return [];
  }
};

const persistAddresses = () => {
  try {
    const saved = addresses.value.filter(address => address.id !== 'profile');
    localStorage.setItem(ADDRESS_STORAGE_KEY, JSON.stringify(saved));
  } catch (error) {
    console.error('Failed to persist addresses:', error);
  }
};

const createAddressId = () => {
  return typeof crypto !== 'undefined' && crypto.randomUUID
    ? crypto.randomUUID()
    : `addr-${Date.now()}`;
};

const addressButtonClass = (id) => {
  return selectedAddressId.value === id
    ? 'rounded-[2rem] border-2 border-orange-400 bg-orange-50 p-5 text-left'
    : 'rounded-[2rem] border border-slate-200 bg-white p-5 text-left hover:border-slate-300';
};

const paymentMethods = [
  { id: 'bca', label: 'BCA', subtitle: 'Bank Transfer', type: 'bank' },
  { id: 'mandiri', label: 'Mandiri', subtitle: 'Bank Transfer', type: 'bank' },
  { id: 'bri', label: 'BRI', subtitle: 'Bank Transfer', type: 'bank' },
  { id: 'gopay', label: 'GoPay', subtitle: 'E-Wallet', type: 'ewallet' },
  { id: 'ovo', label: 'OVO', subtitle: 'E-Wallet', type: 'ewallet' },
  { id: 'dana', label: 'Dana', subtitle: 'E-Wallet', type: 'ewallet' },
  { id: 'cod', label: 'Cash on Delivery', subtitle: 'Bayar di tempat', type: 'cod' },
  { id: 'va', label: 'Virtual Account', subtitle: 'Virtual Account bank', type: 'va' },
];
const selectedPaymentMethod = ref('bca');
const termsAccepted = ref(false);

const selectedAddress = computed(() => addresses.value.find(address => address.id === selectedAddressId.value));
const checkoutItems = computed(() => {
  return cartStore.selectedItems.length ? cartStore.selectedItems : cartStore.items;
});
const subtotal = computed(() => checkoutItems.value.reduce((total, item) => total + (item.price || 0) * (item.quantity || 1), 0));
const totalPrice = computed(() => subtotal.value + shippingCost.value);
const paymentLabel = computed(() => paymentMethods.find(method => method.id === selectedPaymentMethod.value)?.label || 'Bank Transfer');

const canProceedStep1 = computed(() => {
  if (showNewAddressForm.value || !addresses.value.length) {
    return Boolean(addressForm.name && addressForm.phone && addressForm.address);
  }
  return Boolean(selectedAddressId.value);
});

const canProceedStep2 = computed(() => Boolean(selectedAddressId.value && selectedCourier.value && selectedService.value && shippingCost.value > 0));
const canProceedStep3 = computed(() => Boolean(selectedPaymentMethod.value));

const stepClass = (step) => {
  if (activeStep.value === step) return 'text-orange-600';
  if (activeStep.value > step) return 'text-slate-900';
  return 'text-slate-400';
};

const apiHeaders = () => {
  const token = localStorage.getItem('token');
  const headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  };
  if (token) headers.Authorization = `Bearer ${token}`;
  return headers;
};

const fetchAddresses = async () => {
  try {
    const savedAddresses = loadSavedAddresses();

    const res = await fetch('/api/v1/profile', {
      headers: apiHeaders(),
    });
    if (!res.ok) {
      console.error('Failed to fetch profile:', res.status, res.statusText);
      addresses.value = savedAddresses;
      if (!addresses.value.length) showNewAddressForm.value = true;
      return;
    }

    const data = await res.json();
    const user = data.user || data.data?.user || null;
    const profile = user?.profile;

    const profileEntry = profile && profile.address
      ? {
          id: 'profile',
          name: profile.full_name || user.name,
          phone: profile.phone || '',
          address: profile.address || '',
          city: '',
          postal_code: '',
        }
      : null;

    const merged = [...savedAddresses];
    if (profileEntry && !merged.find(addr => addr.address === profileEntry.address && addr.phone === profileEntry.phone)) {
      merged.unshift(profileEntry);
    }

    addresses.value = merged;
    if (addresses.value.length) {
      selectedAddressId.value = addresses.value[0].id;
    } else {
      showNewAddressForm.value = true;
    }
  } catch (err) {
    console.error('Failed to load profile address:', err);
    addresses.value = loadSavedAddresses();
    if (!addresses.value.length) showNewAddressForm.value = true;
  }
};

const selectAddress = (addressId) => {
  selectedAddressId.value = addressId;
  showNewAddressForm.value = false;
};

const toggleNewAddress = () => {
  showNewAddressForm.value = !showNewAddressForm.value;
};

const resetNewAddressForm = () => {
  addressForm.name = '';
  addressForm.phone = '';
  addressForm.address = '';
  addressForm.city = '';
  addressForm.postal_code = '';
  addressError.value = '';
  showNewAddressForm.value = false;
};

const saveAddress = async () => {
  addressError.value = '';

  if (!canProceedStep1.value) {
    addressError.value = 'Lengkapi semua informasi alamat terlebih dahulu.';
    return;
  }

  const newAddress = {
    id: createAddressId(),
    name: addressForm.name,
    phone: addressForm.phone,
    address: addressForm.address,
    city: addressForm.city,
    postal_code: addressForm.postal_code,
  };

  try {
    addresses.value = [...addresses.value, newAddress];
    selectedAddressId.value = newAddress.id;
    persistAddresses();
    showNewAddressForm.value = false;
    resetNewAddressForm();
  } catch (err) {
    console.error('Save address error:', err);
    addressError.value = 'Terjadi kesalahan saat menyimpan alamat.';
  }
};

const removeAddress = (addressId) => {
  if (addressId === 'profile') {
    addressError.value = 'Alamat profil tidak dapat dihapus dari sini.';
    return;
  }

  addresses.value = addresses.value.filter(address => address.id !== addressId);
  persistAddresses();

  if (selectedAddressId.value === addressId) {
    selectedAddressId.value = addresses.value.length ? addresses.value[0].id : null;
  }
};

const calculateShipping = () => {
  if (!selectedAddress.value) {
    shippingCost.value = 0;
    shippingEstimate.value = '';
    return;
  }

  const courierRates = shippingRates[selectedCourier.value] || shippingRates.jne;
  shippingCost.value = courierRates[selectedService.value] ?? courierRates.REG;
  shippingEstimate.value = serviceEtas[selectedService.value] || serviceEtas.REG;
};

const createOrder = async () => {
  orderError.value = '';

  if (!termsAccepted.value) {
    orderError.value = 'Anda harus menyetujui syarat dan ketentuan sebelum melanjutkan.';
    return;
  }
  if (!selectedAddressId.value) {
    orderError.value = 'Pilih alamat pengiriman terlebih dahulu.';
    return;
  }

  isPlacingOrder.value = true;

  try {
    const response = await fetch('/api/v1/orders', {
      method: 'POST',
      headers: apiHeaders(),
      body: JSON.stringify({
        address_id: selectedAddressId.value,
        courier: selectedCourier.value,
        service: selectedService.value,
        shipping_cost: shippingCost.value,
        payment_method: selectedPaymentMethod.value,
        items: checkoutItems.value.map(item => ({ product_id: item.id, quantity: item.quantity, variant: item.variant })),
        total: totalPrice.value,
      }),
    });

    if (!response.ok) {
      const errorData = await response.json();
      orderError.value = errorData.message || 'Gagal membuat pesanan.';
      return;
    }

    const data = await response.json();
    orderResponse.value = data.data || data;
    orderSuccess.value = true;

    if (cartStore.selectedItems.length) {
      await cartStore.removeSelectedItems();
    } else {
      await cartStore.clearCart();
    }
  } catch (err) {
    console.error('Order error:', err);
    orderError.value = 'Terjadi kesalahan saat memproses pesanan.';
  } finally {
    isPlacingOrder.value = false;
  }
};

const nextStep = () => {
  if (activeStep.value === 1 && !canProceedStep1.value) return;
  if (activeStep.value === 2 && !canProceedStep2.value) return;
  if (activeStep.value === 3 && !canProceedStep3.value) return;
  activeStep.value = Math.min(4, activeStep.value + 1);
};

const previousStep = () => {
  activeStep.value = Math.max(1, activeStep.value - 1);
};

const goToOrders = () => {
  router.push('/marketplace/orders');
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(amount);
};

watch([selectedCourier, selectedService, selectedAddressId], () => {
  if (activeStep.value === 2) {
    calculateShipping();
  }
});

onMounted(async () => {
  if (!cartStore.items.length) {
    await cartStore.loadCart();
  }

  if (!cartStore.items.length) {
    router.push('/marketplace/cart');
    return;
  }

  await fetchAddresses();
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
