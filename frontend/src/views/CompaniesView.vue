<script setup lang="ts">
import { onMounted, reactive } from 'vue'
import { useCompanyStore } from '@/entities/company/company.store'

const store = useCompanyStore()

const form = reactive({
    name: '',
    type: 'client',
    contactPerson: '',
    phone: '',
    email: '',
    address: '',
})

const submit = async () => {
    await store.create({ ...form })

    form.name = ''
    form.type = 'client'
    form.contactPerson = ''
    form.phone = ''
    form.email = ''
    form.address = ''
}

onMounted(() => {
    store.fetchAll()
})
</script>

<template>
    <div>
        <h1>Companies</h1>

        <form @submit.prevent="submit">
            <input v-model="form.name" placeholder="Name" />
            <input v-model="form.type" placeholder="Type" />
            <input v-model="form.contactPerson" placeholder="Contact person" />
            <input v-model="form.phone" placeholder="Phone" />
            <input v-model="form.email" placeholder="Email" />
            <input v-model="form.address" placeholder="Address" />
            <button type="submit">Create</button>
        </form>

        <div v-if="store.loading">Loading...</div>

        <ul v-else>
            <li v-for="company in store.items" :key="company.id">
                {{ company.name }} — {{ company.type }}
                <button @click="store.remove(company.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>
