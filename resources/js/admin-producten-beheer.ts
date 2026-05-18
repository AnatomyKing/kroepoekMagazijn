import { createApp } from 'vue';
import ui from '@nuxt/ui/vue-plugin';
import AdminProductenBeheer from './components/magazijn/AdminProductenBeheer/AdminProductenBeheer.vue';

createApp(AdminProductenBeheer)
    .use(ui)
    .mount('#app');
