<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue'
import { api } from '@/shared/api'

const items = ref<any[]>([])
const orders = ref<any[]>([])
const drivers = ref<any[]>([])
const vehicles = ref<any[]>([])
const warehouses = ref<any[]>([])
const loading = ref(false)

const form = reactive({
    customerOrder: '',
    driver: '',
    vehicle: '',
    departureWarehouse: '',
    arrivalWarehouse: '',
    departureTime: '',
    arrivalTime: '',
    status: 'planned',
})

const fetchAll = async () => {
    loading.value = true
    try {
        const [
            shipmentsRes,
            ordersRes,
            driversRes,
            vehiclesRes,
            warehousesRes,
        ] = await Promise.all([
            api.get('/shipments'),
            api.get('/customer_orders'),
            api.get('/drivers'),
            api.get('/vehicles'),
            api.get('/warehouses'),
        ])

        items.value = shipmentsRes.data['hydra:member'] ?? shipmentsRes.data.member ?? []
        orders.value = ordersRes.data['hydra:member'] ?? ordersRes.data.member ?? []
        drivers.value = driversRes.data['hydra:member'] ?? driversRes.data.member ?? []
        vehicles.value = vehiclesRes.data['hydra:member'] ?? vehiclesRes.data.member ?? []
        warehouses.value = warehousesRes.data['hydra:member'] ?? warehousesRes.data.member ?? []
    } finally {
        loading.value = false
    }
}

const createItem = async () => {
    await api.post('/shipments', {
        customerOrder: form.customerOrder,
        driver: form.driver,
        vehicle: form.vehicle,
        departureWarehouse: form.departureWarehouse,
        arrivalWarehouse: form.arrivalWarehouse,
        departureTime: form.departureTime,
        arrivalTime: form.arrivalTime,
        status: form.status,
    })

    form.customerOrder = ''
    form.driver = ''
    form.vehicle = ''
    form.departureWarehouse = ''
    form.arrivalWarehouse = ''
    form.departureTime = ''
    form.arrivalTime = ''
    form.status = 'planned'

    await fetchAll()
}

const deleteItem = async (id: number) => {
    await api.delete(`/shipments/${id}`)
    await fetchAll()
}

onMounted(fetchAll)
</script>

<template>
    <div>
        <h1>Shipments</h1>

        <div style="display: grid; gap: 8px; max-width: 420px; margin-bottom: 24px;">
            <select v-model="form.customerOrder">
                <option value="">Select order</option>
                <option v-for="order in orders" :key="order.id" :value="`/api/customer_orders/${order.id}`">
                    Order #{{ order.id }}
                </option>
            </select>

            <select v-model="form.driver">
                <option value="">Select driver</option>
                <option v-for="driver in drivers" :key="driver.id" :value="`/api/drivers/${driver.id}`">
                    {{ driver.firstName }} {{ driver.lastName }}
                </option>
            </select>

            <select v-model="form.vehicle">
                <option value="">Select vehicle</option>
                <option v-for="vehicle in vehicles" :key="vehicle.id" :value="`/api/vehicles/${vehicle.id}`">
                    {{ vehicle.plateNumber }}
                </option>
            </select>

            <select v-model="form.departureWarehouse">
                <option value="">Departure warehouse</option>
                <option v-for="warehouse in warehouses" :key="warehouse.id" :value="`/api/warehouses/${warehouse.id}`">
                    {{ warehouse.name }}
                </option>
            </select>

            <select v-model="form.arrivalWarehouse">
                <option value="">Arrival warehouse</option>
                <option v-for="warehouse in warehouses" :key="warehouse.id" :value="`/api/warehouses/${warehouse.id}`">
                    {{ warehouse.name }}
                </option>
            </select>

            <input v-model="form.departureTime" type="datetime-local" />
            <input v-model="form.arrivalTime" type="datetime-local" />

            <select v-model="form.status">
                <option value="planned">planned</option>
                <option value="in_transit">in_transit</option>
                <option value="delivered">delivered</option>
            </select>

            <button @click="createItem">Create</button>
        </div>

        <div v-if="loading">Loading...</div>

        <table v-else border="1" cellpadding="8" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Order</th>
                <th>Driver</th>
                <th>Vehicle</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Departure time</th>
                <th>Arrival time</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.customerOrder }}</td>
                <td>{{ item.driver }}</td>
                <td>{{ item.vehicle }}</td>
                <td>{{ item.departureWarehouse }}</td>
                <td>{{ item.arrivalWarehouse }}</td>
                <td>{{ item.departureTime }}</td>
                <td>{{ item.arrivalTime }}</td>
                <td>{{ item.status }}</td>
                <td>
                    <button @click="deleteItem(item.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
