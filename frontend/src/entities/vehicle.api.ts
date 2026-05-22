import { api } from '@/shared/api'

export const vehicleApi = {
    getAll() {
        return api.get('/vehicles')
    },

    getById(id: number) {
        return api.get(`/vehicles/${id}`)
    },

    create(payload: {
        plateNumber: string
        type: string
        capacityWeight: string
        capacityVolume: string
        status: string
    }) {
        return api.post('/vehicles', payload)
    },

    update(id: number, payload: Partial<{
        plateNumber: string
        type: string
        capacityWeight: string
        capacityVolume: string
        status: string
    }>) {
        return api.patch(`/vehicles/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/vehicles/${id}`)
    },
}
