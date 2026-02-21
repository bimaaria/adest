import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { type ProductsData } from '@/types';

export function useProducts() {
    const productsData = ref<ProductsData>({
        data: [],
        pagination: {
            total: 0,
            current_page: 1,
            per_page: 10,
        },
        status: 'success',
    });

    async function getProducts(page: number = 1, limit: number = 10) {
        if (typeof page !== 'number' || typeof limit !== 'number') {
            throw new Error('Invalid page or limit');
        }

        if (page < 1 || limit < 1) {
            throw new Error('Page and limit must be greater than 0');
        }

        try {
            const products = await axios.get('/api/products', {
                params: {
                    page,
                    limit,
                },
            });

            return products.data;
        } catch (error) {
            throw error;
        }
    }

    async function onChangePage(page: number) {
        productsData.value = await getProducts(page, productsData.value.pagination.per_page);
        productsData.value.pagination.current_page = page;
    }

    async function onChangeLimit(limit: number) {
        productsData.value = await getProducts(1, limit);
        productsData.value.pagination.current_page = 1;
    }

    function editProduct(id: number) {
        router.visit(`/products/${id}/edit`);
    }

    return { productsData, editProduct, getProducts, onChangePage, onChangeLimit };
}
