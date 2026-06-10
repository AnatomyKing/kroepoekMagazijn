<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import HomeProductenTegelCarouselViewer from './HomeProductenTegelCarouselViewer.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['back', 'play-video']);

// Haal de ingelogde gebruiker op uit Inertia props
const user = computed(() => usePage().props.auth.user);

// Formuliervelden
const startDate = ref('');
const endDate = ref('');
const note = ref('');
const quantity = ref(1); // standaard 1

// Beschikbare hoeveelheid (max)
const maxQuantity = computed(() => props.product.available || 1);

// Opties voor de dropdown (1 tot max beschikbaar)
const quantityOptions = computed(() => {
    const max = maxQuantity.value;
    return Array.from({ length: max }, (_, i) => i + 1);
});

// Datum validatie (einddatum moet na startdatum)
const isFormValid = computed(() => {
    if (!startDate.value || !endDate.value) return false;
    return new Date(endDate.value) > new Date(startDate.value);
});

async function reserveProduct() {
    if (!isFormValid.value) {
        alert('Einddatum moet na startdatum liggen');
        return;
    }

    try {
        const response = await fetch('/borrowings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                item_id: props.product.id,
                quantity: quantity.value,
                start_date: startDate.value,
                end_date: endDate.value,
                commentary: note.value,
            }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            alert(errorData.message || 'Reserveren mislukt');
            return;
        }

        const result = await response.json();
        alert('Reservering gelukt!');
        // Refresh de pagina of stuur een event om terug te gaan
        window.location.reload();
    } catch (error) {
        console.error('Fout bij reserveren:', error);
        alert('Er is een fout opgetreden');
    }
}
</script>

<template>
    <UContainer class="px-3 pt-[clamp(28px,6vw,34px)] pb-16 sm:px-5">
        <!-- Terugknop (onaangepast) -->
        <button
            type="button"
            class="flex items-center gap-[14px] text-[16px] font-semibold text-magazijn-gray transition hover:text-magazijn-purple"
            @click="emit('back')"
        >
            <span
                class="grid size-[30px] place-items-center rounded-full bg-magazijn-purple text-magazijn-white"
            >
                <span
                    class="h-[9px] w-[9px] rotate-45 border-b-2 border-l-2 border-current"
                />
            </span>
            <span>Terug</span>
        </button>

        <section
            class="mt-[clamp(31px,5vw,32px)] grid gap-[clamp(28px,5vw,57px)] lg:grid-cols-[minmax(360px,591px)_minmax(360px,586px)]"
        >
            <!-- Linkerkant: product info (onaangepast) -->
            <article
                class="overflow-hidden rounded-[10px] border border-magazijn-purple-soft bg-magazijn-white"
            >
                <div
                    class="h-[clamp(260px,32vw,392px)] overflow-hidden bg-magazijn-purple"
                >
                    <HomeProductenTegelCarouselViewer
                        :product="product"
                        arrows
                        expandable
                    />
                </div>
                <div
                    class="relative min-h-[248px] bg-magazijn-white px-[25px] pt-[13px]"
                >
                    <div class="flex items-center gap-[6px]">
                        <UBadge
                            label="Beschikbaar"
                            class="h-[28px] rounded-[9px] bg-magazijn-green px-[28px] text-[13px] font-bold text-magazijn-white ring-0"
                        />
                        <UBadge
                            :label="product.available"
                            class="grid size-[28px] place-items-center rounded-full bg-magazijn-green p-0 text-[13px] font-bold text-magazijn-white ring-0"
                        />
                    </div>
                    <h1
                        class="mt-7 max-w-[calc(100%-86px)] truncate text-[26px] leading-8 font-bold tracking-[-0.02em] text-black"
                    >
                        {{ product.name }}
                    </h1>
                    <p
                        class="mt-[9px] truncate text-[16px] leading-5 text-magazijn-gray"
                    >
                        {{ product.type }}
                    </p>
                    <p
                        class="mt-7 truncate text-[16px] leading-5 text-magazijn-gray"
                    >
                        {{ product.info }}
                    </p>
                    <UButton
                        v-if="product.youtubeVideo"
                        type="button"
                        icon="i-lucide-play"
                        aria-label="Bekijk video"
                        variant="solid"
                        size="xl"
                        class="absolute top-10 right-[30px] !grid size-[56px] !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white shadow-md transition hover:scale-110 hover:bg-magazijn-purple hover:shadow-xl active:scale-95"
                        @click="emit('play-video', product)"
                    />
                </div>
            </article>

            <!-- Rechterkant: reserveringsformulier -->
            <UCard
                class="bg-magazijn-white"
                :ui="{
                    root: 'rounded-[10px] border border-magazijn-purple-soft shadow-none ring-0',
                    body: 'px-[clamp(24px,4vw,33px)] py-[clamp(28px,4vw,34px)] sm:px-[clamp(24px,4vw,33px)] sm:py-[clamp(28px,4vw,34px)]',
                }"
            >
                <div class="flex items-start gap-[26px]">
                    <div
                        class="relative mt-[1px] size-[47px] shrink-0 border-2 border-black/80"
                    >
                        <span
                            class="absolute top-[20px] left-[20px] h-[2px] w-[12px] bg-black/80"
                        />
                        <span
                            class="absolute top-[23px] left-0 h-[2px] w-full bg-black/80"
                        />
                    </div>
                    <div>
                        <h2
                            class="text-[24px] leading-7 font-bold tracking-[-0.03em] text-black"
                        >
                            Reserveren
                        </h2>
                        <p
                            class="mt-[6px] text-[16px] leading-5 text-magazijn-gray"
                        >
                            Max. 14 dagen
                        </p>
                    </div>
                </div>

                <!-- Studentgegevens (uit Inertia auth) -->
                <div class="mt-8">
                    <label
                        class="block text-[18px] leading-6 font-bold text-black"
                    >
                        Naam student
                    </label>
                    <p
                        class="mt-[10px] text-[16px] leading-5 text-magazijn-gray"
                    >
                        {{ user.name }} ({{ user.email }})
                    </p>
                </div>

                <!-- Aantal dropdown -->
                <div class="mt-[29px]">
                    <label
                        class="block text-[18px] leading-6 font-bold text-black"
                    >
                        Aantal
                        <span class="text-sm font-normal"
                            >(max {{ maxQuantity }})</span
                        >
                    </label>
                    <USelect
                        v-model="quantity"
                        :items="quantityOptions"
                        size="xl"
                        class="mt-4 w-full"
                        :ui="{
                            base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black ring-1 ring-magazijn-purple-soft',
                        }"
                    />
                </div>

                <div class="mt-[29px] grid gap-6 sm:grid-cols-2 sm:gap-[84px]">
                    <div>
                        <label
                            class="block text-[18px] leading-6 font-bold text-black"
                        >
                            Startdatum
                        </label>
                        <UInput
                            v-model="startDate"
                            type="date"
                            variant="outline"
                            size="xl"
                            class="mt-4 w-full"
                            :ui="{
                                base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-[18px] leading-6 font-bold text-black"
                        >
                            Einddatum
                        </label>
                        <UInput
                            v-model="endDate"
                            type="date"
                            variant="outline"
                            size="xl"
                            class="mt-4 w-full"
                            :ui="{
                                base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>
                </div>

                <div class="mt-[39px]">
                    <label
                        class="block text-[18px] leading-6 font-bold text-black"
                    >
                        Opmerkingen (optioneel)
                    </label>
                    <UTextarea
                        v-model="note"
                        placeholder="Bijv. voor welk project"
                        autoresize
                        :rows="3"
                        class="mt-[14px] w-full"
                        :ui="{
                            base: 'min-h-[95px] resize-none rounded-[10px] bg-magazijn-white px-[15px] py-[13px] text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                        }"
                    />
                </div>

                <UButton
                    label="Reserveren"
                    size="xl"
                    block
                    :disabled="!isFormValid || quantity < 1"
                    class="mt-[29px] h-[47px] rounded-[10px] bg-magazijn-purple text-[23px] font-bold tracking-wide text-magazijn-white hover:bg-magazijn-purple disabled:opacity-50"
                    @click="reserveProduct"
                />
            </UCard>
        </section>
    </UContainer>
</template>
