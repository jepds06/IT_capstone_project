<template>
  <div class="w-64 bg-gray-600 text-white">
    <nav>
      <ul>
        <!-- Collapsible Sections -->
        <CollapsibleMenu icon="material-symbols:filter-7-outline" title="Order Management">
          <router-link to="/orders" class="block p-4 hover:bg-gray-800">Orders</router-link>
          <router-link to="/return-orders" class="block p-4 hover:bg-gray-800">Return Orders</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="material-symbols:auto-stories-outline" title="Product Management">
          <router-link to="/admin/product-categories" :class="route.path === '/admin/product-categories' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Product Categories</router-link>
          <router-link to="/admin/product" :class="route.path === '/admin/product' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Products</router-link>
          <router-link to="/admin/productions" :class="route.path === '/admin/productions' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Productions</router-link>
          <router-link to="/admin/production-details" :class="route.path === '/admin/production-details' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Production Details</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu  icon="mdi:align-horizontal-left" title="Stock Management">
          <router-link to="/stock-overview" class="block p-4 hover:bg-gray-800">Stock Overview</router-link>
          <router-link to="/manage-inventory" class="block p-4 hover:bg-gray-800">Manage Inventory</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu  icon="mdi:file-sign" title="Quotations">
          <router-link to="/quotations/view" class="block p-4 hover:bg-gray-800">View Quotations</router-link>
          <router-link to="/quotations/manage" class="block p-4 hover:bg-gray-800">Manage Quotations</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu  icon="mdi:paypal" title="Payments">
          <router-link to="/payments/view" class="block p-4 hover:bg-gray-800">View Payments</router-link>
          <router-link to="/payments/manage" class="block p-4 hover:bg-gray-800">Manage Payments</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu  icon="mdi:account-supervisor-circle" title="Production">
          <router-link to="/production/orders" class="block p-4 hover:bg-gray-800">Production Orders</router-link>
          <router-link to="/production/status" class="block p-4 hover:bg-gray-800">Production Status</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu  icon="mdi:truck-check" title="Suppliers">
          <router-link to="/suppliers/manage" class="block p-4 hover:bg-gray-800">Manage Suppliers</router-link>
          <router-link to="/suppliers/materials" class="block p-4 hover:bg-gray-800">Supplier Materials</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu  icon="mdi:account-group" title="Customers">
          <router-link to="/customers/view" class="block p-4 hover:bg-gray-800">View Customers</router-link>
          <router-link to="/customers/orders" class="block p-4 hover:bg-gray-800">Customer Orders</router-link>
        </CollapsibleMenu>
        
        <li>
          <div :class="route.path === '/admin/material' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">
          <UIcon name="material-symbols:list-rounded" class="w-5 h-5 mr-5"/>
          <router-link to="/admin/material" class="text-center">Materials</router-link>
        </div>
        </li>

        <li>
          <div class="block p-4 hover:bg-gray-800">
          <UIcon name="mdi:receipt-text-arrow-right-outline" class="w-5 h-5 mr-5"/>
          <router-link to="/reports" class="text-center">Reports</router-link>
        </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import CollapsibleMenu from './AdminCollapsibleMenu.vue';
const route = useRoute()
</script>

<style scoped>
.static-class {
  padding: 10px;
}

.active-class {
  color: blue;
}
</style>
