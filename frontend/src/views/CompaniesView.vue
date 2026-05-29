<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    name: '',
    type: 'client',
    contactPerson: '',
    phone: '',
    email: '',
    address: '',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const { data } = await api.get('/companies')
        items.value = data['hydra:member'] ?? data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/companies', {
        name: form.name,
        type: form.type,
        contactPerson: form.contactPerson || null,
        phone: form.phone || null,
        email: form.email || null,
        address: form.address || null,
    })

    form.name = ''
    form.type = 'client'
    form.contactPerson = ''
    form.phone = ''
    form.email = ''
    form.address = ''

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/companies/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Companies</h1>

        <div style="display: grid; gap: 8px; max-width: 420px; margin-bottom: 24px;">
            <input v-model="form.name" placeholder="Name" />
            <select v-model="form.type">
                <option value="client">client</option>
                <option value="supplier">supplier</option>
                <option value="carrier">carrier</option>
            </select>
            <input v-model="form.contactPerson" placeholder="Contact person" />
            <input v-model="form.phone" placeholder="Phone" />
            <input v-model="form.email" placeholder="Email" />
            <textarea v-model="form.address" placeholder="Address" />
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Contact</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.type }}</td>
                <td>{{ item.contactPerson }}</td>
                <td>{{ item.phone }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.address }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
