import { createApp } from 'vue';
import ui from '@nuxt/ui/vue-plugin';
import NuxtUiBladeTest from './components/magazijn/NuxtUiBladeTest.vue';

createApp(NuxtUiBladeTest)
    .use(ui)
    .mount('#app');
