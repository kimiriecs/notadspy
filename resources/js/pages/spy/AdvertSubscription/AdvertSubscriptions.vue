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
</script>

<template>
    <Head title="Advert Subscriptions" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="@container flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min justify-center gap-4 @lg:grid-cols-2 @2xl:grid-cols-3 @4xl:grid-cols-4 @5xl:grid-cols-5">
                <div v-for="(item, key) in props.ads.data" :key="key" class="flex justify-center">
                    <AdvertSubscriptionCard :ad="item" class="max-w-[300px] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border" />
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
