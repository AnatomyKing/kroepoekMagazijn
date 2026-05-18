import { createApp } from 'vue';
import ui from '@nuxt/ui/vue-plugin';
import MijnReserveringen from './components/magazijn/MijnReserveringen/MijnReserveringen.vue';

createApp(MijnReserveringen)
    .use(ui)
    .mount('#app');
