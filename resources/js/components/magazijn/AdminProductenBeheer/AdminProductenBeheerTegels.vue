<script setup>
import StatusBadge from '@/components/StatusBadge.vue';
defineProps({
    product: Object
})

</script>

<template>
    <UCard
        variant="outline"
        :ui="{
            root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
            body: 'p-0 sm:p-0'
        }"
    >

        <div class="flex items-center justify-between px-5 py-4">

            <!-- Left -->
            <div class="flex items-center gap-5">

                <div class="h-16 w-16 rounded-[18px] bg-magazijn-purple" />

                <div>
                    <h2 class="text-lg font-semibold text-black">
                        {{ product.name }}
                    </h2>

                    <p class="text-sm text-magazijn-gray">
                        {{ product.type }}
                    </p>
                </div>

            </div>

            <!-- Right -->
            <div class="flex items-center gap-5">

                <!-- Status -->
                <StatusBadge
                    :status="product.available ? 'available' : 'unavailable'"
                />

                <!-- Icons -->
                <UButton
                    icon="i-lucide-pencil"
                    color="black"
                    variant="ghost"
                />

                <UButton
                    icon="i-lucide-trash"
                    color="black"
                    variant="ghost"
                />

            </div>

        </div>

    </UCard>
</template>