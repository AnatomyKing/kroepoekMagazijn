<script setup>
import { computed, ref } from 'vue';
import HomeProductenTegels from './HomeProductenTegels.vue';

const page = {
    title: 'Producten',
    description: 'Bekijk en reserveer beschikbare apparatuur',
};

const categories = [
    'Alle',
    'Camera',
    'Audio',
    'Accu',
    'Rugzak',
    'Kits',
    'Overig',
];

const products = [
    {
        id: 1,
        name: 'Canon EOS R50',
        type: 'Camera',
        info: 'Systeemcamera',
        category: 'Camera',
        available: 4,
    },
    {
        id: 2,
        name: 'Sony FX30',
        type: 'Camera',
        info: 'Cinema camera',
        category: 'Camera',
        available: 1,
    },
    {
        id: 3,
        name: 'GoPro Hero 12',
        type: 'Camera',
        info: 'Action camera',
        category: 'Camera',
        available: 3,
    },
    {
        id: 4,
        name: 'Rode NTG2',
        type: 'Microfoon',
        info: 'Shotgun audio',
        category: 'Audio',
        available: 2,
    },
    {
        id: 5,
        name: 'Zoom H5',
        type: 'Recorder',
        info: 'Audio opname',
        category: 'Audio',
        available: 2,
    },
    {
        id: 6,
        name: 'Sony Koptelefoon',
        type: 'Headset',
        info: 'Monitoring',
        category: 'Audio',
        available: 6,
    },
    {
        id: 7,
        name: 'NP-FZ100',
        type: 'Accu',
        info: 'Sony batterij',
        category: 'Accu',
        available: 5,
    },
    {
        id: 8,
        name: 'LP-E17',
        type: 'Accu',
        info: 'Canon batterij',
        category: 'Accu',
        available: 4,
    },
    {
        id: 9,
        name: 'USB-C Powerbank',
        type: 'Accu',
        info: 'Extra stroom',
        category: 'Accu',
        available: 7,
    },
    {
        id: 10,
        name: 'Lowepro Tas',
        type: 'Rugzak',
        info: 'Camera rugzak',
        category: 'Rugzak',
        available: 3,
    },
    {
        id: 11,
        name: 'Manfrotto Bag',
        type: 'Rugzak',
        info: 'Statief tas',
        category: 'Rugzak',
        available: 2,
    },
    {
        id: 12,
        name: 'Interview Kit',
        type: 'Kit',
        info: 'Camera + audio',
        category: 'Kits',
        available: 2,
    },
    {
        id: 13,
        name: 'Vlog Kit',
        type: 'Kit',
        info: 'Camera set',
        category: 'Kits',
        available: 4,
    },
    {
        id: 14,
        name: 'Studio Licht Kit',
        type: 'Kit',
        info: 'Lampenset',
        category: 'Kits',
        available: 1,
    },
    {
        id: 15,
        name: 'HDMI Kabel',
        type: 'Accessoire',
        info: 'Video kabel',
        category: 'Overig',
        available: 8,
    },
    {
        id: 16,
        name: 'SD Kaartlezer',
        type: 'Accessoire',
        info: 'Bestanden lezen',
        category: 'Overig',
        available: 5,
    },
];

const search = ref('');
const category = ref('Alle');

const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();

    return products.filter((product) => {
        const categoryMatches =
            category.value === 'Alle' || product.category === category.value;

        const searchMatches =
            !query ||
            [product.name, product.type, product.info, product.category].some((value) =>
                value.toLowerCase().includes(query)
            );

        return categoryMatches && searchMatches;
    });
});
</script>

<template>
    <UContainer class="px-3 pb-14 pt-[clamp(28px,6vw,61px)] sm:px-5">
        <UPageHeader
            v-bind="page"
            :ui="{
                root: 'border-0 py-0',
                container: 'px-0 sm:px-0 lg:px-0',
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
                    'h-[46px] justify-center rounded-[10px] border-0 px-[clamp(18px,5vw,23px)] text-[16px] font-semibold shadow-sm ring-1 ring-magazijn-purple-soft',
                    category === item
                        ? 'bg-magazijn-purple text-magazijn-white hover:bg-magazijn-purple'
                        : 'bg-magazijn-white text-magazijn-gray hover:bg-magazijn-white hover:text-magazijn-gray'
                ]"
                :ui="{
                    base: 'overflow-visible focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    label: 'overflow-visible whitespace-nowrap'
                }"
                @click="category = item"
            >
                <span class="whitespace-nowrap">
                    {{ item }}
                </span>
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
            />
        </div>

        <UCard
            v-else
            variant="outline"
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
