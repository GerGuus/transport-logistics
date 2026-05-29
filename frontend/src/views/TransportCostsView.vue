<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const shipments = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    shipment: '',
    fuelCost: '',
    driverCost: '',
    maintenanceCost: '',
    totalCost: '',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const [costsRes, shipmentsRes] = await Promise.all([
            api.get('/transport_costs'),
            api.get('/shipments'),
        ])

        items.value = costsRes.data['hydra:member'] ?? costsRes.data.member ?? []
        shipments.value = shipmentsRes.data['hydra:member'] ?? shipmentsRes.data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/transport_costs', {
        shipment: form.shipment,
        fuelCost: form.fuelCost,
        driverCost: form.driverCost,
        maintenanceCost: form.maintenanceCost,
        totalCost: form.totalCost,
    })

    form.shipment = ''
    form.fuelCost = ''
    form.driverCost = ''
    form.maintenanceCost = ''
    form.totalCost = ''

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/transport_costs/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Transport Costs</h1>

        <div style="display: grid; gap: 8px; max-width: 420px; margin-bottom: 24px;">
            <select v-model="form.shipment">
                <option value="">Select shipment</option>
                <option v-for="shipment in shipments" :key="shipment.id" :value="`/api/shipments/${shipment.id}`">
                    Shipment #{{ shipment.id }}
                </option>
            </select>
            <input v-model="form.fuelCost" placeholder="Fuel cost" />
            <input v-model="form.driverCost" placeholder="Driver cost" />
            <input v-model="form.maintenanceCost" placeholder="Maintenance cost" />
            <input v-model="form.totalCost" placeholder="Total cost" />
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Shipment</th>
                <th>Fuel</th>
                <th>Driver</th>
                <th>Maintenance</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.shipment }}</td>
                <td>{{ item.fuelCost }}</td>
                <td>{{ item.driverCost }}</td>
                <td>{{ item.maintenanceCost }}</td>
                <td>{{ item.totalCost }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
