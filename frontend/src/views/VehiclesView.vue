<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    plateNumber: '',
    type: '',
    capacityWeight: '',
    capacityVolume: '',
    status: 'available',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const { data } = await api.get('/vehicles')
        items.value = data['hydra:member'] ?? data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/vehicles', {
        plateNumber: form.plateNumber,
        type: form.type,
        capacityWeight: form.capacityWeight,
        capacityVolume: form.capacityVolume,
        status: form.status,
    })

    form.plateNumber = ''
    form.type = ''
    form.capacityWeight = ''
    form.capacityVolume = ''
    form.status = 'available'

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/vehicles/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Vehicles</h1>

        <div style="display: grid; gap: 8px; max-width: 420px; margin-bottom: 24px;">
            <input v-model="form.plateNumber" placeholder="Plate number" />
            <input v-model="form.type" placeholder="Type" />
            <input v-model="form.capacityWeight" placeholder="Capacity weight" />
            <input v-model="form.capacityVolume" placeholder="Capacity volume" />
            <select v-model="form.status">
                <option value="available">available</option>
                <option value="in_use">in_use</option>
                <option value="maintenance">maintenance</option>
            </select>
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Plate</th>
                <th>Type</th>
                <th>Weight</th>
                <th>Volume</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.plateNumber }}</td>
                <td>{{ item.type }}</td>
                <td>{{ item.capacityWeight }}</td>
                <td>{{ item.capacityVolume }}</td>
                <td>{{ item.status }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
