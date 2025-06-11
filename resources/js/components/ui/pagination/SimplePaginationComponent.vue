<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import {Links, Meta} from "@/types/pagination";

const props = defineProps<{
    links: Links,
    meta: Meta
}>()
const mobileLinks = [props.meta.links[0], props.meta.links[props.meta.links.length-1]]
</script>

<template>
    <nav class="@container relative flex justify-center">
        <template v-for="link in mobileLinks" :key="link.label">
            <Link preserve-scroll
                  :href="link.url ?? ''"
                  v-html="link.label"
                  :class="{ 'bg-gray-400 dark:bg-gray-600': link.active, '!text-gray-400 dark:!text-gray-600': !link.url }"
                  class="flex @lg:hidden mx-5 items-center justify-center rounded-sm border border-[#19140035] px-3 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            />
        </template>
        <template v-for="link in props.meta.links" :key="link.label">
            <Link preserve-scroll
                  :href="link.url ?? ''"
                  v-html="link.label"
                  :class="{ 'bg-gray-400 dark:bg-gray-600': link.active, '!text-gray-400 dark:!text-gray-600': !link.url }"
                  class="hidden @lg:flex items-center justify-center rounded-sm border border-[#19140035] px-3 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            />
        </template>
    </nav>
</template>
