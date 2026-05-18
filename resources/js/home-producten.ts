import { createApp } from 'vue';
import ui from '@nuxt/ui/vue-plugin';
import HomeProducten from './components/magazijn/HomeProducten/HomeProducten.vue';

createApp(HomeProducten)
    .use(ui)
    .mount('#app');
