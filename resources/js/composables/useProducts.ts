import { router } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import axios from 'axios';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import * as z from 'zod';
import type { CreateProduct, ProductsData } from '@/types';

export function useProducts() {
    // states
    const productsData = ref<ProductsData>({
        data: [],
        pagination: {
            total: 0,
            current_page: 1,
            per_page: 10,
        },
        status: 'success',
    });

    const uploadedImagePath = ref<string | null>(null);

    // services
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

    async function createProduct(data: CreateProduct) {
        try {
            const products = await axios.post('/api/products', data);

            return products.data;
        } catch (error) {
            throw error;
        }
    }

    // handlers
    async function onChangePage(page: number) {
        productsData.value = await getProducts(page, productsData.value.pagination.per_page);
        productsData.value.pagination.current_page = page;
    }

    async function onChangeLimit(limit: number) {
        productsData.value = await getProducts(1, limit);
        productsData.value.pagination.current_page = 1;
    }

    function addProduct() {
        router.visit(`/products/create`);
    }

    function editProduct(id: number) {
        router.visit(`/products/${id}/edit`);
    }

    function onCancel() {
        router.visit(`/products`);
    }

    // form
    const formSchema = toTypedSchema(z.object({
        name: z.string().min(3).max(100),
        description: z.string().min(3),
        price: z.number().min(1),
        stock: z.number().min(1),
        category_id: z.number().min(1),
        image_path: z.string().optional(),
    }))

    const form = useForm({
        validationSchema: formSchema,
        initialValues: {
            name: '',
            description: '',
            price: 0,
            stock: 0,
            category_id: 0,
            image_path: '',
        },
    })

    async function onFileChange(event: Event) {
        const target = event.target as HTMLInputElement;
        const file = target.files?.[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        const res = await axios.post('/api/products/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        console.log(res.data);
        uploadedImagePath.value = res.data.path;
    }

    const onSubmit = form.handleSubmit(async (values) => {
        try {
            const payload = {
                ...values,
                image_path: uploadedImagePath.value || '',
            };

            await createProduct(payload);
            router.visit('/products');
        } catch (error) {
            console.error(error);
        }
    })

    return {
        form,
        productsData,
        createProduct,
        getProducts,
        onChangePage,
        onChangeLimit,
        addProduct,
        editProduct,
        onCancel,
        onSubmit,
        onFileChange,
    };
}
