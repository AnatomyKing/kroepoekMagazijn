<script setup>
import { computed, ref, onMounted } from 'vue';
import HomeProductenTegels from './HomeProductenTegels.vue';
import HomeProductenTegelsBinnenIn from './HomeProductenTegelsBinnenIn.vue';
import HomeProductenVideoEmbed from './HomeProductenVideoEmbed.vue';

const page = {
    title: 'Producten',
    description: 'Bekijk en reserveer beschikbare apparatuur',
};

const categories = ref(['Alle']); // Dynamisch uit database
const allItems = ref([]); // Alle items uit database
const search = ref('');
const category = ref('Alle');
const selectedProduct = ref(null);
const selectedVideoProduct = ref(null);
const videoModalOpen = ref(false);

// Haal producten op uit de database
async function fetchProducts() {
    try {
        const response = await fetch('/api/items', {
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
        });
        if (!response.ok) throw new Error('Netwerkfout');
        const data = await response.json();

        // Filter alleen items met voorraad > 0 (beschikbaar)
        const availableItems = data.filter(
            (item) => item.quantity_available > 0,
        );

        // Converteer database-objecten naar het formaat dat de template verwacht
        allItems.value = availableItems.map((item) => ({
            id: item.id,
            name: item.item_name,
            type: item.category || 'Overig', // gebruik categorie als type
            info: item.description || '',
            category: item.category || 'Overig',
            available: item.quantity_available,
            enabled: true,
            image: item.image ? `/storage/${item.image}` : null,
            images: item.image ? [`/storage/${item.image}`] : [], // carousel heeft een array nodig
            youtubeVideo: null, // kan later toegevoegd worden via extra veld
        }));

        // Bouw dynamische categorieënlijst (exclusief 'Alle')
        const uniqueCategories = [
            ...new Set(allItems.value.map((p) => p.category)),
        ].filter(Boolean);
        categories.value = ['Alle', ...uniqueCategories];
    } catch (err) {
        console.error('Fout bij laden producten:', err);
        allItems.value = [];
    }
}

// Zichtbare producten op basis van zoekterm en geselecteerde categorie
const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();
    return allItems.value.filter((product) => {
        const fields = [
            product.name,
            product.type,
            product.info,
            product.category,
        ];
        return (
            (category.value === 'Alle' ||
                product.category === category.value) &&
            (!query ||
                fields.some((field) => field?.toLowerCase().includes(query)))
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

onMounted(() => {
    fetchProducts();
});
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

    <UContainer v-else class="px-3 pt-[clamp(28px,6vw,61px)] pb-14 sm:px-5">
        <UPageHeader
            v-bind="page"
            :ui="{
                root: 'border-0 py-0',
                container: 'px-0',
                title: 'text-[clamp(38px,7vw,40px)] font-bold leading-tight tracking-[-0.03em] text-black',
                description:
                    'mt-2 text-[clamp(18px,4vw,20px)] font-normal leading-snug tracking-wide text-magazijn-gray',
            }"
        />

        <section
            class="mt-[clamp(26px,6vw,39px)] flex flex-wrap items-center gap-[10px]"
        >
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek producten..."
                variant="outline"
                size="xl"
                class="min-w-[min(100%,360px)] flex-[999_1_360px]"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    leadingIcon: 'text-magazijn-gray',
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
                        : 'bg-magazijn-white text-magazijn-gray hover:bg-magazijn-white',
                ]"
                :ui="{
                    base: 'focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
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
                body: 'p-0 sm:p-0',
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
