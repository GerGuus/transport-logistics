<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    firstName: '',
    lastName: '',
    phone: '',
    licenseNumber: '',
    status: 'available',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const { data } = await api.get('/drivers')
        items.value = data['hydra:member'] ?? data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/drivers', {
        firstName: form.firstName,
        lastName: form.lastName,
        phone: form.phone,
        licenseNumber: form.licenseNumber,
        status: form.status,
    })

    form.firstName = ''
    form.lastName = ''
    form.phone = ''
    form.licenseNumber = ''
    form.status = 'available'

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/drivers/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Drivers</h1>

        <div style="display: grid; gap: 8px; max-width: 420px; margin-bottom: 24px;">
            <input v-model="form.firstName" placeholder="First name" />
            <input v-model="form.lastName" placeholder="Last name" />
            <input v-model="form.phone" placeholder="Phone" />
            <input v-model="form.licenseNumber" placeholder="License number" />
            <select v-model="form.status">
                <option value="available">available</option>
                <option value="in_trip">in_trip</option>
                <option value="inactive">inactive</option>
            </select>
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Phone</th>
                <th>License</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.firstName }}</td>
                <td>{{ item.lastName }}</td>
                <td>{{ item.phone }}</td>
                <td>{{ item.licenseNumber }}</td>
                <td>{{ item.status }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
