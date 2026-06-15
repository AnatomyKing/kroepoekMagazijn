<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';

type Product = {
    id?: number;
    name: string;
    type: string;
    info: string;
    category: string;
    available: number;
    enabled: boolean;
    image?: string | null;
};

defineProps<{
    product: Product;
}>();

const emit = defineEmits<{
    (e: 'edit', product: Product): void;
    (e: 'delete', product: Product): void;
}>();
</script>

<template>
    <UCard
        variant="outline"
        :ui="{
            root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft overflow-hidden',
            body: 'p-0 sm:p-0',
        }"
    >
        <div class="flex items-center justify-between px-5 py-4">
            <!-- Left -->
            <div class="flex items-center gap-5">
                <div
                    class="h-16 w-16 overflow-hidden rounded-[18px] bg-magazijn-purple"
                >
                    <img
                        v-if="product.image"
                        :src="'/storage/' + product.image"
                        :alt="product.name"
                        class="h-full w-full object-cover"
                    />

                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center text-white"
                    >
                        <UIcon name="i-lucide-package" class="h-8 w-8" />
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-black">
                        {{ product.name }}
                    </h2>

                    <p class="text-sm text-magazijn-gray">
                        {{ product.type || product.category || 'Geen categorie' }}
                    </p>
                </div>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-5">
                <!-- Status -->
                <StatusBadge
                    :status="
                        product.enabled && product.available > 0
                            ? 'available'
                            : 'unavailable'
                    "
                />

                <!-- Icons -->
                <UButton
                    icon="i-lucide-pencil"
                    color="black"
                    variant="ghost"
                    @click="emit('edit', product)"
                />

                <UButton
                    icon="i-lucide-trash"
                    color="black"
                    variant="ghost"
                    @click="emit('delete', product)"
                />
            </div>
        </div>
    </UCard>
</template>
