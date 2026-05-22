import { api } from '@/shared/api'

export const productApi = {
    getAll() {
        return api.get('/products')
    },

    getById(id: number) {
        return api.get(`/products/${id}`)
    },

    create(payload: {
        name: string
        weight: string
        volume: string
        description?: string
    }) {
        return api.post('/products', payload)
    },

    update(id: number, payload: Partial<{
        name: string
        weight: string
        volume: string
        description: string
    }>) {
        return api.patch(`/products/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/products/${id}`)
    },
}
