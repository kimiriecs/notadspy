<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AdvertSubscriptionCard from '@/components/AdvertSubscriptionCard.vue';
import {SubscriptionPagination} from '@/types/domain';
import {SimplePaginationComponent} from "@/components/ui/pagination";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ads',
        href: '/subscriptions',
    },
];

const page = usePage<SharedData>()

const props = defineProps<{
    ads: SubscriptionPagination
}>()

const deleteItem = (id: number) => {
    props.ads.data = props.ads.data.filter((i) => i.id !== id)
}
</script>

<template>
    <Head title="Advert Subscriptions" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="@container w-full h-full flex flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-center">
                <div class="relative w-full flex flex-wrap justify-start @5xl:max-w-6xl">
                    <TransitionGroup name="fade">
                        <div v-for="item in props.ads.data"
                             :key="item.id"
                             class="flex justify-center p-2 w-full @lg:w-1/2 @2xl:w-1/3 @4xl:w-1/4 @5xl:w-1/5"
                        >
                            <AdvertSubscriptionCard
                                @delete="deleteItem"
                                :ad="item"
                                class="max-w-[300px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"/>
                        </div>
                    </TransitionGroup>
                </div>
            </div>
            <div class="w-full @max-lg:flex @max-lg:justify-center">
                <Link v-if="page.props.auth.user"
                    :href="route('subscriptions.create')"
                    class="@max-lg:w-full @max-lg:max-w-[300px] @max-lg:text-center @md:inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    New
                </Link>
            </div>
        </div>
        <div class="py-6">
            <SimplePaginationComponent :links="props.ads.links" :meta="props.ads.meta"/>
        </div>
    </AppLayout>
</template>
<style>
.fade-move,
.fade-enter-active,
.fade-leave-active {
    transition: all 1s cubic-bezier(0.55, 0, 0.1, 1);
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0);
}

.fade-leave-active {
    position: absolute;
}
</style>
