<script setup lang="ts">
const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    isNew: Boolean
})

const categories = [
    'Camera',
    'Audio',
    'Accu',
    'Rugzak',
    'Kits',
    'Overig'
]

const quantities = Array.from({ length: 20 }, (_, i) => i + 1)
</script>

<template>
    <div class="space-y-6">

        <!-- Naam -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Naam product
            </label>

            <UInput
                v-model="product.name"
                placeholder="Bijv. Canon EOS R50"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                }"
            />
        </div>

        <!-- Categorie -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Categorie
            </label>

            <USelect
                v-model="product.category"
                :items="categories"
                placeholder="Selecteer categorie"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                }"
            />
        </div>

        <!-- Beschrijving -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Beschrijving
            </label>

            <UTextarea
                v-model="product.info"
                placeholder="Voeg een beschrijving toe..."
                autoresize
                :rows="4"
                :ui="{
                    base: 'rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                }"
            />
        </div>

        <!-- Foto upload -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Product foto
            </label>

            <div
                class="flex h-[140px] items-center justify-center rounded-[14px] border-2 border-dashed border-magazijn-purple-soft bg-magazijn-white"
            >
                <div class="text-center">
                    <div class="mx-auto mb-2 h-10 w-10 rounded-full bg-magazijn-purple" />

                    <p class="text-sm text-magazijn-gray">
                        Upload een afbeelding
                    </p>
                </div>
            </div>
        </div>

        <!-- Aantal -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Aantal eenheden
            </label>

            <USelect
                v-model="product.available"
                :items="quantities"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                }"
            />
        </div>

        <!-- Beschikbaar -->
        <div class="flex items-center justify-between rounded-[12px] border border-magazijn-purple-soft px-4 py-3">
            <div>
                <h3 class="text-sm font-semibold text-black">
                    Beschikbaar
                </h3>

                <p class="text-sm text-magazijn-gray">
                    Product zichtbaar voor reserveringen
                </p>
            </div>

            <USwitch v-model="product.enabled" />
        </div>

        <!-- Opslaan -->
        <UButton
            block
            size="xl"
            class="h-[48px] rounded-[10px] bg-magazijn-purple text-base font-semibold text-white hover:bg-magazijn-purple"
        >
            Opslaan
        </UButton>

    </div>
</template>