import { createApp } from 'vue';
import ui from '@nuxt/ui/vue-plugin';
import AdminReserveringen from './components/magazijn/AdminReserveringen/AdminReserveringen.vue';

createApp(AdminReserveringen)
    .use(ui)
    .mount('#app');
