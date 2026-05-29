<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const companies = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    name: '',
    address: '',
    company: '',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const [warehousesRes, companiesRes] = await Promise.all([
            api.get('/warehouses'),
            api.get('/companies'),
        ])

        items.value = warehousesRes.data['hydra:member'] ?? warehousesRes.data.member ?? []
        companies.value = companiesRes.data['hydra:member'] ?? companiesRes.data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/warehouses', {
        name: form.name,
        address: form.address,
        company: form.company,
    })

    form.name = ''
    form.address = ''
    form.company = ''

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/warehouses/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Warehouses</h1>

        <div style="display: grid; gap: 8px; max-width: 400px; margin-bottom: 24px;">
            <input v-model="form.name" placeholder="Name" />
            <textarea v-model="form.address" placeholder="Address" />
            <select v-model="form.company">
                <option value="">Select company</option>
                <option
                    v-for="company in companies"
                    :key="company.id"
                    :value="`/api/companies/${company.id}`"
                >
                    {{ company.name }}
                </option>
            </select>
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Company</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.address }}</td>
                <td>{{ item.company }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
