<script setup>
import { ref } from 'vue';

defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['back']);

const student = {
    name: 'Pien van den Broek',
    email: 'ps251239@summacollege.nl',
};

const startDate = ref('');
const endDate = ref('');
const note = ref('');

function reserveProduct() {
    console.log('Reserveer product', {
        startDate: startDate.value,
        endDate: endDate.value,
        note: note.value,
    });
}
</script>

<template>
    <UContainer class="px-3 pb-16 pt-[clamp(28px,6vw,34px)] sm:px-5">
        <button
            type="button"
            class="flex items-center gap-[14px] text-[16px] font-semibold text-magazijn-gray transition hover:text-magazijn-purple"
            @click="emit('back')"
        >
            <span class="size-[30px] rounded-full bg-magazijn-purple" />
            <span>Terug</span>
        </button>

        <section class="mt-[clamp(31px,5vw,32px)] grid gap-[clamp(28px,5vw,57px)] lg:grid-cols-[minmax(360px,591px)_minmax(360px,586px)]">
            <article
                class="overflow-hidden rounded-[10px] border border-magazijn-purple-soft bg-magazijn-white"
            >
                <div class="relative h-[clamp(260px,32vw,392px)] bg-magazijn-purple" />

                <div class="relative min-h-[248px] bg-magazijn-white px-[25px] pt-[13px]">
                    <div class="flex items-center gap-[6px]">
                        <UBadge
                            label="Beschikbaar"
                            variant="solid"
                            class="h-[28px] rounded-[9px] bg-magazijn-green px-[28px] text-[13px] font-bold leading-none text-magazijn-white ring-0"
                        />

                        <UBadge
                            :label="product.available"
                            variant="solid"
                            class="grid size-[28px] place-items-center rounded-full bg-magazijn-green p-0 text-[13px] font-bold leading-none text-magazijn-white ring-0"
                        />
                    </div>

                    <h1 class="mt-[28px] max-w-[calc(100%-66px)] truncate text-[26px] font-bold leading-8 tracking-[-0.02em] text-black">
                        {{ product.name }}
                    </h1>

                    <p class="mt-[9px] truncate text-[16px] leading-5 text-magazijn-gray">
                        {{ product.type }}
                    </p>

                    <p class="mt-[28px] truncate text-[16px] leading-5 text-magazijn-gray">
                        {{ product.info }}
                    </p>

                    <span class="absolute right-[30px] top-[40px] size-[60px] rounded-full bg-magazijn-purple" />
                </div>
            </article>

            <UCard
                class="bg-magazijn-white"
                :ui="{
                    root: 'rounded-[10px] border border-magazijn-purple-soft shadow-none ring-0',
                    body: 'px-[clamp(24px,4vw,33px)] py-[clamp(28px,4vw,34px)] sm:px-[clamp(24px,4vw,33px)] sm:py-[clamp(28px,4vw,34px)]'
                }"
            >
                <div class="flex items-start gap-[26px]">
                    <div class="relative mt-[1px] size-[47px] shrink-0 border-2 border-black/80">
                        <span class="absolute left-[20px] top-[20px] h-[2px] w-[12px] bg-black/80" />
                        <span class="absolute left-0 top-[23px] h-[2px] w-full bg-black/80" />
                    </div>

                    <div>
                        <h2 class="text-[24px] font-bold leading-7 tracking-[-0.03em] text-black">
                            Reserveren
                        </h2>

                        <p class="mt-[6px] text-[16px] leading-5 text-magazijn-gray">
                            Max. 14 dagen
                        </p>
                    </div>
                </div>

                <div class="mt-[32px]">
                    <label class="block text-[18px] font-bold leading-6 text-black">
                        Naam student
                    </label>

                    <p class="mt-[10px] text-[16px] leading-5 text-magazijn-gray">
                        {{ student.name }} ({{ student.email }})
                    </p>
                </div>

                <div class="mt-[29px] grid gap-[24px] sm:grid-cols-2 sm:gap-[84px]">
                    <div>
                        <label class="block text-[18px] font-bold leading-6 text-black">
                            Startdatum
                        </label>

                        <UInput
                            v-model="startDate"
                            type="date"
                            placeholder="Value"
                            variant="outline"
                            size="xl"
                            class="mt-[16px] w-full"
                            :ui="{
                                base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                            }"
                        />
                    </div>

                    <div>
                        <label class="block text-[18px] font-bold leading-6 text-black">
                            Einddatum
                        </label>

                        <UInput
                            v-model="endDate"
                            type="date"
                            placeholder="Value"
                            variant="outline"
                            size="xl"
                            class="mt-[16px] w-full"
                            :ui="{
                                base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                            }"
                        />
                    </div>
                </div>

                <div class="mt-[39px]">
                    <label class="block text-[18px] font-bold leading-6 text-black">
                        Opmerkingen (optioneel)
                    </label>

                    <UTextarea
                        v-model="note"
                        placeholder="Bijv. voor welk project"
                        autoresize
                        :rows="3"
                        class="mt-[14px] w-full"
                        :ui="{
                            base: 'min-h-[95px] resize-none rounded-[10px] bg-magazijn-white px-[15px] py-[13px] text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple'
                        }"
                    />
                </div>

                <UButton
                    label="Reserveren"
                    variant="solid"
                    size="xl"
                    block
                    class="mt-[29px] h-[47px] rounded-[10px] bg-magazijn-purple text-[23px] font-bold tracking-wide text-magazijn-white hover:bg-magazijn-purple"
                    @click="reserveProduct"
                />
            </UCard>
        </section>
    </UContainer>
</template>
