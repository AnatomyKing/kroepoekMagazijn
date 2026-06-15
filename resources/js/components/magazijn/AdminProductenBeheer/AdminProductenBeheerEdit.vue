<script setup lang="ts">
import { ref } from 'vue';

type Product = {
    id?: number;
    name: string;
    type: string;
    info: string;
    category: string;
    available: number;
    enabled: boolean;
    image?: string | null;
    imageFile?: File | null;
};

type FormErrors = Record<string, string | string[]>;

const props = withDefaults(
    defineProps<{
        product: Product;
        isNew: boolean;
        errors?: FormErrors;
    }>(),
    {
        errors: () => ({}),
    },
);

const emit = defineEmits<{
    (e: 'image-change', file: File | null): void;
}>();

const categories = [
    'Camera',
    'Audio',
    'Accu',
    'Rugzak',
    'Kits',
    'Overig',
];

const quantities = Array.from({ length: 20 }, (_, i) => i + 1);
const selectedImageName = ref('');

function errorText(...keys: string[]) {
    for (const key of keys) {
        const value = props.errors?.[key];

        if (Array.isArray(value)) {
            return value[0] || '';
        }

        if (typeof value === 'string') {
            return value;
        }
    }

    return '';
}

function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0] || null;

    selectedImageName.value = file?.name || '';
    emit('image-change', file);
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
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
            />

            <p
                v-if="errorText('name', 'item_name')"
                class="mt-1 text-sm text-red-500"
            >
                {{ errorText('name', 'item_name') }}
            </p>
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
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    content: 'z-[9999]',
                }"
                :portal="'body'"
            />

            <p
                v-if="errorText('category')"
                class="mt-1 text-sm text-red-500"
            >
                {{ errorText('category') }}
            </p>
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
                    base: 'rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
            />

            <p
                v-if="errorText('info', 'description')"
                class="mt-1 text-sm text-red-500"
            >
                {{ errorText('info', 'description') }}
            </p>
        </div>

        <!-- Foto upload -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Product foto
            </label>

            <label
                class="flex h-[140px] cursor-pointer items-center justify-center rounded-[14px] border-2 border-dashed border-magazijn-purple-soft bg-magazijn-white"
            >
                <input
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="onFileChange"
                />

                <div class="text-center">
                    <div
                        class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-magazijn-purple"
                    >
                        <UIcon
                            name="i-lucide-image-plus"
                            class="h-5 w-5 text-white"
                        />
                    </div>

                    <p class="text-sm text-magazijn-gray">
                        Upload een afbeelding
                    </p>

                    <p
                        v-if="selectedImageName"
                        class="mt-2 text-xs text-magazijn-purple"
                    >
                        {{ selectedImageName }}
                    </p>

                    <p
                        v-else-if="product.image"
                        class="mt-2 text-xs text-magazijn-gray"
                    >
                        Huidige afbeelding blijft behouden
                    </p>
                </div>
            </label>

            <p
                v-if="errorText('image')"
                class="mt-1 text-sm text-red-500"
            >
                {{ errorText('image') }}
            </p>
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
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    content: 'z-[9999]',
                }"
                :portal="'body'"
            />

            <p
                v-if="errorText('available', 'quantity_available')"
                class="mt-1 text-sm text-red-500"
            >
                {{ errorText('available', 'quantity_available') }}
            </p>
        </div>

        <!-- Beschikbaar -->
        <div
            class="flex items-center justify-between rounded-[12px] border border-magazijn-purple-soft px-4 py-3"
        >
            <div>
                <h3 class="text-sm font-semibold text-black">
                    Beschikbaar
                </h3>

                <p class="text-sm text-magazijn-gray">
                    Product zichtbaar voor reserveringen
                </p>
            </div>

            <USwitch
                v-model="product.enabled"
                :ui="{
                    base: 'data-[state=checked]:bg-magazijn-purple data-[state=unchecked]:bg-red-500',
                    thumb: 'bg-white',
                }"
            />
        </div>
    </div>
</template>
