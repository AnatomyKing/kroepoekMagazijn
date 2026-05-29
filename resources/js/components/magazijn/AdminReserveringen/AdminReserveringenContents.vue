<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';
import { computed, ref } from 'vue';
const page = {
    title: 'Reserveringen overzicht',
    description: 'Bekijk alle uitgeschreven producten',
};

defineProps({
    product: Object,
});

type Product = {
    id: number;
    name: string;
    type: string;
    info: string;
    category: string;
    available: number;
    enabled: boolean;
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
        available: 0,
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
        available: 0,
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
const selectedProduct = ref(null);
const isModalOpen = ref(false);
const editingProduct = ref<Product | null>(null);
const isCreating = ref(false);
const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();

    return products.filter((product) => {
        const categoryMatches =
            category.value === 'Alle' || product.category === category.value;

        const searchMatches =
            !query ||
            [product.name, product.type, product.info, product.category].some(
                (value) => value.toLowerCase().includes(query),
            );

        return categoryMatches && searchMatches;
    });
});
</script>

<template>
    <UContainer class="px-3 pt-[clamp(28px,6vw,61px)] pb-14 sm:px-5">
        <div class="flex items-start justify-between gap-4">
            <UPageHeader
                v-bind="page"
                :ui="{
                    root: 'border-0 py-0',
                    container: 'px-0 sm:px-0 lg:px-0',
                    title: 'text-[clamp(38px,7vw,40px)] font-bold leading-tight tracking-[-0.03em] text-black',
                    description:
                        'mt-2 text-[clamp(18px,4vw,20px)] font-normal leading-snug tracking-wide text-magazijn-gray',
                }"
            />
        </div>

        <!-- Stats -->
        <div class="mt-8 grid gap-4 md:grid-cols-4">
            <!-- Totaal -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm font-medium text-neutral-700"
                >
                    <UIcon name="i-lucide-package" class="h-4 w-4" />

                    <span>Totaal</span>
                </div>

                <h2 class="text-5xl leading-none font-semibold">3</h2>
            </div>

            <!-- Actief -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm font-medium text-neutral-700"
                >
                    <UIcon name="i-lucide-clock-3" class="h-4 w-4" />

                    <span>Actief</span>
                </div>

                <h2 class="text-5xl leading-none font-semibold">1</h2>
            </div>

            <!-- Teruggebracht -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm font-medium text-neutral-700"
                >
                    <UIcon name="i-lucide-check-circle-2" class="h-4 w-4" />

                    <span>Teruggebracht</span>
                </div>

                <h2 class="text-5xl leading-none font-semibold">1</h2>
            </div>

            <!-- Te laat -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm font-medium text-neutral-700"
                >
                    <UIcon name="i-lucide-alert-circle" class="h-4 w-4" />

                    <span>Te laat</span>
                </div>

                <h2 class="text-5xl leading-none font-semibold">1</h2>
            </div>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-[1fr_240px_240px]">
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek een reservering"
                variant="outline"
                size="xl"
                class="min-w-[min(100%,360px)] flex-[999_1_360px]"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    leadingIcon: 'text-magazijn-gray',
                }"
            />

            <select
                class="mt-1 h-12 rounded-md border border-neutral-200 bg-white px-4 outline-none"
            >
                <option>Alle statussen</option>
            </select>
            <!-- <USelect v-model="value" :items="items" class="w-48" /> -->

            <select
                class="mt-1 h-12 rounded-md border border-neutral-200 bg-white px-4 outline-none"
            >
                <option>Deze maand</option>
            </select>
        </div>

        <UCard
            class="mt-8"
            variant="outline"
            :ui="{
                root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
                body: 'p-0 sm:p-0',
            }"
        >
            <div class="flex items-center justify-between px-5 py-4">
                <!-- Left -->
                <div class="flex items-center gap-5">
                    <div class="h-16 w-16 rounded-[18px] bg-magazijn-purple" />

                    <div>
                        <h2 class="text-lg font-semibold text-black">naam</h2>

                        <p class="text-sm text-magazijn-gray">Product</p>
                    </div>
                </div>
                

                <!-- Right -->
                <div class="flex items-center gap-5">
                    <!-- Status -->
                    <span>
                        <StatusBadge></StatusBadge>
                    </span>
                </div>
            </div>
        </UCard>
        <UCard
            class="mt-8"
            variant="outline"
            :ui="{
                root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
                body: 'p-0 sm:p-0',
            }"
        >
            <div class="flex items-center justify-between px-5 py-4">
                <!-- Left -->
                <div class="flex items-center gap-5">
                    <div class="h-16 w-16 rounded-[18px] bg-magazijn-purple" />

                    <div>
                        <h2 class="text-lg font-semibold text-black">naam</h2>

                        <p class="text-sm text-magazijn-gray">Product</p>
                    </div>
                </div>
                

                <!-- Right -->
                <div class="flex items-center gap-5">
                    <!-- Status -->
                    <span>
                        <StatusBadge></StatusBadge>
                    </span>
                </div>
            </div>
        </UCard>
    </UContainer>
</template>

<style scoped></style>
