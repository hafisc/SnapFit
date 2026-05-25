<template>
  <div class="snapfit-heritage-bg min-h-screen text-espresso selection:bg-terracotta selection:text-white font-sans relative pb-20">
    
    <main class="max-w-6xl mx-auto px-4 py-8 md:py-12">
      <!-- Back button and title -->
      <div class="mb-8" data-aos="fade-down">
        <button @click="goBack" class="inline-flex items-center gap-2 text-slate-500 hover:text-espresso transition-colors font-bold text-sm mb-4">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali
        </button>
        <h1 class="text-3xl md:text-4xl font-black text-espresso tracking-tight">Checkout Pembayaran</h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base">Selesaikan pesanan Anda dengan aman menggunakan gerbang pembayaran Midtrans.</p>
      </div>

      <!-- Main Layout Grid -->
      <div class="grid gap-8 lg:grid-cols-[1.6fr_1fr] items-start">
        
        <!-- Left Column: Checkout Sections -->
        <div class="space-y-6" data-aos="fade-up">
          
          <!-- SECTION 1: SHIPPING ADDRESS -->
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-md border border-borderSoft hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-borderSoft">
              <h2 class="text-lg font-black text-espresso flex items-center gap-2.5">
                <span class="w-6 h-6 rounded-full bg-sand flex items-center justify-center text-xs text-orange-700 font-bold">1</span>
                Alamat Pengiriman
              </h2>
              <button 
                @click="openAddressModal"
                class="rounded-full border border-terracotta/30 bg-sand px-4 py-1.5 text-xs font-black text-orange-700 hover:bg-[#F8F1E7]/80 transition-all"
              >
                {{ selectedAddress ? 'Ubah Alamat' : 'Pilih Alamat' }}
              </button>
            </div>

            <!-- Address Display -->
            <div v-if="selectedAddress" class="rounded-2xl bg-[#F8F1E7]/10 p-5 border border-borderSoft">
              <div class="flex items-start justify-between">
                <div>
                  <p class="font-black text-espresso">{{ selectedAddress.name }}</p>
                  <p class="text-sm text-espresso/80 mt-2 font-medium leading-relaxed">{{ selectedAddress.address }}</p>
                  <p class="text-xs text-slate-400 mt-1 font-semibold">{{ selectedAddress.city }} • {{ selectedAddress.postal_code }}</p>
                  <p class="text-xs text-slate-400 mt-1 font-semibold">HP: {{ selectedAddress.phone }}</p>
                </div>
                <span class="rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider px-3 py-1 border border-emerald-250">Terpilih</span>
              </div>
            </div>
            <div v-else class="text-center py-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50/50">
              <p class="text-slate-500 text-sm mb-4">Anda belum memilih alamat pengiriman.</p>
              <button @click="openAddressModal" class="rounded-full bg-terracotta text-white px-6 py-2.5 text-xs font-black uppercase tracking-widest hover:bg-terracottaDark transition-all">Pilih / Tambah Alamat</button>
            </div>
          </div>

          <!-- SECTION 2: PRODUCTS TO CHECKOUT -->
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-md border border-borderSoft hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-black text-espresso flex items-center gap-2.5 mb-6 pb-4 border-b border-borderSoft">
              <span class="w-6 h-6 rounded-full bg-sand flex items-center justify-center text-xs text-orange-700 font-bold">2</span>
              Detail Produk
            </h2>

            <div class="space-y-4">
              <div v-for="item in selectedItems" :key="`${item.id}-${item.variant}`" class="flex gap-4 p-4 rounded-2xl bg-[#FDFBF7] border border-borderSoft/60 hover:border-borderSoft transition-all duration-200">
                <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200">
                  <img :src="item.image" class="w-full h-full object-cover" :alt="item.name" />
                </div>
                <div class="flex-1 min-w-0 flex flex-col justify-between">
                  <div>
                    <h3 class="font-bold text-espresso text-sm md:text-base line-clamp-2 leading-snug">{{ item.name }}</h3>
                    <p v-if="item.variant" class="inline-block text-[10px] font-black uppercase tracking-wider text-slate-400 bg-slate-100 rounded-full px-2.5 py-0.5 mt-2">Varian: {{ item.variant }}</p>
                  </div>
                  <div class="flex items-center justify-between mt-3">
                    <p class="text-xs text-slate-500">Jumlah: <span class="font-bold text-espresso">{{ item.quantity }}</span></p>
                    <p class="font-black text-terracotta text-sm md:text-base">{{ formatCurrency((item.price || 0) * (item.quantity || 1)) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- SECTION 3: SHIPPING METHODS -->
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-md border border-borderSoft hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-black text-espresso flex items-center gap-2.5 mb-6 pb-4 border-b border-borderSoft">
              <span class="w-6 h-6 rounded-full bg-sand flex items-center justify-center text-xs text-orange-700 font-bold">3</span>
              Metode Pengiriman
            </h2>

            <!-- Courier Options -->
            <div class="grid gap-4 sm:grid-cols-3 mb-6">
              <button 
                v-for="courier in couriers" 
                :key="courier.id"
                @click="selectCourierType(courier.id)"
                class="text-left p-4 rounded-2xl border transition-all duration-200 flex flex-col justify-between h-20"
                :class="selectedCourier === courier.id ? 'border-terracotta bg-[#F8F1E7]/40 shadow-sm' : 'border-borderSoft bg-surface hover:border-slate-300'"
              >
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kurir</span>
                <span class="text-sm md:text-base font-black text-espresso">{{ courier.label }}</span>
              </button>
            </div>

            <!-- Service Selection -->
            <div class="grid gap-4 sm:grid-cols-2">
              <div class="rounded-2xl border border-borderSoft p-4 bg-slate-50/50">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Layanan Pengiriman</label>
                <select 
                  v-model="selectedService" 
                  @change="calculateShipping"
                  class="w-full bg-surface border border-borderSoft rounded-xl px-4 py-2.5 text-sm font-semibold text-espresso outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/10 transition-all"
                >
                  <option v-for="service in services" :key="service" :value="service">{{ service }}</option>
                </select>
              </div>

              <!-- Cost Details -->
              <div class="rounded-2xl bg-[#F8F1E7]/10 p-4 border border-borderSoft flex flex-col justify-between">
                <div class="flex justify-between items-start">
                  <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Estimasi Tiba</p>
                    <p class="text-sm font-bold text-espresso mt-1">{{ shippingEstimate }}</p>
                  </div>
                  <div class="text-right">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Ongkir</p>
                    <p class="text-lg font-black text-terracotta mt-1">{{ formatCurrency(shippingCost) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- SECTION 4: PAYMENT SYSTEM -->
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-md border border-borderSoft hover:shadow-lg transition-all duration-300">
            <h2 class="text-lg font-black text-espresso flex items-center gap-2.5 mb-6 pb-4 border-b border-borderSoft">
              <span class="w-6 h-6 rounded-full bg-sand flex items-center justify-center text-xs text-orange-700 font-bold">4</span>
              Metode Pembayaran
            </h2>

            <div class="rounded-2xl border border-terracotta bg-[#F8F1E7]/20 p-5 flex items-start gap-4 shadow-sm">
              <div class="w-10 h-10 rounded-xl bg-terracotta/10 border border-terracotta/20 flex items-center justify-center text-xl">💳</div>
              <div class="flex-1">
                <h4 class="font-bold text-espresso">Midtrans Secure Checkout</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Bayar menggunakan Virtual Account (VA), QRIS, GoPay, OVO, ShopeePay, atau Kartu Kredit/Debit. Koneksi aman terenkripsi.</p>
              </div>
              <input type="radio" checked class="w-5 h-5 text-terracotta focus:ring-terracotta" />
            </div>
          </div>

        </div>

        <!-- Right Column: Sticky Sidebar Order Summary -->
        <aside class="sticky top-6 space-y-6" data-aos="fade-up" data-aos-delay="100">
          
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-md border border-borderSoft">
            <h3 class="text-lg font-black text-espresso mb-5 pb-4 border-b border-borderSoft">Ringkasan Belanja</h3>

            <div class="space-y-4 text-sm text-espresso/90 mb-6">
              <div class="flex justify-between font-semibold">
                <span class="text-slate-400">Subtotal Barang</span>
                <span>{{ formatCurrency(subtotal) }}</span>
              </div>
              <div class="flex justify-between font-semibold">
                <span class="text-slate-400">Ongkos Kirim</span>
                <span>{{ formatCurrency(shippingCost) }}</span>
              </div>
              <div class="flex justify-between font-semibold">
                <span class="text-slate-400">Pajak / Admin</span>
                <span>Rp 0</span>
              </div>
              
              <div class="border-t border-borderSoft pt-4 flex justify-between items-baseline">
                <span class="text-base font-black text-espresso">Total Pembayaran</span>
                <span class="text-2xl font-black text-terracotta">{{ formatCurrency(totalPrice) }}</span>
              </div>
            </div>

            <!-- Pay Now Button -->
            <button 
              @click="payNow" 
              :disabled="!selectedAddress || shippingCost === 0 || isProcessingPayment" 
              class="w-full rounded-2xl bg-terracotta text-white py-4 font-black text-xs uppercase tracking-widest hover:bg-terracottaDark active:scale-[0.98] transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-terracotta/20 flex items-center justify-center gap-2 h-14"
            >
              <span v-if="isProcessingPayment" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
              {{ isProcessingPayment ? 'Memproses Pembayaran...' : 'Bayar Sekarang' }}
            </button>
            
            <p class="text-[10px] text-center text-slate-400 mt-3">Dengan mengklik tombol, Anda menyetujui syarat & ketentuan pembelian SnapFit.</p>
          </div>

          <!-- Extra Secure Shield Card -->
          <div class="rounded-3xl bg-[#ECFDF5] p-5 border border-emerald-250 flex items-start gap-3">
            <span class="text-xl text-emerald-600">🛡️</span>
            <div>
              <h4 class="text-xs font-bold text-emerald-950 uppercase tracking-wider">Garansi Transaksi Aman</h4>
              <p class="text-[11px] text-emerald-800 mt-1 leading-normal">Pembayaran Anda dilindungi enkripsi 256-bit SSL Midtrans. Dana hanya diteruskan ke pengrajin setelah produk dikirim.</p>
            </div>
          </div>
          
        </aside>

      </div>
    </main>

    <!-- ELEGANT ADDRESS MODAL (PILIH / TAMBAH ALAMAT) -->
    <div v-if="showAddressModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-espresso/50 backdrop-blur-sm p-0 sm:p-4">
      <div class="absolute inset-0" @click="closeAddressModal"></div>
      
      <div class="relative w-full sm:max-w-2xl bg-surface rounded-t-[2.5rem] sm:rounded-[2.5rem] shadow-2xl border border-borderSoft overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-borderSoft">
          <div>
            <h3 class="text-xl font-black text-espresso">Pilih Alamat Pengiriman</h3>
            <p class="text-xs text-slate-400 mt-1">Gunakan alamat yang sudah ada atau daftarkan alamat baru.</p>
          </div>
          <button @click="closeAddressModal" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-espresso transition-colors">✕</button>
        </div>

        <!-- Scrollable Modal Body -->
        <div class="overflow-y-auto p-6 flex-1 space-y-6">
          
          <!-- Address List -->
          <div v-if="!showAddressForm">
            <div class="flex items-center justify-between mb-4">
              <span class="text-xs font-black uppercase tracking-wider text-slate-400">Daftar Alamat Saya</span>
              <button 
                @click="showAddressForm = true"
                class="rounded-full bg-terracotta text-white px-4 py-1.5 text-xs font-black hover:bg-terracottaDark transition-all flex items-center gap-1"
              >
                ➕ Tambah Alamat Baru
              </button>
            </div>

            <div v-if="addresses.length" class="grid gap-4 sm:grid-cols-2">
              <div 
                v-for="address in addresses" 
                :key="address.id"
                @click="selectAddress(address.id)"
                class="text-left rounded-2xl border p-5 transition-all duration-200 cursor-pointer relative flex flex-col justify-between min-h-[140px]"
                :class="selectedAddressId === address.id ? 'border-terracotta bg-[#F8F1E7]/30 ring-2 ring-terracotta/10 shadow-sm' : 'border-borderSoft bg-surface hover:border-slate-300'"
              >
                <div>
                  <div class="flex justify-between items-start gap-2">
                    <p class="font-black text-espresso">{{ address.name }}</p>
                    <span v-if="selectedAddressId === address.id" class="rounded-full bg-terracotta/10 text-terracotta text-[9px] font-black uppercase tracking-wider px-2 py-0.5 border border-terracotta/25">Terpilih</span>
                  </div>
                  <p class="text-xs text-espresso/70 mt-2 leading-relaxed font-medium line-clamp-3">{{ address.address }}</p>
                  <p class="text-xs text-slate-400 mt-1 font-semibold">{{ address.city }} • {{ address.postal_code }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-borderSoft/40 flex justify-between items-center">
                  <p class="text-xs text-slate-400 font-semibold">📞 {{ address.phone }}</p>
                  <button @click.stop="deleteAddress(address.id)" class="text-[11px] text-red-500 font-bold hover:underline">Hapus</button>
                </div>
              </div>
            </div>
            
            <div v-else class="text-center py-12 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
              <p class="text-slate-500 text-sm mb-4">Anda belum mendaftarkan alamat.</p>
              <button @click="showAddressForm = true" class="rounded-full bg-terracotta text-white px-6 py-2.5 text-xs font-black uppercase tracking-widest hover:bg-terracottaDark transition-all">Tambah Alamat Pertama</button>
            </div>
          </div>

          <!-- Add Address Form -->
          <div v-else class="space-y-4">
            <h4 class="text-sm font-black text-espresso uppercase tracking-wider border-b border-borderSoft pb-2">Tambah Alamat Pengiriman Baru</h4>
            
            <div class="grid gap-4 sm:grid-cols-2">
              <label class="block">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Nama Penerima</span>
                <input v-model="addressForm.name" type="text" class="mt-2 w-full rounded-2xl border border-borderSoft bg-slate-50/50 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/15 transition-all" placeholder="Contoh: Budi Santoso" />
              </label>
              <label class="block">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">No. Handphone</span>
                <input v-model="addressForm.phone" type="tel" class="mt-2 w-full rounded-2xl border border-borderSoft bg-slate-50/50 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/15 transition-all" placeholder="0812XXXXXXXX" />
              </label>
            </div>
            
            <label class="block">
              <span class="text-xs font-black uppercase tracking-wider text-slate-400">Alamat Lengkap</span>
              <textarea v-model="addressForm.address" rows="3" class="mt-2 w-full rounded-2xl border border-borderSoft bg-slate-50/50 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/15 transition-all resize-none" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan kecamatan."></textarea>
            </label>
            
            <div class="grid gap-4 sm:grid-cols-2">
              <label class="block">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Kota / Kabupaten</span>
                <input v-model="addressForm.city" type="text" class="mt-2 w-full rounded-2xl border border-borderSoft bg-slate-50/50 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/15 transition-all" placeholder="Yogyakarta" />
              </label>
              <label class="block">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Kode Pos</span>
                <input v-model="addressForm.postal_code" type="text" class="mt-2 w-full rounded-2xl border border-borderSoft bg-slate-50/50 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/15 transition-all" placeholder="55123" />
              </label>
            </div>
            
            <p v-if="addressError" class="text-xs text-red-600 font-bold">{{ addressError }}</p>
            
            <div class="flex gap-3 pt-3">
              <button @click="saveAddress" class="flex-1 rounded-2xl bg-terracotta py-3.5 text-xs font-black uppercase tracking-widest text-white hover:bg-terracottaDark transition-all">Simpan & Gunakan</button>
              <button type="button" @click="showAddressForm = false" class="flex-1 rounded-2xl border border-borderSoft bg-surface py-3.5 text-xs font-black uppercase tracking-widest text-espresso hover:bg-slate-50 transition-all">Batal</button>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';
import { useNotificationStore } from '@/stores/notificationStore';

const router = useRouter();
const route = useRoute();
const cartStore = useCartStore();
const notificationStore = useNotificationStore();

const isProcessingPayment = ref(false);
const showAddressModal = ref(false);
const showAddressForm = ref(false);

const apiHeaders = () => {
  const token = localStorage.getItem('token');
  const headers = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  };
  if (token) headers.Authorization = `Bearer ${token}`;
  return headers;
};

const source = ref(route.query.source || 'cart');
const addresses = ref([]);
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
  { id: 'jnt', label: 'J&T' },
  { id: 'sicepat', label: 'SiCepat' },
];
const services = ['REG', 'YES', 'OKE'];
const selectedCourier = ref('jne');
const selectedService = ref('REG');
const shippingCost = ref(0);
const shippingEstimate = ref('2-4 hari');

const selectedItems = computed(() => {
  if (source.value === 'buy-now') {
    const buyNowItem = JSON.parse(sessionStorage.getItem('buy_now_item') ?? 'null');
    return buyNowItem ? [buyNowItem] : [];
  }
  return cartStore.selectedItems.length ? cartStore.selectedItems : cartStore.items;
});

const subtotal = computed(() => {
  return selectedItems.value.reduce((total, item) => total + (item.price || 0) * (item.quantity || 1), 0);
});

const totalPrice = computed(() => subtotal.value + shippingCost.value);

const selectedAddress = computed(() => {
  return addresses.value.find(address => address.id === selectedAddressId.value) || null;
});

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
  showAddressForm.value = false;
};

const createAddressId = () => {
  return `address-${Date.now()}`;
};

const saveAddress = () => {
  addressError.value = '';

  if (!addressForm.name || !addressForm.phone || !addressForm.address || !addressForm.city || !addressForm.postal_code) {
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
  showAddressForm.value = false;
};

const selectAddress = (addressId) => {
  selectedAddressId.value = addressId;
  showAddressModal.value = false;
};

const openAddressModal = () => {
  showAddressModal.value = true;
  showAddressForm.value = false;
};

const closeAddressModal = () => {
  showAddressModal.value = false;
};

const deleteAddress = (addressId) => {
  addresses.value = addresses.value.filter(a => a.id !== addressId);
  saveAddresses();
  if (selectedAddressId.value === addressId) {
    selectedAddressId.value = addresses.value.length ? addresses.value[0].id : null;
  }
};

const selectCourierType = (courierId) => {
  selectedCourier.value = courierId;
  calculateShipping();
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

const goBack = () => {
  if (source.value === 'cart') {
    router.push('/cart');
  } else {
    router.go(-1);
  }
};

const payNow = async () => {
  if (!selectedAddress.value) {
    notificationStore.error('Pilih alamat pengiriman terlebih dahulu.');
    return;
  }
  if (!selectedCourier.value) {
    notificationStore.error('Pilih kurir terlebih dahulu.');
    return;
  }

  isProcessingPayment.value = true;
  notificationStore.info('Sedang memproses pesanan Anda...');

  try {
    // 1. Sync address and phone to user profile on the backend
    const profileRes = await fetch('/api/v1/profile', {
      method: 'PUT',
      headers: apiHeaders(),
      body: JSON.stringify({
        full_name: selectedAddress.value.name,
        phone: selectedAddress.value.phone,
        address: `${selectedAddress.value.address}, ${selectedAddress.value.city} ${selectedAddress.value.postal_code}`
      })
    });
    if (!profileRes.ok) {
      console.warn('Gagal sinkronisasi alamat ke profil backend');
    }

    // 2. Create the order
    const orderItemsPayload = selectedItems.value.map(item => ({
      product_id: item.product_id,
      quantity: item.quantity,
      variant: item.variant || null
    }));

    const orderRes = await fetch('/api/v1/orders', {
      method: 'POST',
      headers: apiHeaders(),
      body: JSON.stringify({
        items: orderItemsPayload,
        shipping_courier: selectedCourier.value
      })
    });

    if (!orderRes.ok) {
      const errorData = await orderRes.json();
      throw new Error(errorData.message || 'Gagal membuat pesanan di server.');
    }

    const orderData = await orderRes.json();
    const order = orderData.data;

    // 3. Request Midtrans Snap Token
    const snapRes = await fetch(`/api/v1/payment/orders/${order.id}/snap-token`, {
      method: 'POST',
      headers: apiHeaders(),
    });

    if (!snapRes.ok) {
      throw new Error('Gagal mendapatkan token pembayaran Midtrans.');
    }

    const snapData = await snapRes.json();
    const snapToken = snapData.snap_token;

    // 4. Trigger Midtrans Snap Payment Popup
    if (typeof window.snap?.pay === 'function') {
      window.snap.pay(snapToken, {
        onSuccess: async (result) => {
          notificationStore.success('Pembayaran berhasil dikonfirmasi! 🎉');
          if (source.value === 'cart') {
            await cartStore.removeSelectedItems();
          } else {
            sessionStorage.removeItem('buy_now_item');
          }
          router.push({ name: 'order.detail', params: { id: order.id } });
        },
        onPending: (result) => {
          notificationStore.info('Menunggu pembayaran Anda...');
          if (source.value === 'cart') {
            cartStore.removeSelectedItems();
          } else {
            sessionStorage.removeItem('buy_now_item');
          }
          router.push({ name: 'order.detail', params: { id: order.id } });
        },
        onError: (result) => {
          notificationStore.error('Pembayaran gagal dilakukan. Silakan coba lagi.');
        },
        onClose: () => {
          notificationStore.warning('Anda menutup pembayaran. Detail pesanan Anda tersimpan.');
          if (source.value === 'cart') {
            cartStore.removeSelectedItems();
          } else {
            sessionStorage.removeItem('buy_now_item');
          }
          router.push({ name: 'order.detail', params: { id: order.id } });
        }
      });
    } else {
      // Fallback: Redirect to Midtrans Redirect URL
      notificationStore.info('Membuka halaman pembayaran...');
      window.location.href = snapData.redirect_url;
    }
  } catch (err) {
    console.error('Checkout error:', err);
    notificationStore.error(err.message || 'Terjadi kesalahan saat memproses pembayaran.');
  } finally {
    isProcessingPayment.value = false;
  }
};

onMounted(async () => {
  loadAddresses();
  calculateShipping();

  if (source.value === 'buy-now') {
    let buyNowItem = JSON.parse(sessionStorage.getItem('buy_now_item') ?? 'null');
    if (!buyNowItem && route.query.product_id) {
      // Re-construct the buy-now item from redirect query
      try {
        const res = await fetch(`/api/v1/products/${route.query.product_id}`);
        if (res.ok) {
          const payload = await res.json();
          const p = payload.product ?? payload;
          buyNowItem = {
            id: p.id,
            product_id: p.id,
            name: p.name,
            image: (typeof p.images === 'string' ? JSON.parse(p.images) : p.images)?.[0] ?? '',
            variant: route.query.variant || null,
            quantity: parseInt(route.query.qty || '1'),
            price: p.price
          };
          sessionStorage.setItem('buy_now_item', JSON.stringify(buyNowItem));
        }
      } catch (err) {
        console.error('Failed to restore buy-now item:', err);
      }
    }
  } else {
    await cartStore.loadCart();
    if (!cartStore.items.length) {
      router.push('/');
    }
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
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Animations */
@keyframes slideUp {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.animate-slide-up {
  animation: slideUp 0.3s ease-out forwards;
}

@media (min-width: 640px) {
  .sm\:animate-fade-in {
    animation: fadeIn 0.25s ease-out forwards;
  }
}
</style>
