import { router } from '@inertiajs/vue3';

export function useCategories() {
    function editCategory(id: number) {
        // your logic here, e.g. navigate or open a modal
        router.visit(`/categories/${id}/edit`);
    }

    return { editCategory };
}
