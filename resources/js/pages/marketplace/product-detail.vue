<template>
  <section class="min-h-screen bg-slate-50 text-slate-900 p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
      <div class="mb-6 text-sm text-slate-500">
        <router-link to="/" class="hover:text-slate-900 transition">Home</router-link>
        <span class="px-2">/</span>
        <router-link to="/marketplace" class="hover:text-slate-900 transition">Marketplace</router-link>
        <span class="px-2">/</span>
        <span class="font-semibold">Detail Produk</span>
      </div>

      <div class="grid gap-8 lg:grid-cols-[1.3fr_0.9fr]">
        <div class="space-y-6">
          <div class="bg-white rounded-[2rem] p-4 shadow-sm border border-slate-200 overflow-hidden">
            <div class="grid gap-4 lg:grid-cols-[1fr_80px]">
              <div class="relative overflow-hidden rounded-[2rem] bg-slate-100">
                <img
                  v-if="activeImage"
                  :src="activeImage"
                  :alt="product?.name ?? 'Product image'"
                  class="w-full h-[520px] object-cover transition duration-300 ease-out hover:scale-105"
                />
                <div class="absolute right-4 top-4 rounded-full bg-white/80 px-3 py-2 text-xs font-semibold text-slate-700 backdrop-blur">
                  {{ currentImageLabel }}
                </div>
              </div>

              <div class="flex flex-col gap-3 overflow-hidden rounded-[2rem] bg-slate-50 p-3">
                <button
                  v-for="(image, index) in galleryImages"
                  :key="index"
                  type="button"
                  @click="activeImageIndex = index"
                  class="group flex h-20 items-center justify-center overflow-hidden rounded-3xl border transition-all duration-200"
                  :class="index === activeImageIndex ? 'border-orange-500 ring-2 ring-orange-200' : 'border-slate-200 hover:border-slate-300'"
                >
                  <img :src="image" :alt="`Gallery ${index + 1}`" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                </button>
              </div>
            </div>
          </div>

          <div class="grid gap-3 lg:grid-cols-[1fr_1fr]">
            <div v-if="product?.description" class="rounded-[2rem] bg-white p-6 shadow-sm border border-slate-200">
              <h3 class="text-lg font-black text-slate-900 mb-3">Deskripsi Produk</h3>
              <p class="text-slate-600 leading-7 whitespace-pre-line">{{ product.description }}</p>
            </div>

            <div class="rounded-[2rem] bg-white p-6 shadow-sm border border-slate-200">
              <h3 class="text-lg font-black text-slate-900 mb-3">Info Penjual</h3>
              <div class="space-y-3 text-slate-700">
                <div>
                  <p class="text-sm uppercase tracking-[0.18em] text-slate-400">UMKM</p>
                  <p class="font-semibold text-slate-900">{{ product?.seller?.name ?? product?.seller_name ?? 'UMKM Lokal' }}</p>
                </div>
                <div>
                  <p class="text-sm uppercase tracking-[0.18em] text-slate-400">Lokasi</p>
                  <p>{{ product?.seller?.location ?? product?.seller_location ?? 'Indonesia' }}</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600">
                  <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 font-semibold text-emerald-700">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2.5 10a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0zm10.894-1.356L9 13.038l-2.394-2.394.848-.848L9 11.342l4.546-4.546.848.848z" />
                    </svg>
                    Terpercaya
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-[2rem] bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-black text-slate-900">Produk Terkait</h3>
              <button
                type="button"
                @click="refreshRelated"
                class="text-sm font-semibold text-orange-600 hover:text-orange-700"
              >Refresh</button>
            </div>
            <div v-if="relatedProducts.length" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
              <router-link
                v-for="item in relatedProducts"
                :key="item.id"
                :to="{ name: 'marketplace.product.detail', params: { id: item.id } }"
                class="group block rounded-3xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-1 hover:shadow-lg"
              >
                <img :src="item.images?.[0] ?? item.image_url" :alt="item.name" class="h-32 w-full rounded-3xl object-cover" />
                <div class="mt-3">
                  <h4 class="text-sm font-semibold text-slate-900 line-clamp-2">{{ item.name }}</h4>
                  <p class="text-sm text-slate-600 mt-2">Rp {{ formatCurrency(item.price) }}</p>
                </div>
              </router-link>
            </div>
            <p v-else class="text-sm text-slate-500">Tidak ada produk terkait saat ini.</p>
          </div>
        </div>

        <div class="space-y-6">
          <div class="rounded-[2rem] bg-white p-8 shadow-sm border border-slate-200">
            <div class="mb-5">
              <p class="text-xs uppercase tracking-[0.3em] text-orange-500">Marketplace</p>
              <h1 class="mt-3 text-3xl font-black text-slate-900 leading-tight">{{ product?.name ?? 'Loading produk...' }}</h1>
              <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                <div class="inline-flex items-center gap-1">
                  <span class="font-semibold text-slate-900">{{ product?.rating?.toFixed(1) ?? product?.average_rating?.toFixed(1) ?? '0.0' }}</span>
                  <span>/ 5</span>
                </div>
                <div class="inline-flex items-center gap-1">
                  <span class="text-slate-400">|</span>
                  <span>{{ reviewCount }} ulasan</span>
                </div>
              </div>
            </div>

            <div class="flex flex-wrap gap-2 items-center text-sm text-slate-500 mb-6">
              <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-2 text-slate-700">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" /></svg>
                {{ product?.category ?? 'Batik & Kerajinan' }}
              </span>
              <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-2 text-slate-700">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4z" /></svg>
                SKU: {{ product?.sku ?? 'N/A' }}
              </span>
            </div>

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Harga</p>
                <p class="text-4xl font-black text-slate-900">Rp {{ formatCurrency(displayPrice) }}</p>
              </div>
              <div class="rounded-3xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">Stok tersedia: {{ selectedStock }}</div>
            </div>

            <div class="space-y-4">
              <div v-if="variantOptions.length" class="grid gap-4 sm:grid-cols-2">
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Varian</label>
                  <select v-model="selectedVariantId" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                    <option
                      v-for="variant in variantOptions"
                      :key="variant.value"
                      :value="variant.value"
                    >
                      {{ variant.label }} - Rp {{ formatCurrency(variant.price) }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="grid gap-4 sm:grid-cols-[1fr_auto] items-end">
                <div class="flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-100 p-3">
                  <button type="button" @click="decrementQuantity" class="rounded-2xl bg-white p-2 text-slate-700 transition hover:bg-slate-200">-</button>
                  <input type="number" v-model.number="quantity" min="1" :max="selectedStock" class="w-20 rounded-3xl border border-slate-200 bg-white px-4 py-3 text-center text-slate-900" />
                  <button type="button" @click="incrementQuantity" class="rounded-2xl bg-white p-2 text-slate-700 transition hover:bg-slate-200">+</button>
                </div>
                <div class="text-sm text-slate-500">Max {{ selectedStock }} pcs</div>
              </div>

              <div class="grid gap-3 sm:grid-cols-2">
                <button
                  type="button"
                  @click="addToCart"
                  :disabled="!canAddToCart"
                  class="rounded-3xl bg-slate-900 px-5 py-4 text-sm font-black text-white transition hover:bg-black disabled:cursor-not-allowed disabled:opacity-60"
                >
                  Tambah ke Keranjang
                </button>
                <button
                  type="button"
                  @click="buyNow"
                  :disabled="!canAddToCart"
                  class="rounded-3xl bg-orange-500 px-5 py-4 text-sm font-black text-white transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                  Beli Sekarang
                </button>
              </div>

              <div class="grid gap-3 sm:grid-cols-2">
                <button
                  type="button"
                  @click="toggleWishlist"
                  class="rounded-3xl border border-slate-200 bg-white px-5 py-4 text-sm font-black text-slate-900 transition hover:bg-slate-100"
                >
                  {{ isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}
                </button>
                <button
                  type="button"
                  @click="showArModal = true"
                  class="rounded-3xl border border-orange-200 bg-orange-50 px-5 py-4 text-sm font-black text-orange-700 transition hover:bg-orange-100"
                >
                  AR Try-On
                </button>
              </div>
            </div>

            <div class="mt-6 space-y-3 text-slate-600 text-sm">
              <button type="button" @click="shareProduct" class="inline-flex items-center gap-2 text-slate-700 hover:text-slate-900">
                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M15 8a3 3 0 10-2.83-4H7.83A3 3 0 105 8c0 .19.02.38.06.56L3.3 10.4a3 3 0 101.2 1.2l1.8-1.54A3.02 3.02 0 008 11a3 3 0 103 3 2.99 2.99 0 00-1.68-.57l-1.8 1.54a3 3 0 10.55 1.18l1.75-1.5a3.02 3.02 0 001.83.64A3 3 0 1015 8z"/></svg>
                Bagikan produk
              </button>
              <p class="text-xs text-slate-400">Link ini akan tersalin ke clipboard jika share API tidak tersedia.</p>
            </div>
          </div>

          <div class="rounded-[2rem] bg-white p-6 shadow-sm border border-slate-200">
            <div class="mb-4 flex items-center gap-3">
              <div class="flex items-center gap-1">
                <template v-for="i in 5" :key="i">
                  <svg class="w-4 h-4" fill="currentColor" :class="i <= Math.round(product?.rating ?? product?.average_rating ?? 0) ? 'text-amber-400' : 'text-slate-200'" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                </template>
              </div>
              <div>
                <p class="text-sm font-semibold text-slate-900">Rating & Ulasan</p>
                <p class="text-sm text-slate-500">{{ reviewCount }} ulasan pelanggan</p>
              </div>
            </div>
            <div v-if="reviews.length" class="space-y-4">
              <div v-for="review in reviews.slice(0, 3)" :key="review.id" class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between gap-4 mb-3">
                  <div>
                    <p class="font-semibold text-slate-900">{{ review.author ?? review.user_name ?? 'Pembeli' }}</p>
                    <p class="text-xs text-slate-500">{{ formatDate(review.date ?? review.created_at) }}</p>
                  </div>
                  <div class="inline-flex items-center gap-1 text-amber-400">
                    <template v-for="i in 5" :key="i">
                      <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" :class="i <= (review.rating ?? 0) ? 'text-amber-400' : 'text-slate-200'"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                    </template>
                  </div>
                </div>
                <p class="text-slate-700">{{ review.comment ?? review.message ?? 'Ulasan tidak tersedia.' }}</p>
              </div>
            </div>
            <p v-else class="text-sm text-slate-500">Belum ada ulasan untuk produk ini.</p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="showArModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4">
      <div class="w-full max-w-2xl rounded-[2rem] bg-white p-8 shadow-2xl">
        <div class="flex items-start justify-between gap-4">
          <div>
            <h2 class="text-2xl font-black text-slate-900">AR Try-On</h2>
            <p class="mt-2 text-slate-600">Coba produk secara virtual dengan pengalaman AR. Aktifkan kamera dan lihat tampilan produk di ruangan Anda.</p>
          </div>
          <button type="button" @click="showArModal = false" class="rounded-full bg-slate-100 p-3 text-slate-700 hover:bg-slate-200">
            ✕
          </button>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">
          <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-center">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-orange-100 text-orange-700 text-2xl">AR</div>
            <p class="mt-4 text-sm font-semibold text-slate-900">Live preview</p>
            <p class="mt-2 text-sm text-slate-500">Aktifkan kamera perangkat untuk melihat produk secara virtual.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 bg-white p-6">
            <p class="text-sm font-semibold text-slate-900">Petunjuk</p>
            <ol class="mt-3 space-y-2 text-sm text-slate-600 list-decimal list-inside">
              <li>Buka kamera perangkat</li>
              <li>Arahkan ke permukaan rata</li>
              <li>Tempatkan produk di visualisasi</li>
            </ol>
          </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
          <button type="button" @click="showArModal = false" class="rounded-3xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-100">Tutup</button>
          <button type="button" class="rounded-3xl bg-orange-500 px-5 py-3 text-sm font-bold text-white hover:bg-orange-600">Mulai AR Try-On</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';
import { useWishlistStore } from '@/stores/wishlistStore';
import { useNotificationStore } from '@/stores/notificationStore';

const route = useRoute();
const router = useRouter();
const cartStore = useCartStore();
const wishlistStore = useWishlistStore();
const notificationStore = useNotificationStore();

const product = ref(null);
const isLoading = ref(true);
const error = ref('');
const quantity = ref(1);
const activeImageIndex = ref(0);
const showArModal = ref(false);
const relatedProducts = ref([]);
const variantOptions = ref([]);
const selectedVariantId = ref(null);

const fetchJson = async (url) => {
  const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
  if (!res.ok) throw new Error('Gagal memuat data');
  const payload = await res.json();
  return payload?.data ?? payload;
};

const safeParseArray = (value) => {
  if (!value) return [];
  if (Array.isArray(value)) return value;
  try {
    return JSON.parse(value);
  } catch {
    return [value];
  }
};

const normalizeProduct = (raw) => {
  const item = raw?.product ?? raw;
  const images = safeParseArray(item.images ?? item.gallery ?? item.image_url ?? []).filter(Boolean);
  const variants = Array.isArray(item.variants) ? item.variants : [];
  const reviews = Array.isArray(item.reviews) ? item.reviews : [];

  return {
    id: item.id,
    name: item.name ?? item.title ?? 'Produk Batik & Kerajinan',
    price: item.price ?? item.base_price ?? 0,
    description: item.description ?? item.detail ?? 'Deskripsi produk tidak tersedia.',
    category: item.category ?? item.type ?? 'Batik & Kerajinan',
    sku: item.sku ?? item.code ?? 'N/A',
    rating: item.rating ?? item.average_rating ?? 0,
    average_rating: item.average_rating ?? item.rating ?? 0,
    reviews,
    seller: item.seller ?? {
      name: item.seller_name,
      location: item.seller_location,
    },
    seller_name: item.seller_name,
    seller_location: item.seller_location,
    images: images.length ? images : ['/images/placeholder-product.png'],
    stock: Math.max(1, item.stock ?? item.quantity ?? 999),
    variants,
  };
};

const loadProduct = async () => {
  isLoading.value = true;
  error.value = '';

  try {
    const id = route.params.id;
    const payload = await fetchJson(`/api/v1/products/${id}`);
    const normalized = normalizeProduct(payload);

    product.value = normalized;
    activeImageIndex.value = 0;
    variantOptions.value = normalized.variants.map((variant, idx) => {
      const labelParts = [variant.name, variant.size, variant.color].filter(Boolean);
      return {
        value: variant.id ?? idx,
        label: labelParts.length ? labelParts.join(' - ') : `Varian ${idx + 1}`,
        price: variant.price ?? normalized.price,
        stock: Math.max(1, variant.stock ?? normalized.stock ?? 999),
        raw: variant,
      };
    });

    if (variantOptions.value.length) {
      selectedVariantId.value = variantOptions.value[0].value;
    }

    const related = await fetchJson('/api/v1/products');
    const list = Array.isArray(related) ? related : related.data ?? [];
    relatedProducts.value = list
      .filter((item) => item?.id && item.id !== normalized.id)
      .slice(0, 4)
      .map((item) => normalizeProduct(item));
  } catch (err) {
    console.error(err);
    error.value = 'Gagal memuat data produk. Silakan coba lagi.';
  } finally {
    isLoading.value = false;
  }
};

const galleryImages = computed(() => product.value?.images ?? []);
const activeImage = computed(() => galleryImages.value[activeImageIndex.value] ?? '');
const currentImageLabel = computed(() => `${activeImageIndex.value + 1}/${galleryImages.value.length}`);
const selectedVariant = computed(() => variantOptions.value.find((variant) => variant.value === selectedVariantId.value));
const displayPrice = computed(() => selectedVariant.value?.price ?? product.value?.price ?? 0);
const selectedStock = computed(() => {
  const stock = selectedVariant.value?.stock ?? product.value?.stock ?? 0;
  return Math.max(1, stock);
});
const reviews = computed(() => product.value?.reviews ?? []);
const reviewCount = computed(() => reviews.value.length);
const canAddToCart = computed(() => selectedStock.value > 0 && !isLoading.value);
const isWishlisted = computed(() => wishlistStore.isWishlisted(product.value?.id));

const formatCurrency = (value) => {
  const number = Number(value ?? 0);
  return number.toLocaleString('id-ID');
};

const formatDate = (value) => {
  if (!value) return '-';
  const date = new Date(value);
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};

const incrementQuantity = () => {
  const maxStock = selectedStock.value || product.value?.stock || 1;
  if (quantity.value < maxStock) {
    quantity.value += 1;
  }
};

const decrementQuantity = () => {
  if (quantity.value > 1) {
    quantity.value -= 1;
  }
};

const addToCart = async () => {
  if (!product.value) {
    notificationStore.error('Produk tidak ditemukan');
    return;
  }
  const variant = selectedVariant.value?.label ?? null;
  await cartStore.addItem(product.value, quantity.value, variant);
  notificationStore.success('Berhasil menambahkan ke keranjang', 3000, 'Success');
};

const buyNow = async () => {
  if (!product.value) {
    notificationStore.error('Produk tidak ditemukan');
    return;
  }
  const variant = selectedVariant.value?.label ?? null;
  await cartStore.addItem(product.value, quantity.value, variant);
  notificationStore.success('Membuka checkout...');
  setTimeout(() => router.push({ path: '/marketplace/checkout', query: { source: 'buy-now' } }), 400);
};

const toggleWishlist = async () => {
  if (!product.value) return;

  if (wishlistStore.isWishlisted(product.value.id)) {
    await wishlistStore.removeItem(product.value.id);
    notificationStore.success('Produk dihapus dari wishlist', 3000, 'Success');
    return;
  }

  await wishlistStore.addItem(product.value);
  notificationStore.success('Produk ditambahkan ke wishlist', 3000, 'Success');
};

const shareProduct = async () => {
  const shareData = {
    title: product.value.name,
    text: 'Lihat produk batik menarik di SnapFit Marketplace',
    url: window.location.href,
  };

  try {
    if (navigator.share) {
      await navigator.share(shareData);
      return;
    }
  } catch (err) {
    console.warn('Share API gagal:', err);
  }

  await navigator.clipboard.writeText(window.location.href);
  window.alert('Link produk berhasil disalin ke clipboard.');
};

const refreshRelated = async () => {
  await loadProduct();
};

watch(
  () => route.params.id,
  async () => {
    await loadProduct();
  }
);

onMounted(async () => {
  await wishlistStore.loadWishlist();
  await loadProduct();
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
