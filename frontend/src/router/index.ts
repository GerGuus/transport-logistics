import { createRouter, createWebHistory } from 'vue-router'
import CompaniesView from '@/views/CompaniesView.vue'
import WarehousesView from '@/views/WarehousesView.vue'
import ProductsView from '@/views/ProductsView.vue'
import OrdersView from '@/views/OrdersView.vue'
import ShipmentsView from '@/views/ShipmentsView.vue'
import DriversView from '@/views/DriversView.vue'
import VehiclesView from '@/views/VehiclesView.vue'

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', redirect: '/companies' },
        { path: '/companies', component: CompaniesView },
        { path: '/warehouses', component: WarehousesView },
        { path: '/products', component: ProductsView },
        { path: '/orders', component: OrdersView },
        { path: '/shipments', component: ShipmentsView },
        { path: '/drivers', component: DriversView },
        { path: '/vehicles', component: VehiclesView },
    ],
})
