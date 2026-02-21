<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
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

const { editCategory } = useCategories();
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <Table>
                    <TableCaption>A list of your categories.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead class="w-[100px]">
                                Name
                            </TableHead>
                            <TableHead>Slug</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow>
                            <TableCell>1</TableCell>
                            <TableCell class="font-medium">
                                Category 1
                            </TableCell>
                            <TableCell>category-1</TableCell>
                            <TableCell>Description 1</TableCell>
                            <TableCell>
                                <Button 
                                    class="cursor-pointer"
                                    size="sm" 
                                    variant="outline"
                                    @click="editCategory(1)" 
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
