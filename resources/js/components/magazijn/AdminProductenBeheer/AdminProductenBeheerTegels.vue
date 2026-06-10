<script setup>
import StatusBadge from '@/components/StatusBadge.vue';

const props = defineProps({
    product: Object,
});

const emit = defineEmits(['edit', 'delete']);

// Hulpfunctie om beschrijving in te korten
function truncate(text, maxLength = 100) {
    if (!text) return 'Geen beschrijving';
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}
</script>

<template>
    <UCard
        variant="outline"
        :ui="{
            root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft overflow-hidden',
            body: 'p-0 sm:p-0',
        }"
    >
        <div class="px-5 py-4">
            <!-- Bovenste rij: image, titel en categorie + actieknoppen -->
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <!-- Afbeelding placeholder (of echte afbeelding als die bestaat) -->
                    <div
                        class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-[18px] bg-magazijn-purple"
                    >
                        <img
                            v-if="product.image"
                            :src="'/storage/' + product.image"
                            :alt="product.item_name"
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
                            {{ product.item_name }}
                        </h2>
                        <p class="text-sm text-magazijn-gray">
                            {{ product.category || 'Geen categorie' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <StatusBadge
                        :status="
                            product.quantity_available > 0
                                ? 'available'
                                : 'unavailable'
                        "
                    />
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

            <!-- Extra informatie: aantal en beschrijving -->
            <div
                class="mt-3 grid grid-cols-2 gap-2 border-t border-magazijn-purple-soft pt-3 text-sm"
            >
                <div>
                    <span class="font-medium text-magazijn-gray"
                        >Beschikbaar:</span
                    >
                    <span class="ml-2 font-semibold text-black"
                        >{{ product.quantity_available }} stuks</span
                    >
                </div>
                <div>
                    <span class="font-medium text-magazijn-gray">Totaal:</span>
                    <span class="ml-2 font-semibold text-black"
                        >{{ product.quantity_total }} stuks</span
                    >
                </div>
            </div>
            <div class="mt-2 text-sm text-magazijn-gray">
                <span class="font-medium">Beschrijving:</span>
                <span class="ml-2">{{ truncate(product.description) }}</span>
            </div>
        </div>
    </UCard>
</template>
