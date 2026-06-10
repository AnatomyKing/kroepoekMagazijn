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

import { ref } from 'vue';

const imageFile = ref<File | null>(null);

function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement;

    if (target.files?.length) {
        imageFile.value = target.files[0];
        console.log(imageFile.value);
    }
}
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
                class="w-full"
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
                class="w-full"
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
                class="w-full"
            />
        </div>

        <!-- Foto upload -->
         <label class="mb-2 block text-sm font-semibold text-black">
                Product foto
            </label>
      <label
    class="flex h-[140px] cursor-pointer items-center justify-center rounded-[14px] border-2 border-dashed border-magazijn-purple-soft bg-magazijn-purple"
>
    <input
        type="file"
        accept="image/*"
        class="hidden"
        @change="onFileChange"
    >

    <div class="text-center">
        <div
            class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-white"
        >
            <UIcon
                name="i-lucide-image-plus"
                class="h-5 w-5 text-magazijn-purple"
            />
        </div>

        <p class="text-sm text-white">
            Upload een afbeelding
        </p>

        <p
            v-if="imageFile"
            class="mt-2 text-xs text-white"
        >
            {{ imageFile.name }}
        </p>
    </div>
</label>

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
                    base: 'h-[46px] w-[8vw] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
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

            <USwitch v-model="product.enabled" 
            :ui="{
            base: 'data-[state=checked]:bg-magazijn-purple data-[state=unchecked]:bg-red-500',
            thumb: 'bg-magazijn-white'  
            }"/>
        </div>

        <!-- Opslaan -->
        <UButton
            block
            size="xl"
            class="h-[48px] rounded-[10px] bg-magazijn-purple text-base font-semibold text-white hover:bg-magazijn-purple focus:ring-magazijn-purple"
        >
            Opslaan
        </UButton>

    </div>
</template>