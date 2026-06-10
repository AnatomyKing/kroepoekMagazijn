<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';

const props = defineProps<{
    reservation: {
        id: number;
        user: { name: string; email: string };
        item: { item_name: string; category?: string };
        borrow_date: string;
        end_date: string;
        quantity: number;
        commentary: string | null;
        status: string;
    };
}>();

const emit = defineEmits(['delete']);
</script>

<template>
    <UCard
        variant="outline"
        :ui="{
            root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
            body: 'p-0 sm:p-0',
        }"
    >
        <div
            class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div class="flex items-center gap-5">
                <div class="h-16 w-16 rounded-[18px] bg-magazijn-purple" />
                <div>
                    <h2 class="text-lg font-semibold text-black">
                        {{ reservation.item.item_name }}
                    </h2>
                    <p class="text-sm text-magazijn-gray">
                        {{ reservation.user.name }} ({{
                            reservation.user.email
                        }})
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <div>
                    <span class="font-medium text-magazijn-gray">Aantal:</span>
                    <span class="ml-1 font-semibold">{{
                        reservation.quantity
                    }}</span>
                </div>
                <div>
                    <span class="font-medium text-magazijn-gray">Start:</span>
                    <span class="ml-1 font-semibold">{{
                        reservation.borrow_date
                    }}</span>
                </div>
                <div>
                    <span class="font-medium text-magazijn-gray">Eind:</span>
                    <span class="ml-1 font-semibold">{{
                        reservation.end_date
                    }}</span>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <StatusBadge :status="reservation.status" />
                <UButton
                    icon="i-lucide-trash"
                    color="red"
                    variant="ghost"
                    @click="emit('delete', reservation.id)"
                />
            </div>
        </div>
    </UCard>
</template>
