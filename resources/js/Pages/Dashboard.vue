<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const userRole = usePage().props.auth?.user?.role ?? null;
const flash = usePage().props.flash;

onMounted(() => {
    if (flash?.success) {
        toast.add({ severity: 'success', summary: 'Success', detail: flash.success, life: 4000 });
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <Toast />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard

                <Link class="bg-blue-500 text-white ml-8 px-4 py-2 rounded" v-if="userRole === 'admin'"   href="/register">User onboard</Link>
                <Link class="bg-blue-500 text-white ml-8 px-4 py-2 rounded" v-if="userRole === 'admin'"   href="/register">Leave Requests</Link>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
