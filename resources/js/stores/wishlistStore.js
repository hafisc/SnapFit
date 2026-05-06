import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useWishlistStore = defineStore('wishlist', () => {
  const items = ref([]);
  const isLoading = ref(false);
  const error = ref('');

  const count = computed(() => items.value.length);

  const saveToLocalStorage = () => {
    localStorage.setItem('snapfit_wishlist', JSON.stringify(items.value));
  };

  const findItemByProductId = (productId) => {
    return items.value.find(item => item.product_id === productId);
  };

  const isWishlisted = (productId) => {
    return productId != null && items.value.some(item => item.product_id === productId);
  };

  const normalizeBackendItem = (raw) => {
    const item = raw.product ?? raw;
    return {
      id: raw.id,
      product_id: raw.product_id ?? item.id,
      product: item,
      created_at: raw.created_at,
    };
  };

  const loadWishlist = async () => {
    isLoading.value = true;
    error.value = '';

    try {
      const stored = localStorage.getItem('snapfit_wishlist');
      if (stored) {
        const parsed = JSON.parse(stored);
        if (Array.isArray(parsed)) {
          items.value = parsed;
        }
      }

      const token = localStorage.getItem('token');
      if (!token) return;

      const response = await fetch('/api/v1/wishlist', {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      });

      if (!response.ok) {
        console.warn('Failed to load wishlist from backend');
        return;
      }

      const data = await response.json();
      const fetched = Array.isArray(data) ? data : data.data ?? [];
      items.value = fetched.map(normalizeBackendItem);
      saveToLocalStorage();
    } catch (err) {
      console.error('Failed to load wishlist:', err);
      error.value = 'Gagal memuat wishlist';
    } finally {
      isLoading.value = false;
    }
  };

  const syncAddToBackend = async (productId) => {
    const token = localStorage.getItem('token');
    if (!token) return;

    try {
      const response = await fetch('/api/v1/wishlist', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify({ product_id: productId }),
      });

      if (!response.ok) {
        console.warn('Failed to add wishlist item to backend');
        return;
      }

      const data = await response.json();
      const record = data.data ?? data;
      const existing = findItemByProductId(productId);
      if (existing) {
        existing.id = record.id ?? existing.id;
        existing.product_id = record.product_id ?? existing.product_id;
        existing.product = record.product ?? existing.product;
        saveToLocalStorage();
      }
    } catch (err) {
      console.error('Wishlist add sync error:', err);
    }
  };

  const syncRemoveFromBackend = async (wishlistId) => {
    const token = localStorage.getItem('token');
    if (!token || !wishlistId) return;

    try {
      await fetch(`/api/v1/wishlist/${wishlistId}`, {
        method: 'DELETE',
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      });
    } catch (err) {
      console.error('Wishlist remove sync error:', err);
    }
  };

  const addItem = async (product) => {
    if (!product || !product.id) return;

    const existing = findItemByProductId(product.id);
    if (existing) return existing;

    const item = {
      id: null,
      product_id: product.id,
      product,
      created_at: new Date().toISOString(),
    };

    items.value.push(item);
    saveToLocalStorage();
    await syncAddToBackend(product.id);
    return item;
  };

  const removeItem = async (productId) => {
    const existing = findItemByProductId(productId);
    if (!existing) return;

    const wishlistId = existing.id;
    items.value = items.value.filter(item => item.product_id !== productId);
    saveToLocalStorage();
    await syncRemoveFromBackend(wishlistId);
  };

  const toggleWishlist = async (product) => {
    if (!product || !product.id) return;
    if (isWishlisted(product.id)) {
      await removeItem(product.id);
      return;
    }
    await addItem(product);
  };

  return {
    items,
    isLoading,
    error,
    count,
    isWishlisted,
    loadWishlist,
    addItem,
    removeItem,
    toggleWishlist,
  };
});
