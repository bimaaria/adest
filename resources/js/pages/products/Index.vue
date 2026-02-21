<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { Button } from '@/components/ui/button';
import { Pagination, PaginationContent, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useProducts } from '@/composables/useProducts';
import AppLayout from '@/layouts/AppLayout.vue';
import { products } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: products().url,
    },
];

const { productsData, editProduct, getProducts, onChangePage, onChangeLimit } = useProducts();

onMounted(async () => {
    productsData.value = await getProducts();
});
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col justify-between gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
            
                <Pagination 
                    :items-per-page="productsData.pagination.per_page" 
                    :total="productsData.pagination.total" 
                    :default-page="productsData.pagination.current_page"
                    class="mt-2"
                >
                    <Select>
                        <div class="flex items-center gap-2">
                            <span class="text-sm">Display</span>
                            <SelectTrigger>
                                <SelectValue :placeholder="productsData.pagination.per_page.toString()" />
                            </SelectTrigger>
                            <span class="text-sm">of {{ productsData.pagination.total }} products</span>
                        </div>
                        <SelectContent>
                            <SelectItem 
                                v-for="(limit, index) in [10, 25, 50, 100]" 
                                :default-value="productsData.pagination.per_page"
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
                            @click="onChangePage(productsData.pagination.current_page - 1)" :disabled="productsData.pagination.current_page === 1" 
                            class="cursor-pointer"
                        />
                        <Select
                            :model-value="productsData.pagination.current_page.toString()"
                            @update:model-value="(val) => onChangePage(Number(val))"
                        >
                            <SelectTrigger>
                                <SelectValue :placeholder="productsData.pagination.current_page.toString()" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem 
                                    v-for="(page, index) in Math.ceil(productsData.pagination.total / productsData.pagination.per_page)" 
                                    :key="index" 
                                    :value="page.toString()" 
                                >
                                    {{ page }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <PaginationNext 
                            @click="onChangePage(productsData.pagination.current_page + 1)" :disabled="productsData.pagination.current_page === Math.ceil(productsData.pagination.total / productsData.pagination.per_page)" 
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
                            <TableHead>Description</TableHead>
                            <TableHead class="text-right">Price</TableHead>
                            <TableHead>Stock</TableHead>
                            <TableHead>Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="product in productsData.data" :key="product.id">
                            <TableCell>{{ product.id }}</TableCell>
                            <TableCell class="font-medium">
                                {{ product.name }}
                            </TableCell>
                            <TableCell>{{ product.description }}</TableCell>
                            <TableCell class="text-right">{{ product.price }}</TableCell>
                            <TableCell>
                                {{ product.stock }}
                            </TableCell>
                            <TableCell>
                                <Button 
                                    class="cursor-pointer"
                                    size="sm" 
                                    variant="outline"
                                    @click="editProduct(product.id)" 
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
