import { router } from '@inertiajs/vue3';

export function useTransactions() {
    function editTransaction(id: number) {
        // your logic here, e.g. navigate or open a modal
        router.visit(`/transactions/${id}/edit`);
    }

    return { editTransaction };
}
