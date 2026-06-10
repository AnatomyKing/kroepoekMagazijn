<script setup lang="js">
import { ref, onMounted, computed } from 'vue';
import AdminProductenBeheerTegels from './AdminProductenBeheerTegels.vue';

const items = ref([]);
const loading = ref(true);
const error = ref(null);
const searchQuery = ref('');

// Filter items op naam of categorie
const filteredItems = computed(() => {
    if (!searchQuery.value.trim()) {
        return items.value;
    }

    const query = searchQuery.value.toLowerCase();

    return items.value.filter(
        (item) =>
            item.item_name.toLowerCase().includes(query) ||
            (item.category && item.category.toLowerCase().includes(query)),
    );
});

// Alle items ophalen via GET /api/items
async function fetchItems() {
    loading.value = true;

    try {
        const response = await fetch('/api/items', {
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Netwerkfout');
        }

        const data = await response.json();
        items.value = data;
    } catch (err) {
        console.error(err);
        error.value = 'Kon producten niet laden';
    } finally {
        loading.value = false;
    }
}

// Verwijder een product
async function deleteProduct(product) {
    if (
        !confirm(
            `Weet je zeker dat je "${product.item_name}" wilt verwijderen?`,
        )
    ) {
        return;
    }

    try {
        const response = await fetch(`/products/${product.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Verwijderen mislukt');
        }

        // Verwijder lokaal
        items.value = items.value.filter((i) => i.id !== product.id);
    } catch (err) {
        console.error(err);
        alert('Fout bij verwijderen');
    }
}

// Stuur edit-event (voor bestaand product) of add-event (nieuw product)
const emit = defineEmits(['edit', 'add']);

function handleEdit(product) {
    emit('edit', product);
}

function handleAdd() {
    // Stuur een leeg product-object door voor een nieuw item
    emit('add', {
        name: '',
        category: '',
        info: '',
        available: 1,
        enabled: true,
    });
}

onMounted(() => {
    fetchItems();
});
</script>

<template>
    <div class="space-y-6">
        <!-- Header met knop en zoekbalk -->
        <div class="flex items-center justify-between gap-4">
            <div class="relative max-w-md flex-1">
                <UIcon
                    name="i-lucide-search"
                    class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-magazijn-gray"
                />
                <UInput
                    v-model="searchQuery"
                    placeholder="Zoeken op naam of categorie..."
                    class="pl-9"
                    :ui="{
                        base: 'h-[42px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    }"
                />
            </div>
            <UButton
                @click="handleAdd"
                icon="i-lucide-plus"
                label="Nieuw product"
                size="md"
                class="hover:bg-magazijn-purple-dark rounded-[10px] bg-magazijn-purple text-white"
            />
        </div>

        <!-- Laadstatus -->
        <div v-if="loading" class="py-8 text-center">
            <UIcon
                name="i-lucide-loader-circle"
                class="mx-auto h-6 w-6 animate-spin text-magazijn-purple"
            />
            <p class="mt-2 text-magazijn-gray">Producten laden...</p>
        </div>

        <!-- Foutmelding -->
        <div v-else-if="error" class="py-8 text-center text-red-500">
            {{ error }}
        </div>

        <!-- Lijst van tegels -->
        <div v-else>
            <div
                v-if="filteredItems.length === 0"
                class="py-8 text-center text-magazijn-gray"
            >
                Geen producten gevonden.
            </div>
            <div v-else class="space-y-4">
                <AdminProductenBeheerTegels
                    v-for="product in filteredItems"
                    :key="product.id"
                    :product="product"
                    @edit="handleEdit"
                    @delete="deleteProduct"
                />
            </div>
        </div>
    </div>
</template>
