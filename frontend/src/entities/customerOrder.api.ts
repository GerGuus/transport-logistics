import { api } from '@/shared/api'

export const customerOrderApi = {
    getAll() {
        return api.get('/customer_orders')
    },

    getById(id: number) {
        return api.get(`/customer_orders/${id}`)
    },

    create(payload: {
        company: string
        orderDate: string
        status: string
        totalWeight: string
        totalVolume: string
    }) {
        return api.post('/customer_orders', payload)
    },

    update(id: number, payload: Partial<{
        company: string
        orderDate: string
        status: string
        totalWeight: string
        totalVolume: string
    }>) {
        return api.patch(`/customer_orders/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/customer_orders/${id}`)
    },
}
