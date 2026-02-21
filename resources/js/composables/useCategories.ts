import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import type { CategoriesData } from '@/types/category';

export function useCategories() {
    const categoriesData = ref<CategoriesData>({
        data: [],
        pagination: {
            total: 0,
            current_page: 1,
            per_page: 10,
        },
        status: 'success',
    });

    async function getCategories(page: number = 1, limit: number = 10) {
        if (typeof page !== 'number' || typeof limit !== 'number') {
            throw new Error('Invalid page or limit');
        }

        if (page < 1 || limit < 1) {
            throw new Error('Page and limit must be greater than 0');
        }

        try {
            const categories = await axios.get('/api/categories', {
                params: {
                    page,
                    limit,
                },
            });

            return categories.data;
        } catch (error) {
            throw error;
        }
    }

    async function onChangePage(page: number) {
        categoriesData.value = await getCategories(page, categoriesData.value.pagination.per_page);
        categoriesData.value.pagination.current_page = page;
    }

    async function onChangeLimit(limit: number) {
        categoriesData.value = await getCategories(1, limit);
        categoriesData.value.pagination.current_page = 1;
    }

    function editCategory(id: number) {
        router.visit(`/categories/${id}/edit`);
    }

    return { categoriesData, editCategory, getCategories, onChangePage, onChangeLimit };
}
