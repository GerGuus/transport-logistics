import { api } from '@/shared/api'

export const shipmentApi = {
    getAll() {
        return api.get('/shipments')
    },

    getById(id: number) {
        return api.get(`/shipments/${id}`)
    },

    create(payload: {
        customerOrder: string
        driver: string
        vehicle: string
        departureWarehouse: string
        arrivalWarehouse: string
        departureTime: string
        arrivalTime: string
        status: string
    }) {
        return api.post('/shipments', payload)
    },

    update(id: number, payload: Partial<{
        customerOrder: string
        driver: string
        vehicle: string
        departureWarehouse: string
        arrivalWarehouse: string
        departureTime: string
        arrivalTime: string
        status: string
    }>) {
        return api.patch(`/shipments/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/shipments/${id}`)
    },
}
