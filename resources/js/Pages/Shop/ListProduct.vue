<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: [Array],
    }
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 mt-2">
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
                            <template v-for="item in items" :key="item.id">
                                <tr>
                                    <td class="position-relative">
                                        <img
                                            :src="item.image ?? '/images/default-product.png'"
                                            class="absolute -left-20 top-0 h-6 w-6 rounded-full border-2 border-white"
                                        />
                                    </td>
                                    <td class="border border-slate-700">{{item.name}}</td>
                                    <td class="border border-slate-700">{{item.price}}</td>
                                    <td class="border border-slate-700">
                                        <Link
                                            :href="route('products.show', {product:item.id})"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            See product
                                        </Link>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
