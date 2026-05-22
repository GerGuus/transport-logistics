import { api } from '@/shared/api'

export const warehouseApi = {
getAll() {
return api.get('/warehouses')
},

getById(id: number) {
return api.get(`/warehouses/${id}`)
},

create(payload: {
name: string
address: string
company: string
}) {
return api.post('/warehouses', payload)
},

update(id: number, payload: Partial<{
name: string
address: string
company: string
}>) {
return api.patch(`/warehouses/${id}`, payload, {
headers: {
'Content-Type': 'application/merge-patch+json',
},
})
},

remove(id: number) {
return api.delete(`/warehouses/${id}`)
},
}
