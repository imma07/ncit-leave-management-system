<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import DatePicker from 'primevue/datepicker';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, computed } from "vue";

const today = new Date();
today.setHours(0, 0, 0, 0);

const props = defineProps({ leaveTypes: Array, leaveRequests: Array });

const leaveRequests = computed(() => props.leaveRequests ?? []);

const form = useForm({
    leave_type_id: null,
    start_date: null,
    end_date: null,
    reason: null,
});

const visible = ref(false);

const formatDate = (dateStr) => {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
};
const toast = useToast();
const userRole = usePage().props.auth?.user?.role ?? null;
const flash = usePage().props.flash;



onMounted(() => {
    if (flash?.success) {
        toast.add({ severity: 'success', summary: 'Success', detail: flash.success, life: 4000 });
    }
});


const save = () => {
    form.post(route('leave-requests.store'), {
        onSuccess: () => {
            visible.value = false;
            form.reset();
            toast.add({ severity: 'success', summary: 'Success', detail: 'Leave request submitted successfully.', life: 3000 });
        },
        onError: (errors) => {
            const message = Object.values(errors)[0];
            toast.add({ severity: 'error', summary: 'Request Denied', detail: message, life: 5000 });
        },
    });
};
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

                <Button @click="visible = true" class="bg-blue-500 text-white ml-8 px-4 py-2 rounded" v-if="userRole === 'user'">Request for leave</Button>
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
                <div class="w-full">
                    <DataTable :value="leaveRequests" tableStyle="min-width: 50rem">
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
                    </DataTable>
                </div>
            </div>
        </div>

        <Dialog v-model:visible="visible" modal header="Edit Profile" :style="{ width: '24rem' }">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label for="leave_type">Leave Type</label>
                    <Select
                        id="leave_type"
                        v-model="form.leave_type_id"
                        :options="props.leaveTypes"
                        option-label="name"
                        option-value="id"
                        placeholder="Select Leave Type"
                        class="w-full"
                    />
                </div>
                <div class="flex flex-col gap-1.5">
                    <Label for="email">Reason</Label>
                    <InputText id="email" v-model="form.reason" class="w-full" />
                </div>

                <div class="flex flex-col gap-1.5">
                    <Label for="email">Start Date</Label>
                    <DatePicker  id="start_date" v-model="form.start_date" class="w-full" />

                </div>


                <div class="flex flex-col gap-1.5">
                    <Label for="email">Start Date</Label>
                    <DatePicker  id="end_date" v-model="form.end_date" class="w-full" />

                </div>
            </div>
            <template #footer>
                <Button severity="secondary" variant="outlined" @click="visible = false">Cancel</Button>
                <Button @click="save()">Save</Button>
            </template>
        </Dialog>
    </AuthenticatedLayout>
</template>
