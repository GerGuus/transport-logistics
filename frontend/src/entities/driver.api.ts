import { api } from '@/shared/api'

export const driverApi = {
    getAll() {
        return api.get('/drivers')
    },

    getById(id: number) {
        return api.get(`/drivers/${id}`)
    },

    create(payload: {
        firstName: string
        lastName: string
        phone: string
        licenseNumber: string
        status: string
    }) {
        return api.post('/drivers', payload)
    },

    update(id: number, payload: Partial<{
        firstName: string
        lastName: string
        phone: string
        licenseNumber: string
        status: string
    }>) {
        return api.patch(`/drivers/${id}`, payload, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
            },
        })
    },

    remove(id: number) {
        return api.delete(`/drivers/${id}`)
    },
}
