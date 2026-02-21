import { router } from '@inertiajs/vue3';

export function useProducts() {
    function editProduct(id: number) {
        // your logic here, e.g. navigate or open a modal
        router.visit(`/products/${id}/edit`);
    }

    return { editProduct };
}
