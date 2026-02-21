export type Product = {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
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
