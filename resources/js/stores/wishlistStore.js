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

  const toggleWishlist = async (product) => {
    if (!product || !product.id) return;

    // Optimistic UI Update
    const exists = isWishlisted(product.id);
    if (exists) {
      items.value = items.value.filter(item => item.product_id !== product.id);
    } else {
      items.value.push({
        id: null,
        product_id: product.id,
        product: product,
        created_at: new Date().toISOString(),
      });
    }
    saveToLocalStorage();

    // Sync to Backend
    const token = localStorage.getItem('token');
    if (token) {
      try {
        const response = await fetch(`/api/v1/wishlist/${product.id}/toggle`, {
          method: 'POST',
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json',
          },
        });
        
        if (!response.ok) {
          console.warn('Failed to toggle wishlist on backend');
          // Reload from backend to sync state on failure
          loadWishlist();
        }
      } catch (err) {
        console.error('Wishlist toggle error:', err);
      }
    }
  };

  return {
    items,
    isLoading,
    error,
    count,
    isWishlisted,
    loadWishlist,
    toggleWishlist,
  };
});
