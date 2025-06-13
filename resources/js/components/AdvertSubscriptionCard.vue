<script setup lang="ts">

import {Subscription} from '@/types/domain';
import {LoaderCircle} from "lucide-vue-next";
import {Button} from "@/components/ui/button";
import {useForm} from "@inertiajs/vue3";

const props = defineProps<{
    ad: Subscription
}>()

const deleteForm = useForm({});
const emit = defineEmits<{
    (e: 'delete', id: number): void
}>()
const submitDelete = () => {
    emit('delete', props.ad.id)
    setTimeout(() => {
        deleteForm.post(
            route('subscriptions.delete', {id: props.ad.id}),
            {
                preserveScroll: true,
                onFinish: () => {},
            }
        );
    }, 1000)
};

const toggleStatusForm = useForm({});

const submitToggleStatus = () => {
    toggleStatusForm.post(
        route('subscriptions.toggleStatus', {id: props.ad.id}),
        {
            preserveScroll: true,
            onFinish: () => {
            },
        }
    );
};
</script>

<template>
    <div class="w-full">
        <div class="aspect-[calc(1/1)] w-full">
            <div :style="{ backgroundImage: `url(${props.ad.advertImageUrl})` }"
                 class="w-full h-full bg-cover bg-center">
            </div>
        </div>
        <div class="p-4">
            <div class="truncate">
                <a :href="props.ad.advertUrl" target="_blank">{{ props.ad.advertTitle }}</a>
            </div>
            <div class="mt-4 text-2xl flex justify-between">
                <div class="">
                    <span class="mr-2">{{ props.ad.advertCurrentPrice.amount }}</span>
                    <span class="font-black">{{ props.ad.advertCurrentPrice.currencySymbol }}</span>
                </div>
                <div class="flex items-baseline">
                    <span class="inline-block h-[6px] aspect-square bg-linear-to-r rounded-full"
                          :class="{'from-green-500 to-green-500 ring-green-200/20 ring-5' : props.ad.status === 'active', 'from-gray-800 to-gray-800 ring-gray-200/30 ring-5' : props.ad.status === 'disabled'}"
                    ></span>
                    <span class="ml-4 text-sm"
                          :class="{'text-gray-800/70 dark:text-gray-200/30': props.ad.status === 'disabled'}"
                    >
                        {{ props.ad.status }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex justify-between p-4">
            <form @submit.prevent="submitToggleStatus" class="flex flex-col gap-6">
                <Button type="submit"
                        :tabindex="4"
                        :disabled="toggleStatusForm.processing"
                        class="bg-transparent border-[#3E3E3A] text-gray-800 dark:text-[#EDEDEC] border hover:bg-transparent hover:border-b-gray-950 dark:hover:border-[#62605b]"
                >
                    <LoaderCircle v-if="toggleStatusForm.processing" class="h-4 w-4 animate-spin"/>
                    {{ props.ad.status === 'active' ? 'Disable' : 'Enable' }}
                </Button>
            </form>
            <form @submit.prevent="submitDelete" class="flex flex-col gap-6">
                <Button type="submit"
                        :tabindex="5"
                        :disabled="deleteForm.processing"
                        class="bg-transparent border-[#3E3E3A] text-gray-800 dark:text-[#EDEDEC] border hover:bg-transparent hover:border-b-gray-950 dark:hover:border-[#62605b]"
                >
                    <LoaderCircle v-if="deleteForm.processing" class="h-4 w-4 animate-spin"/>
                    Delete
                </Button>
            </form>
        </div>
    </div>
</template>
