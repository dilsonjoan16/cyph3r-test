<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number
    },
    title: {
        type: String,
    },
    image:{
        type: String,
    },
    price: {
        type: String,
    },
    tax: {
        type: String,
    },
    description: {
        type: String,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div><h1>{{title}}</h1></div>
                    <div class="mt-4 grid grid-cols-2">
                        <div class="mt-4"><p>{{price}}</p></div>
                        <div class="mt-4"><p>{{tax}}</p></div>
                    </div>
                    <div class="position-relative">
                        <img
                            :src="image ?? '/images/default-product.png'"
                            class="absolute -left-20 top-0 h-6 w-6 rounded-full border-2 border-white"
                        />
                    </div>
                    <div class="mt-4">{{description}}</div>
                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('products.edit', {product:id})"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Edit product
                        </Link>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('products.destroy', {product:id})"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Delete product
                        </Link>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('products.buy', {product:id})"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Buy product
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
