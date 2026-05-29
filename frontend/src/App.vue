<template>
    <div style="display: flex; min-height: 100vh;">
        <aside style="width: 220px; padding: 16px; border-right: 1px solid #ccc;">
            <nav style="display: flex; flex-direction: column; gap: 8px;">
                <router-link to="/companies">Companies</router-link>
                <router-link to="/warehouses">Warehouses</router-link>
                <router-link to="/products">Products</router-link>
                <router-link to="/orders">Orders</router-link>
                <router-link to="/shipments">Shipments</router-link>
                <router-link to="/drivers">Drivers</router-link>
                <router-link to="/vehicles">Vehicles</router-link>
            </nav>
        </aside>

        <main style="flex: 1; padding: 16px;">
            <router-view />
        </main>
    </div>
</template>
