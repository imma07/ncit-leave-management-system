<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3';
import { onMounted, computed } from 'vue';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Select from 'primevue/select';

const props = defineProps({ users: Array, leaveRequests: Array });

const users = computed(() => props.users ?? []);
const leaveRequests = computed(() => props.leaveRequests ?? []);

const toast = useToast();
const userRole = usePage().props.auth?.user?.role ?? null;
const flash = usePage().props.flash;

const statusOptions = [
    { label: 'Pending',  value: 'pending' },
    { label: 'Approved', value: 'approved' },
    { label: 'Rejected', value: 'rejected' },
];

onMounted(() => {
    if (flash?.success) {
        toast.add({ severity: 'success', summary: 'Success', detail: flash.success, life: 4000 });
    }
});

const formatDate = (dateStr) => {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
};

const updateStatus = (leaveRequest, newStatus) => {
    router.patch(route('leave-requests.update-status', leaveRequest.id), { status: newStatus }, {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Updated', detail: `Status changed to ${newStatus}.`, life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update status.', life: 4000 });
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <Toast />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
                <Link class="bg-blue-500 text-white ml-8 px-4 py-2 rounded" v-if="userRole === 'admin'" href="/register">User Onboard</Link>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex flex-col gap-8">

                <!-- Users Table -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Users</h3>
                    <DataTable :value="users" tableStyle="min-width: 40rem" :paginator="true" :rows="10">
                        <Column field="name" header="Name" />
                        <Column field="email" header="Email" />
                        <Column field="department" header="Department" />
                        <Column field="designation" header="Designation" />
                    </DataTable>
                </div>

                <!-- Leave Requests Table -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Leave Requests</h3>
                    <DataTable :value="leaveRequests" tableStyle="min-width: 40rem" :paginator="true" :rows="10">
                        <Column field="user.name" header="Employee" />
                        <Column field="leave_type.name" header="Leave Type" />
                        <Column header="Start Date">
                            <template #body="{ data }">{{ formatDate(data.start_date) }}</template>
                        </Column>
                        <Column header="End Date">
                            <template #body="{ data }">{{ formatDate(data.end_date) }}</template>
                        </Column>
                        <Column header="Status">
                            <template #body="{ data }">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold capitalize"
                                    :class="{
                                        'bg-green-100 text-green-700':  data.status === 'pending',
                                        'bg-blue-100 text-blue-700':    data.status === 'approved',
                                        'bg-red-100 text-red-700':      data.status === 'rejected',
                                    }"
                                >{{ data.status }}</span>
                            </template>
                        </Column>
                        <Column header="Update Status">
                            <template #body="{ data }">
                                <Select
                                    :modelValue="data.status"
                                    :options="statusOptions"
                                    option-label="label"
                                    option-value="value"
                                    placeholder="Change status"
                                    class="w-40"
                                    @update:modelValue="(val) => updateStatus(data, val)"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>