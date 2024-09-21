<template>
  <div class="w-70 bg-gray-600 text-white">
    <nav>
      <ul>
        <!-- Collapsible Sections -->
        <CollapsibleMenu
          icon="material-symbols:filter-7-outline"
          title="Order Management"
          :isOpen="activeMenu === 'Order Management'"
          @toggle="toggleMenu('Order Management')"
        >
          <router-link to="/orders" class="block p-4 hover:bg-gray-800">Orders</router-link>
          <router-link to="/return-orders" class="block p-4 hover:bg-gray-800">Return Orders</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="material-symbols:auto-stories-outline"
          title="Product Management"
          :isOpen="activeMenu === 'Product Management'"
          @toggle="toggleMenu('Product Management')"
        >
          <router-link
            to="/admin/product-categories"
            :class="route.path === '/admin/product-categories' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'"
          >
            Product Categories
          </router-link>
          <router-link
            to="/admin/product"
            :class="route.path === '/admin/product' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'"
          >
            Products
          </router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:account-supervisor-circle"
          title="Production Management"
          :isOpen="activeMenu === 'Production Management'"
          @toggle="toggleMenu('Production Management')"
        >
          <router-link to="/production/orders" class="block p-4 hover:bg-gray-800">Productions</router-link>
          <router-link to="/production/orders" class="block p-4 hover:bg-gray-800">Production Details</router-link>
          <router-link to="/production/orders" class="block p-4 hover:bg-gray-800">Production Materials</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:file-sign"
          title="Quotation Management"
          :isOpen="activeMenu === 'Quotation Management'"
          @toggle="toggleMenu('Quotation Management')"
        >
          <router-link to="/quotations/view" class="block p-4 hover:bg-gray-800">Quotations</router-link>
          <router-link to="/quotations/manage" class="block p-4 hover:bg-gray-800">Quotation Details</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:align-horizontal-left"
          title="Stock Management"
          :isOpen="activeMenu === 'Stock Management'"
          @toggle="toggleMenu('Stock Management')"
        >
          <router-link to="/stock-overview" class="block p-4 hover:bg-gray-800">Stock Overview</router-link>
          <router-link to="/manage-inventory" class="block p-4 hover:bg-gray-800">Manage Inventory</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:money"
          title="Payments"
          :isOpen="activeMenu === 'Payments'"
          @toggle="toggleMenu('Payments')"
        >
          <router-link to="/payments/view" class="block p-4 hover:bg-gray-800">View Payments</router-link>
          <router-link to="/payments/manage" class="block p-4 hover:bg-gray-800">Manage Payments</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:truck-check"
          title="Suppliers"
          :isOpen="activeMenu === 'Suppliers'"
          @toggle="toggleMenu('Suppliers')"
        >
          <router-link to="/suppliers/manage" class="block p-4 hover:bg-gray-800">Manage Suppliers</router-link>
          <router-link to="/suppliers/materials" class="block p-4 hover:bg-gray-800">Supplier Materials</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:account-group"
          title="Customers"
          :isOpen="activeMenu === 'Customers'"
          @toggle="toggleMenu('Customers')"
        >
          <router-link to="/customers/view" class="block p-4 hover:bg-gray-800">View Customers</router-link>
          <router-link to="/customers/orders" class="block p-4 hover:bg-gray-800">Customer Orders</router-link>
        </CollapsibleMenu>

        <li>
          <div :class="route.path === '/admin/material' ? 'block p-4 bg-gray-400' : 'block p-4 hover:bg-gray-800'">
            <UIcon name="material-symbols:list-rounded" class="w-5 h-5 mr-5" />
            <router-link to="/admin/material" class="text-center">Materials</router-link>
          </div>
        </li>

        <li>
          <div class="block p-4 hover:bg-gray-800">
            <UIcon name="mdi:receipt-text-arrow-right-outline" class="w-5 h-5 mr-5" />
            <router-link to="/reports" class="text-center">Reports</router-link>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRoute } from "vue-router";
import CollapsibleMenu from './CollapsibleMenu.vue';

const activeMenu = ref(null);
const route = useRoute();

// Function to toggle menu and ensure only one menu is open at a time
function toggleMenu(menu) {
  if (activeMenu.value === menu) {
    activeMenu.value = null; // Close the menu if it's already open
  } else {
    activeMenu.value = menu; // Open the new menu and close others
  }
}
</script>

<style scoped>
.static-class {
  padding: 10px;
}

.active-class {
  color: blue;
}
</style>
