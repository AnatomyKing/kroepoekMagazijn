<script setup lang="ts">
import { ref, reactive, watch, computed } from 'vue';

// Types
interface Product {
    id?: number;
    name: string;
    category: string;
    info: string;
    available: number;
    enabled: boolean;
}

const props = defineProps<{
    product: Product | any; // any toestaan voor database-object
    isNew: boolean;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

// Hulpfunctie: converteer database-object naar interne Product
function mapToLocalProduct(source: any): Product {
    if (props.isNew) {
        // Nieuw product heeft al de juiste structuur
        return { ...source } as Product;
    }
    // Bestaand product uit database omzetten
    return {
        id: source.id,
        name: source.item_name || '',
        category: source.category || '',
        info: source.description || '',
        available: source.quantity_available ?? 1,
        enabled: source.status === 'available', // status 'available' wordt true
    };
}

// Lokale kopie
const localProduct = reactive<Product>(mapToLocalProduct(props.product));

// Bij wijziging van de prop (bijv. ander product geselecteerd) opnieuw mappen
watch(
    () => props.product,
    (newProduct) => {
        const mapped = mapToLocalProduct(newProduct);
        Object.assign(localProduct, mapped);
    },
    { deep: true },
);

const categories = ['Camera', 'Audio', 'Accu', 'Rugzak', 'Kits', 'Overig'];
const quantities = Array.from({ length: 20 }, (_, i) => i + 1);
const imageFile = ref<File | null>(null);
const errors = ref<Record<string, string>>({});

const isEdit = computed(() => !!props.product?.id);

function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files?.length) {
        imageFile.value = target.files[0];
    }
}

function validateForm(): boolean {
    const newErrors: Record<string, string> = {};
    if (!localProduct.name?.trim())
        newErrors.name = 'Naam product is verplicht';
    if (!localProduct.category) newErrors.category = 'Categorie is verplicht';
    if (!localProduct.available || localProduct.available <= 0)
        newErrors.available = 'Aantal moet minimaal 1 zijn';
    errors.value = newErrors;
    return Object.keys(newErrors).length === 0;
}

async function submitForm() {
    if (!validateForm()) return;

    const formData = new FormData();
    formData.append('item_name', localProduct.name.trim());
    formData.append('category', localProduct.category);
    formData.append('description', localProduct.info || '');
    formData.append('quantity_available', String(localProduct.available));
    formData.append(
        'status',
        localProduct.enabled ? 'available' : 'unavailable',
    );
    if (imageFile.value) formData.append('image', imageFile.value);

    const url = isEdit.value
        ? `/products/${props.product.id}`
        : '/products/store';
    if (isEdit.value) formData.append('_method', 'PUT');

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
        });

        if (!response.ok) {
            const errorData = await response.json();
            if (errorData.errors) errors.value = errorData.errors;
            return;
        }

        emit('close');
    } catch (error) {
        console.error('Netwerk fout:', error);
    }
}
</script>

<template>
    <!-- De template blijft precies zoals je had -->
    <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Naam -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Naam product <span class="text-red-500">*</span>
            </label>
            <UInput
                v-model="localProduct.name"
                placeholder="Bijv. Canon EOS R50"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
                class="w-full"
                :class="{ 'border-red-500': errors.name }"
            />
            <p v-if="errors.name" class="mt-1 text-sm text-red-500">
                {{ errors.name }}
            </p>
        </div>

        <!-- Categorie -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Categorie <span class="text-red-500">*</span>
            </label>
            <USelect
                v-model="localProduct.category"
                :items="categories"
                placeholder="Selecteer categorie"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    content: 'z-[9999]',
                }"
                :portal="'body'"
                class="w-full"
            />
            <p v-if="errors.category" class="mt-1 text-sm text-red-500">
                {{ errors.category }}
            </p>
        </div>

        <!-- Beschrijving -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black"
                >Beschrijving</label
            >
            <UTextarea
                v-model="localProduct.info"
                placeholder="Voeg een beschrijving toe..."
                autoresize
                :rows="4"
                :ui="{
                    base: 'rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
                class="w-full"
            />
        </div>

        <!-- Foto upload -->
        <label class="mb-2 block text-sm font-semibold text-black"
            >Product foto</label
        >
        <label
            class="flex h-[140px] cursor-pointer items-center justify-center rounded-[14px] border-2 border-dashed border-magazijn-purple-soft bg-magazijn-purple"
        >
            <input
                type="file"
                accept="image/*"
                class="hidden"
                @change="onFileChange"
            />
            <div class="text-center">
                <div
                    class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-white"
                >
                    <UIcon
                        name="i-lucide-image-plus"
                        class="h-5 w-5 text-magazijn-purple"
                    />
                </div>
                <p class="text-sm text-white">Upload een afbeelding</p>
                <p v-if="imageFile" class="mt-2 text-xs text-white">
                    {{ imageFile.name }}
                </p>
            </div>
        </label>

        <!-- Aantal -->
        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Aantal eenheden <span class="text-red-500">*</span>
            </label>
            <USelect
                v-model="localProduct.available"
                :items="quantities"
                size="xl"
                :ui="{
                    base: 'h-[46px] w-[8vw] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    content: 'z-[9999]',
                }"
                :portal="'body'"
            />
            <p v-if="errors.available" class="mt-1 text-sm text-red-500">
                {{ errors.available }}
            </p>
        </div>

        <!-- Beschikbaar -->
        <div
            class="flex items-center justify-between rounded-[12px] border border-magazijn-purple-soft px-4 py-3"
        >
            <div>
                <h3 class="text-sm font-semibold text-black">Beschikbaar</h3>
                <p class="text-sm text-magazijn-gray">
                    Product zichtbaar voor reserveringen
                </p>
            </div>
            <USwitch
                v-model="localProduct.enabled"
                :ui="{
                    base: 'data-[state=checked]:bg-magazijn-purple data-[state=unchecked]:bg-red-500',
                    thumb: 'bg-magazijn-white',
                }"
            />
        </div>

        <!-- Opslaan knop -->
        <UButton
            type="submit"
            block
            size="xl"
            class="h-[48px] rounded-[10px] bg-magazijn-purple text-base font-semibold text-white hover:bg-magazijn-purple focus:ring-magazijn-purple"
        >
            Opslaan
        </UButton>
    </form>
</template>
