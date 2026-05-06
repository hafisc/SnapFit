import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App    from './App.vue';
import router from './router/index.js';
import Lenis from 'lenis';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Global styles
import '../css/app.css';

// Initialize Lenis for smooth scrolling
const lenis = new Lenis({
  autoRaf: true,
  duration: 1.2,
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
});

// Initialize AOS (Animate On Scroll)
AOS.init({
  once: false, // Animates every time you scroll up/down
  mirror: true, // Animates out while scrolling past them
  duration: 800,
  offset: 50,
  easing: 'ease-out-cubic',
});

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount('#app');
