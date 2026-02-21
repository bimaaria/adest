<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { Button } from '@/components/ui/button';
import { Pagination, PaginationContent, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useCategories } from '@/composables/useCategories';
import AppLayout from '@/layouts/AppLayout.vue';
import { categories } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: categories().url,
    },
];

const { categoriesData, editCategory, getCategories, onChangePage, onChangeLimit } = useCategories();

onMounted(async () => {
    categoriesData.value = await getCategories();
});
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <Pagination 
                    :items-per-page="categoriesData.pagination.per_page" 
                    :total="categoriesData.pagination.total" 
                    :default-page="categoriesData.pagination.current_page"
                    class="mt-2"
                >
                    <Select>
                        <div class="flex items-center gap-2">
                            <span class="text-sm">Display</span>
                            <SelectTrigger>
                                <SelectValue :placeholder="categoriesData.pagination.per_page.toString()" />
                            </SelectTrigger>
                            <span class="text-sm">of {{ categoriesData.pagination.total }} categories</span>
                        </div>
                        <SelectContent>
                            <SelectItem 
                                v-for="(limit, index) in [10, 25, 50, 100]" 
                                :default-value="categoriesData.pagination.per_page"
                                :key="index" 
                                :value="limit" 
                                @click="onChangeLimit(limit)"
                            >
                                {{ limit }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <PaginationContent>
                        <PaginationPrevious 
                            @click="onChangePage(categoriesData.pagination.current_page - 1)" :disabled="categoriesData.pagination.current_page === 1" 
                            class="cursor-pointer"
                        />
                        <Select
                            :model-value="categoriesData.pagination.current_page.toString()"
                            @update:model-value="(val) => onChangePage(Number(val))"
                        >
                            <SelectTrigger>
                                <SelectValue :placeholder="categoriesData.pagination.current_page.toString()" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem 
                                    v-for="(page, index) in Math.ceil(categoriesData.pagination.total / categoriesData.pagination.per_page)" 
                                    :key="index" 
                                    :value="page.toString()" 
                                >
                                    {{ page }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <PaginationNext 
                            @click="onChangePage(categoriesData.pagination.current_page + 1)" :disabled="categoriesData.pagination.current_page === Math.ceil(categoriesData.pagination.total / categoriesData.pagination.per_page)" 
                            class="cursor-pointer"
                        />
                    </PaginationContent>
                </Pagination>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead class="w-[100px]">
                                Name
                            </TableHead>
                            <TableHead>Slug</TableHead>
                            <TableHead>Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in categoriesData.data" :key="category.id">
                            <TableCell>{{ category.id }}</TableCell>
                            <TableCell class="font-medium">
                                {{ category.name }}
                            </TableCell>
                            <TableCell>{{ category.slug }}</TableCell>
                            <TableCell>
                                <Button 
                                    class="cursor-pointer"
                                    size="sm" 
                                    variant="outline"
                                    @click="editCategory(category.id)" 
                                >
                                    Edit
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
