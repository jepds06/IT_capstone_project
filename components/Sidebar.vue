<template>
  <div class="w-64 bg-blue-800 text-white">
    <div class="p-4 text-lg font-bold">Dashboard</div>
    <nav>
      <ul>
        <!-- Collapsible Sections -->
        <CollapsibleMenu title="Order Management">
          <router-link to="/orders" class="block p-4 hover:bg-blue-700">Orders</router-link>
          <router-link to="/return-orders" class="block p-4 hover:bg-blue-700">Return Orders</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Product Management">
          <router-link to="/product-categories" class="block p-4 hover:bg-blue-700">Product Categories</router-link>
          <router-link to="/products" class="block p-4 hover:bg-blue-700">Products</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Stock Management">
          <router-link to="/stock-overview" class="block p-4 hover:bg-blue-700">Stock Overview</router-link>
          <router-link to="/manage-inventory" class="block p-4 hover:bg-blue-700">Manage Inventory</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Quotations">
          <router-link to="/quotations/view" class="block p-4 hover:bg-blue-700">View Quotations</router-link>
          <router-link to="/quotations/manage" class="block p-4 hover:bg-blue-700">Manage Quotations</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Payments">
          <router-link to="/payments/view" class="block p-4 hover:bg-blue-700">View Payments</router-link>
          <router-link to="/payments/manage" class="block p-4 hover:bg-blue-700">Manage Payments</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Production">
          <router-link to="/production/orders" class="block p-4 hover:bg-blue-700">Production Orders</router-link>
          <router-link to="/production/status" class="block p-4 hover:bg-blue-700">Production Status</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Suppliers">
          <router-link to="/suppliers/manage" class="block p-4 hover:bg-blue-700">Manage Suppliers</router-link>
          <router-link to="/suppliers/materials" class="block p-4 hover:bg-blue-700">Supplier Materials</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu title="Customers">
          <router-link to="/customers/view" class="block p-4 hover:bg-blue-700">View Customers</router-link>
          <router-link to="/customers/orders" class="block p-4 hover:bg-blue-700">Customer Orders</router-link>
        </CollapsibleMenu>

        <li>
          <router-link to="/reports" class="block p-4 hover:bg-blue-700">Reports</router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import CollapsibleMenu from './CollapsibleMenu.vue';
</script>

<style scoped>
/* Add additional styles if needed */
</style>
