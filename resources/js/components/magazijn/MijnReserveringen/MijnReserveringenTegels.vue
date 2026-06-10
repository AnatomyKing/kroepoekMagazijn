<script setup>
import StatusBadge from '@/components/StatusBadge.vue';

const props = defineProps({
    reservation: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['return']);
</script>

<template>
    <div
        class="flex flex-col justify-between gap-6 rounded-lg border border-neutral-200 bg-white p-6 shadow-sm md:flex-row md:items-center"
    >
        <div class="flex items-center gap-5">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl">
                <UIcon
                    name="i-lucide-package"
                    class="h-10 w-10 text-neutral-600"
                />
            </div>
            <div>
                <h3 class="text-2xl font-semibold">
                    {{ reservation.item.item_name }}
                </h3>
                <p class="text-neutral-500">
                    Start: {{ reservation.borrow_date }} - Eind:
                    {{ reservation.end_date }}
                </p>
                <p class="text-neutral-400">
                    Aantal: {{ reservation.quantity }}
                </p>
                <p v-if="reservation.commentary" class="text-neutral-400">
                    Opmerking: {{ reservation.commentary }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <StatusBadge :status="reservation.status" />
            <!-- Alleen 'Actief' reserveringen kunnen worden ingeleverd -->
            <UButton
                v-if="reservation.status === 'Actief'"
                label="Inleveren"
                color="green"
                variant="solid"
                size="sm"
                @click="emit('return', reservation.id)"
            />
        </div>
    </div>
</template>
