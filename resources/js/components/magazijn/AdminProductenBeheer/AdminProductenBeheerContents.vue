<script setup lang="ts">
import { computed, ref } from 'vue';
import AdminProductenBeheerTegels from './AdminProductenBeheerTegels.vue';
import AdminProductenBeheerEdit from './AdminProductenBeheerEdit.vue';

const page = {
    title: 'Producten Beheer',
    description: 'Producten aanmaken, wijzigen en verwijderen',
};
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
function openEdit(product: Product) {
    editingProduct.value = { ...product };
    isCreating.value = false;
    isModalOpen.value = true;
}
function openCreate() {
    editingProduct.value = {
        id: 0,
        name: '',
        type: '',
        info: '',
        category: '',
        available: 0,
        enabled: true,
    };

    isCreating.value = true;
    isModalOpen.value = true;
}
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

            <UButton
                size="xl"
                class="rounded-[10px] bg-magazijn-purple px-5 text-white"
                @click="openCreate"
            >
                + Nieuw Product
            </UButton>
        </div>
        <!-- Search -->
        <section class="mt-8">
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek op product..."
                size="xl"
                class="w-full"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    leadingIcon: 'text-magazijn-gray',
                }"
            />
        </section>

        <!-- Producten -->
        <div class="mt-10 space-y-5">
            <AdminProductenBeheerTegels
                v-for="product in visibleProducts"
                :key="product.id"
                :product="product"
                @edit="openEdit"
            />
        </div>
        <UModal
            :open="isModalOpen"
            :ui="{
        overlay: 'z-[1000]',
        content: 'z-[1001]'
    }"
            @update:open="isModalOpen = $event"
        >
            <template #content>
                <UCard class="w-full max-w-[600px] overflow-y-auto bg-gray-100">
                    <template #header>
                        <h2 class="text-lg font-bold">
                            {{
                                isCreating
                                    ? 'Nieuw product'
                                    : 'Product bewerken'
                            }}
                        </h2>
                    </template>

                    <AdminProductenBeheerEdit
                        v-if="editingProduct"
                        :product="editingProduct"
                        :is-new="isCreating"
                    />
                </UCard>
            </template>
        </UModal>
    </UContainer>
</template>
