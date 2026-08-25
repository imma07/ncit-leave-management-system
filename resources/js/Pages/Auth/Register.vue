<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Select from 'primevue/select';

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',
    department: '',
    designation: '',
    phone: '',
    address: '',
    password_confirmation: '',
});

const roles = ['admin', 'user'];
const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="role"
                    value="role"
                />

<!--                <TextInput-->
<!--                    id="role"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.role"-->
<!--                    required-->
<!--                    autocomplete="new-password"-->
<!--                />-->

                <Select
                    v-model="form.role"
                    :options="roles"
                    placeholder="Select Role"
                    class="mt-1 w-full"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.role"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="department"
                    value="department"
                />

                <TextInput
                    id="department"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.department"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.department"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="designation"
                    value="designation"
                />

                <TextInput
                    id="designation"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.designation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.designation"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="phone"
                    value="phone"
                />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.phone"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="address"
                    value="address"
                />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.address"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
<!--                <Link-->
<!--                    :href="route('login')"-->
<!--                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"-->
<!--                >-->
<!--                    Already registered?-->
<!--                </Link>-->

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Onboard Employee
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
