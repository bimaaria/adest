export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    image_path: string;
    category: {
        id: number;
        name: string;
    }
}

export type CreateProduct = Omit<Product, 'id' | 'category'> & {
    category_id: number;
}

export type Pagination = {
    total: number;
    current_page: number;
    per_page: number;
}

export type Status = "success" | "failed";

export type ProductsData = {
    data: Product[];
    pagination: Pagination;
    status: Status;
}
