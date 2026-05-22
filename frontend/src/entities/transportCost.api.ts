import { api } from '@/shared/api'

export const transportCostApi = {
    getAll() {
        return api.get('/transport_costs')
    },

    getById(id: number) {
        return api.get(`/transport_costs/${id}`)
    },

    create(payload: {
        shipment: string
        fuelCost: string
        driverCost: string
        maintenanceCost: string
        totalCost: string
    }) {
        return api.post('/transport_costs', payload)
    },

    update(id: number, payload: Partial<{
        shipment: string
        fuelCost: string
        driverCost: string
        maintenanceCost: string
        totalCost: string
    }>) {
        return api.patch(`/transport_costs/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/transport_costs/${id}`)
    },
}
