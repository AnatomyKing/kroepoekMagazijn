<script setup>
import { computed, ref } from 'vue';
import HomeProductenTegels from './HomeProductenTegels.vue';
import HomeProductenTegelsBinnenIn from './HomeProductenTegelsBinnenIn.vue';
import HomeProductenVideoEmbed from './HomeProductenVideoEmbed.vue';

const page = {
    title: 'Producten',
    description: 'Bekijk en reserveer beschikbare apparatuur',
};

const categories = [
    'Alle',
    'Camera',
    'Audio',
    'Licht',
    'Stabilisatie',
    'Kits',
    'Filters',
];

const products = [
    {
        id: 1,
        name: 'All in one video kit',
        type: 'Video kit',
        info: 'Complete video set',
        category: 'Kits',
        available: 1,
        enabled: true,
        image: '/images/all_in_one_video_kit/DSC07525.JPG',
        images: [
            '/images/all_in_one_video_kit/DSC07524.JPG',
            '/images/all_in_one_video_kit/DSC07526.JPG',
            '/images/all_in_one_video_kit/DSC07527.JPG',
            '/images/all_in_one_video_kit/DSC07528.JPG',
            '/images/all_in_one_video_kit/DSC07529.JPG',
            '/images/all_in_one_video_kit/DSC07530.JPG',
            '/images/all_in_one_video_kit/DSC07531.JPG',
            '/images/all_in_one_video_kit/DSC07532.JPG',
            '/images/all_in_one_video_kit/DSC07534.JPG',
            '/images/all_in_one_video_kit/DSC07561.JPG',
        ],
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 2,
        name: 'Continu licht',
        type: 'Licht',
        info: 'Continu belichting',
        category: 'Licht',
        available: 1,
        enabled: true,
        image: '/images/continu_licht/DSC07550.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 3,
        name: 'LED panel + statief',
        type: 'Lichtset',
        info: 'LED paneel met statief',
        category: 'Licht',
        available: 1,
        enabled: true,
        image: '/images/led_paneel_statief/DSC07564.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 4,
        name: 'Microfoon',
        type: 'Microfoon',
        info: 'Audio opname',
        category: 'Audio',
        available: 1,
        enabled: true,
        image: '/images/microfoon/DSC07545.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 5,
        name: 'Mobile Gimbal',
        type: 'Gimbal',
        info: 'Stabilisatie voor mobiel',
        category: 'Stabilisatie',
        available: 1,
        enabled: true,
        image: '/images/mobile_gimbal/DSC07520.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 6,
        name: 'Osmo Pocket',
        type: 'Pocket camera',
        info: 'Compacte camera',
        category: 'Camera',
        available: 1,
        enabled: true,
        image: '/images/osmo_pocket/DSC07505.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 7,
        name: 'Reportage filter FILTERS',
        type: 'Filter',
        info: 'Reportage filter set',
        category: 'Filters',
        available: 1,
        enabled: true,
        image: '/images/reportage_flitser_filters/DSC07507.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 8,
        name: 'RGB continu licht paneel',
        type: 'RGB licht',
        info: 'RGB continu licht paneel',
        category: 'Licht',
        available: 1,
        enabled: true,
        image: '/images/rgb_continue_licht_paneel/DSC07555.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 9,
        name: 'RGB tube, magnetisch',
        type: 'RGB tube',
        info: 'Magnetische RGB licht tube',
        category: 'Licht',
        available: 1,
        enabled: true,
        image: '/images/rgb_tube_magnetisch/DSC07552.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 10,
        name: 'Sony set ZV-E10',
        type: 'Camera set',
        info: 'Sony ZV-E10 camera set',
        category: 'Camera',
        available: 1,
        enabled: true,
        image: '/images/sony_set_zv_e10/DSC07510.JPG',
        youtubeVideo: 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
    },
    {
        id: 11,
        name: 'Wireless ME',
        type: 'Draadloze microfoon',
        info: 'Wireless audio set',
        category: 'Audio',
        available: 1,
        enabled: true,
        image: '/images/wireless_me/DSC07538.JPG',
    },
];

const search = ref('');
const category = ref('Alle');
const selectedProduct = ref(null);
const selectedVideoProduct = ref(null);
const videoModalOpen = ref(false);

const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();

    return products.filter((product) => {
        const fields = [product.name, product.type, product.info, product.category];

        return (
            (category.value === 'Alle' || product.category === category.value) &&
            (!query || fields.some((field) => field.toLowerCase().includes(query)))
        );
    });
});

function scrollTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function openProduct(product) {
    selectedProduct.value = product;
    scrollTop();
}

function closeProduct() {
    selectedProduct.value = null;
    scrollTop();
}

function openVideo(product) {
    selectedVideoProduct.value = product;
    videoModalOpen.value = true;
}

function closeVideo() {
    videoModalOpen.value = false;
}
</script>

<template>
    <HomeProductenVideoEmbed
        v-model:open="videoModalOpen"
        :product="selectedVideoProduct"
        @close="closeVideo"
    />

    <HomeProductenTegelsBinnenIn
        v-if="selectedProduct"
        :product="selectedProduct"
        @back="closeProduct"
        @play-video="openVideo"
    />

    <UContainer
        v-else
        class="px-3 pb-14 pt-[clamp(28px,6vw,61px)] sm:px-5"
    >
        <UPageHeader
            v-bind="page"
            :ui="{
                root: 'border-0 py-0',
                container: 'px-0',
                title: 'text-[clamp(38px,7vw,40px)] font-bold leading-tight tracking-[-0.03em] text-black',
                description: 'mt-2 text-[clamp(18px,4vw,20px)] font-normal leading-snug tracking-wide text-magazijn-gray'
            }"
        />

        <section class="mt-[clamp(26px,6vw,39px)] flex flex-wrap items-center gap-[10px]">
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek producten..."
                variant="outline"
                size="xl"
                class="min-w-[min(100%,360px)] flex-[999_1_360px]"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    leadingIcon: 'text-magazijn-gray'
                }"
            />

            <UButton
                v-for="item in categories"
                :key="item"
                variant="ghost"
                size="xl"
                :class="[
                    'h-[46px] rounded-[10px] px-[clamp(18px,5vw,23px)] text-[16px] font-semibold shadow-sm ring-1 ring-magazijn-purple-soft',
                    category === item
                        ? 'bg-magazijn-purple text-magazijn-white hover:bg-magazijn-purple'
                        : 'bg-magazijn-white text-magazijn-gray hover:bg-magazijn-white'
                ]"
                :ui="{ base: 'focus-visible:ring-2 focus-visible:ring-magazijn-purple' }"
                @click="category = item"
            >
                {{ item }}
            </UButton>
        </section>

        <div
            v-if="visibleProducts.length"
            class="mt-[clamp(34px,7vw,48px)] grid grid-cols-[repeat(auto-fit,minmax(min(100%,280px),1fr))] gap-x-[41px] gap-y-[37px]"
        >
            <HomeProductenTegels
                v-for="product in visibleProducts"
                :key="product.id"
                :product="product"
                @select="openProduct"
                @play-video="openVideo"
            />
        </div>

        <UCard
            v-else
            class="mt-[48px] bg-magazijn-white"
            :ui="{
                root: 'rounded-[10px] ring-1 ring-magazijn-purple-soft',
                body: 'p-0 sm:p-0'
            }"
        >
            <div class="py-10 text-center">
                <p class="text-lg font-semibold text-magazijn-purple">
                    Geen producten gevonden
                </p>

                <p class="mt-1 text-sm text-magazijn-gray">
                    Pas je zoekterm of categorie aan.
                </p>
            </div>
        </UCard>
    </UContainer>
</template>
