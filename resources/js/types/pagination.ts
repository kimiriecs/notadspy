export interface Links {
    first: string,
    last: string,
    prev: string|null,
    next: string|null
}

export interface MetaLink {
    url: string|null,
    label: string,
    active: boolean
}

export interface Meta {
    current_page: number,
    from: number|null,
    last_page: number,
    links: MetaLink[],
    path: string,
    per_page: number,
    to: number|null,
    total: number
}

export interface Pagination {
    data: object[],
    links: Links,
    meta: Meta
}
