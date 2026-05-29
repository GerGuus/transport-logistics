<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const companies = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    company: '',
    orderDate: '',
    status: 'new',
    totalWeight: '',
    totalVolume: '',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const [ordersRes, companiesRes] = await Promise.all([
            api.get('/customer_orders'),
            api.get('/companies'),
        ])

        items.value = ordersRes.data['hydra:member'] ?? ordersRes.data.member ?? []
        companies.value = companiesRes.data['hydra:member'] ?? companiesRes.data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/customer_orders', {
        company: form.company,
        orderDate: form.orderDate,
        status: form.status,
        totalWeight: form.totalWeight,
        totalVolume: form.totalVolume,
    })

    form.company = ''
    form.orderDate = ''
    form.status = 'new'
    form.totalWeight = ''
    form.totalVolume = ''

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/customer_orders/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Orders</h1>

        <div style="display: grid; gap: 8px; max-width: 420px; margin-bottom: 24px;">
            <select v-model="form.company">
                <option value="">Select company</option>
                <option v-for="company in companies" :key="company.id" :value="`/api/companies/${company.id}`">
                    {{ company.name }}
                </option>
            </select>
            <input v-model="form.orderDate" type="datetime-local" />
            <select v-model="form.status">
                <option value="new">new</option>
                <option value="in_progress">in_progress</option>
                <option value="done">done</option>
            </select>
            <input v-model="form.totalWeight" placeholder="Total weight" />
            <input v-model="form.totalVolume" placeholder="Total volume" />
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Order date</th>
                <th>Status</th>
                <th>Total weight</th>
                <th>Total volume</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.company }}</td>
                <td>{{ item.orderDate }}</td>
                <td>{{ item.status }}</td>
                <td>{{ item.totalWeight }}</td>
                <td>{{ item.totalVolume }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
