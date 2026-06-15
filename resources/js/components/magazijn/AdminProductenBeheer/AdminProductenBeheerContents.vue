<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import AdminProductenBeheerTegels from './AdminProductenBeheerTegels.vue';
import AdminProductenBeheerEdit from './AdminProductenBeheerEdit.vue';

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

const page = {
    title: 'Producten Beheer',
    description: 'Producten aanmaken, wijzigen en verwijderen',
};

const products = ref<Product[]>([]);
const search = ref('');
const loading = ref(false);
const saving = ref(false);
const error = ref('');
const errors = ref<FormErrors>({});

const isModalOpen = ref(false);
const editingProduct = ref<Product | null>(null);
const isCreating = ref(false);

const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();

    return products.value.filter((product) => {
        if (!query) return true;

        return [product.name, product.type, product.info, product.category].some(
            (value) => String(value || '').toLowerCase().includes(query),
        );
    });
});

function getCsrfToken() {
    return (
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || ''
    );
}

function mapBackendProduct(item: any): Product {
    return {
        id: item.id,
        name: item.item_name || '',
        type: item.type || item.category || '',
        info: item.description || '',
        category: item.category || '',
        available: Number(item.quantity_available ?? 0),
        enabled: item.status ? item.status === 'available' : Number(item.quantity_available ?? 0) > 0,
        image: item.image || null,
        imageFile: null,
    };
}

function normalizeErrors(serverErrors: FormErrors): FormErrors {
    const keyMap: Record<string, string> = {
        item_name: 'name',
        description: 'info',
        quantity_available: 'available',
    };

    const mapped: FormErrors = {};

    Object.entries(serverErrors).forEach(([key, value]) => {
        mapped[keyMap[key] || key] = value;
    });

    return mapped;
}

async function fetchProducts() {
    loading.value = true;
    error.value = '';

    try {
        const response = await fetch('/api/items', {
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Producten ophalen mislukt');
        }

        const data = await response.json();
        const list = Array.isArray(data) ? data : data.data || [];

        products.value = list.map(mapBackendProduct);
    } catch (err) {
        console.error(err);
        error.value = 'Kon producten niet laden';
    } finally {
        loading.value = false;
    }
}

function validateProduct(product: Product) {
    const newErrors: FormErrors = {};

    if (!product.name.trim()) {
        newErrors.name = 'Naam product is verplicht';
    }

    if (!product.category) {
        newErrors.category = 'Categorie is verplicht';
    }

    if (!product.available || Number(product.available) <= 0) {
        newErrors.available = 'Aantal moet minimaal 1 zijn';
    }

    errors.value = newErrors;

    return Object.keys(newErrors).length === 0;
}

function openEdit(product: Product) {
    editingProduct.value = {
        ...product,
        imageFile: null,
    };

    errors.value = {};
    isCreating.value = false;
    isModalOpen.value = true;
}

function openCreate() {
    editingProduct.value = {
        name: '',
        type: '',
        info: '',
        category: '',
        available: 1,
        enabled: true,
        image: null,
        imageFile: null,
    };

    errors.value = {};
    isCreating.value = true;
    isModalOpen.value = true;
}

function closeModal() {
    isModalOpen.value = false;
    editingProduct.value = null;
    errors.value = {};
    isCreating.value = false;
}

function handleModalOpen(value: boolean) {
    if (value) {
        isModalOpen.value = true;
        return;
    }

    closeModal();
}

function handleImageChange(file: File | null) {
    if (!editingProduct.value) return;

    editingProduct.value.imageFile = file;
}

async function saveProduct() {
    if (!editingProduct.value) return;
    if (!validateProduct(editingProduct.value)) return;

    saving.value = true;
    errors.value = {};

    const product = editingProduct.value;

    const formData = new FormData();
    formData.append('item_name', product.name.trim());
    formData.append('category', product.category);
    formData.append('description', product.info || '');
    formData.append('quantity_available', String(Number(product.available)));
    formData.append('status', product.enabled ? 'available' : 'unavailable');

    if (product.imageFile) {
        formData.append('image', product.imageFile);
    }

    const url = isCreating.value
        ? '/products/store'
        : `/products/${product.id}`;

    if (!isCreating.value) {
        formData.append('_method', 'PUT');
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => null);

            if (errorData?.errors) {
                errors.value = normalizeErrors(errorData.errors);
                return;
            }

            throw new Error('Opslaan mislukt');
        }

        await fetchProducts();
        closeModal();
    } catch (err) {
        console.error(err);
        alert('Fout bij opslaan van product');
    } finally {
        saving.value = false;
    }
}

async function deleteProduct(product: Product) {
    if (!product.id) return;

    if (!confirm(`Weet je zeker dat je "${product.name}" wilt verwijderen?`)) {
        return;
    }

    try {
        const response = await fetch(`/products/${product.id}`, {
            method: 'DELETE',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Verwijderen mislukt');
        }

        products.value = products.value.filter((item) => item.id !== product.id);
    } catch (err) {
        console.error(err);
        alert('Fout bij verwijderen van product');
    }
}

onMounted(() => {
    fetchProducts();
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

        <!-- Loading -->
        <div v-if="loading" class="py-10 text-center">
            <UIcon
                name="i-lucide-loader-circle"
                class="mx-auto h-7 w-7 animate-spin text-magazijn-purple"
            />
            <p class="mt-2 text-magazijn-gray">Producten laden...</p>
        </div>

        <!-- Error -->
        <div v-else-if="error" class="py-10 text-center text-red-500">
            {{ error }}
        </div>

        <!-- Producten -->
        <div v-else class="mt-10 space-y-5">
            <div
                v-if="visibleProducts.length === 0"
                class="py-10 text-center text-magazijn-gray"
            >
                Geen producten gevonden.
            </div>

            <AdminProductenBeheerTegels
                v-for="product in visibleProducts"
                :key="product.id"
                :product="product"
                @edit="openEdit"
                @delete="deleteProduct"
            />
        </div>

        <UModal
            :open="isModalOpen"
            :ui="{
        overlay: 'z-[1000]',
        content: 'z-[1001] w-full max-w-[600px] max-h-[90dvh] overflow-hidden',
    }"
            @update:open="handleModalOpen"
        >
            <template #content>
                <UCard
                    class="w-full bg-gray-100"
                    :ui="{
                root: 'max-h-[90dvh] overflow-hidden flex flex-col',
                header: 'shrink-0',
                body: 'overflow-y-auto',
                footer: 'shrink-0',
            }"
                >
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
                        :errors="errors"
                        @image-change="handleImageChange"
                    />

                    <template #footer>
                        <div class="flex justify-end gap-3">
                            <UButton
                                variant="ghost"
                                :disabled="saving"
                                @click="closeModal"
                            >
                                Annuleren
                            </UButton>

                            <UButton
                                class="bg-magazijn-purple text-white"
                                :loading="saving"
                                :disabled="saving"
                                @click="saveProduct"
                            >
                                Opslaan
                            </UButton>
                        </div>
                    </template>
                </UCard>
            </template>
        </UModal>
    </UContainer>
</template>
