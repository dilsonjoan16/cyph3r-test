<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { vModelSelect } from 'vue';

defineProps({
    brands: {
        type: Array,
    },
    categories: {
        type: Array,
    },
});

const form = useForm({
    title: '',
    cost: '',
    price: '',
    tax: '',
    description: '',
    image: null,
    quantity: '',
    brand: '',
    category: '',
    status: '',
});

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};

const submit = () => {
    form.post(route('products.store'), {
        onFinish: () => form.reset(
            'title',
            'cost',
            'price',
            'tax',
            'description',
            'image',
            'quantity',
            'brand',
            'category',
            'status',
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
                    <form enctype="multipart/form-data" @submit.prevent="submit">
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
                        <div class="mt-4 grid grid-cols-3">
                            <div class="mt-4">
                                <InputLabel for="cost" value="Product cost" />
                                <TextInput
                                    id="cost"
                                    type="number"
                                    class="mt-1"
                                    v-model="form.cost"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.cost" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="price" value="Profit rate" />
                                <TextInput
                                    id="price"
                                    type="number"
                                    max="100"
                                    class="mt-1"
                                    v-model="form.price"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="tax" value="Tax rate" />
                                <TextInput
                                    id="tax"
                                    type="number"
                                    max="100"
                                    class="mt-1"
                                    v-model="form.tax"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.tax" />
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-4">
                            <div class="mt-4">
                                <InputLabel for="quantity" value="Quantity" />
                                <TextInput
                                    id="quantity"
                                    type="number"
                                    class="mt-1"
                                    v-model="form.quantity"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.quantity" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="brand" value="Brand" />
                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.brand"
                                >
                                    <option v-for="option in brands" :key="option.id" :value="option.id">
                                        {{ option.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.brand" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="category" value="Category" />
                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.category"
                                >
                                    <option v-for="option in categories" :key="option.id" :value="option.id">
                                        {{ option.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="status" value="Status" />
                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.status"
                                >
                                    <option value="0">Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />
                            <Textarea
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                                autocomplete="$0.00"
                            />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="image" value="Image" />
                            <input
                                id="image"
                                type="file"
                                class="mt-1"
                                @change="handleFileChange"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Product
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
