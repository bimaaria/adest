export type Category = {
    id: number;
    name: string;
    slug: string;
}

export type Pagination = {
    total: number;
    current_page: number;
    per_page: number;
}

export type Status = "success" | "failed";

export type CategoriesData = {
    data: Category[];
    pagination: Pagination;
    status: Status;
}
