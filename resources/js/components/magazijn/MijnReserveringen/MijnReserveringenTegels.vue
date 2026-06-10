<script setup>
import StatusBadge from '@/components/StatusBadge.vue';

defineProps({
    reservation: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div
        class="flex flex-col justify-between gap-6 rounded-lg border border-neutral-200 bg-white p-6 shadow-sm md:flex-row md:items-center"
    >
        <div class="flex items-center gap-5">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl">
                <UIcon
                    name="i-lucide-user"
                    class="h-10 w-10 text-neutral-600"
                />
            </div>

            <div>
                <h3 class="text-2xl font-semibold">
                    {{ reservation.name }}
                </h3>

                <p class="text-neutral-500">
                    {{ reservation.date }}
                </p>

                <p class="text-neutral-400">
                    {{ reservation.info }}
                </p>
            </div>
        </div>

        <span>
            <StatusBadge></StatusBadge>
        </span>
    </div>
</template>
