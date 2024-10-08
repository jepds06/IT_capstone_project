<template>
  <div class="w-70 bg-gray-600 text-white">
    <nav :key="userPermission.length">
      <ul>
        <!-- Collapsible Sections -->
        <!--
        <CollapsibleMenu icon="material-symbols:filter-7-outline" title="Order Management" :class="userPermission?.filter((up) => up.moduleName.toLowerCase().includes('orders')).length > 0 ? '' : 'hidden'">
          <router-link to="/orders" class="block p-4 hover:bg-gray-800">Orders</router-link>
          <router-link to="/return-orders" class="block p-4 hover:bg-gray-800">Return Orders</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="material-symbols:auto-stories-outline" title="Product Management" :class="userPermission?.filter((up) => up.moduleName.toLowerCase().includes('products')).length > 0 ? '' : 'hidden'">
          <router-link to="/admin/product-categories" :class="route.path === '/admin/product-categories' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Product Categories</router-link>
          <router-link to="/admin/product" :class="route.path === '/admin/product' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Products</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="mdi:account-supervisor-circle" title="Production Management">
          <router-link to="/admin/production" class="block p-4 hover:bg-gray-800">Productions</router-link>
          <router-link to="/admin/production-details" class="block p-4 hover:bg-gray-800">Production Details</router-link>
          <router-link to="/admin/production-materials" class="block p-4 hover:bg-gray-800">Production Materials</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="mdi:account-group" title="User Management">
          <router-link to="/admin/users" :class="route.path === '/admin/users' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Users</router-link>
          <router-link to="/admin/user-permissions" :class="route.path === '/admin/user-permissions' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">User Permissions</router-link>
        </CollapsibleMenu>
        -->

        <!-- Quotation Management Section -->
        <CollapsibleMenu icon="mdi:account-group" title="Quotation Management">
          <router-link to="/admin/quotations" :class="route.path === '/admin/quotations' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Quotations</router-link>
          <router-link to="/admin/quotation-details" :class="route.path === '/admin/quotation-details' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">Quotation Details</router-link>
        </CollapsibleMenu>

        <!--
        <li>
          <div :class="route.path === '/admin/module' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">
            <UIcon name="mdi:receipt-text-arrow-right-outline" class="w-5 h-5 mr-5"/>
            <router-link to="/admin/module" class="text-center">Modules</router-link>
          </div>
        </li>

        <CollapsibleMenu icon="mdi:align-horizontal-left" title="Stock Management">
          <router-link to="/stock-overview" class="block p-4 hover:bg-gray-800">Stock Overview</router-link>
          <router-link to="/manage-inventory" class="block p-4 hover:bg-gray-800">Manage Inventory</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="mdi:paypal" title="Payments">
          <router-link to="/payments/view" class="block p-4 hover:bg-gray-800">View Payments</router-link>
          <router-link to="/payments/manage" class="block p-4 hover:bg-gray-800">Manage Payments</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="mdi:truck-check" title="Suppliers">
          <router-link to="/suppliers/manage" class="block p-4 hover:bg-gray-800">Manage Suppliers</router-link>
          <router-link to="/suppliers/materials" class="block p-4 hover:bg-gray-800">Supplier Materials</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu icon="mdi:account-group" title="Customers">
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
        -->
      </ul>
    </nav>
  </div>
</template>

  
  <script setup>
  import CollapsibleMenu from './AdminCollapsibleMenu.vue';
  const route = useRoute()
  
  const userPermission = ref([]);

onMounted(()=>{
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem('userPermission'));
    userPermission.value = storage ? storage : null;
  }
})
  </script>
  
  <style scoped>
  .static-class {
    padding: 10px;
  }
  
  .active-class {
    color: blue;
  }
  </style>
  