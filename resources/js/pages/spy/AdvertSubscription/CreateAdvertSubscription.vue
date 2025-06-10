<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import {Button} from '@/components/ui/button';
import {Input} from '@/components/ui/input';
import {Label} from '@/components/ui/label';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {LoaderCircle} from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import {type BreadcrumbItem, SharedData} from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ads',
        href: '/subscriptions',
    },
    {
        title: 'Create',
        href: '/subscriptions/create',
    },
];

const page = usePage<SharedData>()
const form = useForm({
    url: '',
    email: page.props.auth.user.email,
});

const submit = () => {
    form.post(route('subscriptions.store'), {
        onFinish: () => {
            // form.reset('notificationEmail')
            if (!form.errors) {
                form.reset('url')
            }
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" title="Add new advert subscription"
               description="Enter your email and advert URL below to add new advert subscription">
        <Head title="Ads | Create"/>

        <div class="flex flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
            <div class="w-full max-w-sm">
                <div class="flex flex-col gap-8">
                    <form @submit.prevent="submit" class="flex flex-col gap-6">
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <Label for="email">Email address for notifications</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    required
                                    :tabindex="1"
                                    autocomplete="email"
                                    v-model="form.email"
                                    placeholder="email@example.com"
                                    disabled
                                />
                                <InputError :message="form.errors.email"/>
                            </div>
                            <div class="grid gap-2">
                                <Label for="advert-url">Advert Url</Label>
                                <Input
                                    id="advert-url"
                                    type="url"
                                    required
                                    :tabindex="2"
                                    autocomplete="advert-url"
                                    v-model="form.url"
                                    placeholder="https://..."
                                />
                                <InputError :message="form.errors.url"/>
                            </div>

                            <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
                                Subscribe
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
