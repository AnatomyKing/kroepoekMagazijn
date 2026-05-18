<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <UCard
        as="article"
        variant="outline"
        class="group overflow-hidden bg-magazijn-white transition duration-200 hover:-translate-y-0.5"
        :ui="{
            root: 'rounded-lg ring-1 ring-magazijn-purple-soft divide-y-0',
            body: 'p-0 sm:p-0'
        }"
    >
        <div class="relative h-[172px] bg-magazijn-purple">
            <div class="absolute left-2 top-[9px] flex items-center gap-1">
                <UBadge
                    label="Beschikbaar"
                    variant="solid"
                    class="h-[16px] rounded-[4px] bg-magazijn-green px-[7px] text-[10px] font-bold leading-none text-magazijn-white ring-0"
                />

                <UBadge
                    :label="product.available"
                    variant="solid"
                    class="grid size-[17px] place-items-center rounded-full bg-magazijn-green p-0 text-[10px] font-bold leading-none text-magazijn-white ring-0"
                />
            </div>
        </div>

        <div class="relative h-[109px] bg-magazijn-white px-3 pt-[12px]">
            <h2 class="text-[20px] font-semibold leading-6 tracking-[-0.01em] text-black">
                {{ product.name }}
            </h2>

            <p class="mt-[3px] text-[14px] text-magazijn-gray">
                {{ product.type }}
            </p>

            <p class="mt-[10px] text-[14px] text-magazijn-gray">
                {{ product.info }}
            </p>

            <span class="absolute right-[17px] top-[18px] size-6 rounded-full bg-magazijn-purple" />
        </div>
    </UCard>
</template>
