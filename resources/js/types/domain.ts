import {Pagination} from "@/types/pagination";

export interface Price {
    id: number,
    amount: number,
    currency: string,
    currencySymbol: string,
    advertId: number,
    createdAt: string,
}
export interface Advert {
    id: number,
    title: string,
    url: string,
    imageUrl: string,
    state: string,
    price: Price
}

export interface Subscription {
    id: number,
    userId: number,
    advertUrl: string,
    advertTitle: string,
    advertImageUrl: string,
    advertCurrentPrice: Price,
    startedAt: string,
    status: string,
    notificationEmail: string,
}

export interface SubscriptionPagination extends Pagination {
    data: Subscription[],
}
