<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    begin_date: '',
    end_date: '',
});

const submit = () => {
    form.post(route('reports.store'), {
        onFinish: () => form.reset(
            'title',
            'begin_date',
            'end_date',
        ),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                                autofocus
                                autocomplete="Product title"
                            />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="begin_date" value="Begin Date" />
                            <input
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="date"
                                name="begin_date"
                                id="begin_date"
                                v-model="form.begin_date"
                                required>
                            <InputError class="mt-2" :message="form.errors.begin_date" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="end_date" value="End Date" />
                            <input
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="date"
                                name="end_date"
                                id="end_date"
                                v-model="form.end_date"
                                required>
                            <InputError class="mt-2" :message="form.errors.end_date" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                create product
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
