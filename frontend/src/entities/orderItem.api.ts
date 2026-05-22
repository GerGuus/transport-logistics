import { api } from '@/shared/api'

export const orderItemApi = {
    getAll() {
        return api.get('/order_items')
    },

    getById(id: number) {
        return api.get(`/order_items/${id}`)
    },

    create(payload: {
        customerOrder: string
        product: string
        quantity: number
        weight: string
        volume: string
    }) {
        return api.post('/order_items', payload)
    },

    update(id: number, payload: Partial<{
        customerOrder: string
        product: string
        quantity: number
        weight: string
        volume: string
    }>) {
        return api.patch(`/order_items/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/order_items/${id}`)
    },
}
