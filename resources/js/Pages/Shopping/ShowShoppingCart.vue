<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: String,
    },
    date: {
        type: String,
    },
    user: {
        type: String,
    },
    products: {
        type: [Array],
    },
    total: {
        type: String,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Shoping" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Shoping cart</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="mt-4">{{user}}</div>
                    <div class="mt-4">{{date}}</div>
                    <div class="mt-4">{{total}}</div>
                    <div class="position-relative">
                        <table class="border-collapse border border-slate-500 w-full">
                            <thead>
                                <tr>
                                    <th class="border border-slate-600">product</th>
                                    <th class="border border-slate-600">title</th>
                                    <th class="border border-slate-600">price</th>
                                    <th class="border border-slate-600"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="product in products" :key="product.id">
                                    <tr>
                                        <td class="position-relative">
                                            <img
                                                :src="product.image ?? '/images/default-product.png'"
                                                class="absolute -left-20 top-0 h-6 w-6 rounded-full border-2 border-white"
                                            />
                                        </td>
                                        <td class="border border-slate-700">{{product.name}}</td>
                                        <td class="border border-slate-700">{{product.price}}</td>
                                        <td class="border border-slate-700">
                                            <Link
                                                :href="route('shopping.delete-product', {shopping:id, product: product.id})"
                                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                delete
                                            </Link>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('shopping.complete', {shopping:id})"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            buy
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
