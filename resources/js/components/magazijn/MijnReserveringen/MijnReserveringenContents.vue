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

const productSeed = [
    ['Camera', 4],
    ['Audio', 2],
    ['Accu', 1],
    ['Rugzak', 6],
    ['Kits', 4],
    ['Overig', 2],
    ['Camera', 1],
    ['Audio', 6],
];

const products = productSeed.map(([category, available], index) => ({
    id: index + 1,
    name: 'Naam',
    type: 'Item',
    info: 'Informatie',
    category,
    available,
}));

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
    <UContainer class="pb-14 pt-[46px]">
        <UPageHeader
            v-bind="page"
            :ui="{
                root: 'border-0 py-0',
                container: 'px-0 sm:px-0 lg:px-0',
                title: 'text-[34px] font-semibold leading-none tracking-[-0.02em] text-black',
                description: 'mt-3 text-[16px] font-normal tracking-wide text-magazijn-gray'
            }"
        />

        <section class="mt-7 flex flex-col gap-4 lg:flex-row lg:items-center">
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek producten..."
                variant="outline"
                size="md"
                class="w-full lg:w-[440px]"
                :ui="{
                    base: 'h-[38px] rounded-lg bg-magazijn-white text-[13px] text-magazijn-purple ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                }"
            />

            <div class="flex flex-wrap items-center gap-2">
                <UButton
                    v-for="item in categories"
                    :key="item"
                    :label="item"
                    variant="outline"
                    size="md"
                    :class="[
                        'h-[38px] min-w-[58px] justify-center rounded-lg border px-4 text-[13px] font-semibold shadow-sm',
                        category === item
                            ? 'border-magazijn-purple bg-magazijn-purple text-magazijn-white hover:bg-magazijn-purple'
                            : 'border-magazijn-purple-soft bg-magazijn-white text-magazijn-gray hover:bg-magazijn-purple-soft hover:text-magazijn-purple'
                    ]"
                    @click="category = item"
                />
            </div>
        </section>

        <UPageGrid
            v-if="visibleProducts.length"
            class="mt-[38px] grid-cols-1 gap-x-8 gap-y-[30px] sm:grid-cols-2 lg:grid-cols-4"
        >
            <HomeProductenTegels
                v-for="product in visibleProducts"
                :key="product.id"
                :product="product"
            />
        </UPageGrid>

        <UCard
            v-else
            variant="outline"
            class="mt-[38px] bg-magazijn-white"
            :ui="{
                root: 'rounded-lg ring-1 ring-magazijn-purple-soft',
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
