<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    name: '',
    weight: '',
    volume: '',
    description: '',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const { data } = await api.get('/products')
        items.value = data['hydra:member'] ?? data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/products', {
        name: form.name,
        weight: form.weight,
        volume: form.volume,
        description: form.description || null,
    })

    form.name = ''
    form.weight = ''
    form.volume = ''
    form.description = ''

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/products/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Products</h1>

        <div style="display: grid; gap: 8px; max-width: 400px; margin-bottom: 24px;">
            <input v-model="form.name" placeholder="Name" />
            <input v-model="form.weight" placeholder="Weight" />
            <input v-model="form.volume" placeholder="Volume" />
            <textarea v-model="form.description" placeholder="Description" />
            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Weight</th>
                <th>Volume</th>
                <th>Description</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.weight }}</td>
                <td>{{ item.volume }}</td>
                <td>{{ item.description }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
