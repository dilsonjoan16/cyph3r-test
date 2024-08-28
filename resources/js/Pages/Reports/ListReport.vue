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
                    <table class="border-collapse border border-slate-500 w-full">
                        <thead>
                            <tr>
                                <th class="border border-slate-600">id</th>
                                <th class="border border-slate-600">report</th>
                                <th class="border border-slate-600">begin date</th>
                                <th class="border border-slate-600">end date</th>
                                <th class="border border-slate-600"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="item in items" :key="item.id">
                                <tr>
                                    <td class="border border-slate-700">{{item.id}}</td>
                                    <td class="border border-slate-700">{{item.title}}</td>
                                    <td class="border border-slate-700">{{item.begin_date}}</td>
                                    <td class="border border-slate-700">{{item.end_date}}</td>
                                    <td class="border border-slate-700">
                                        <Link
                                            :href="route('reports.show', {report:item.id})"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            See report
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
