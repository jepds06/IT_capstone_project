<template>
  <div class="w-70 bg-gray-600 text-white">
    <nav :key="userPermission.length">
      <ul>
        <!-- Collapsible Sections -->
        <CollapsibleMenu
          icon="material-symbols:auto-stories-outline"
          title="Product Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('product management')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/admin/product-categories"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/product-categories'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('product categories')
                  ).length > 0
                ? route.path === '/admin/product-categories'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Product Categories</router-link
          >
          <router-link
            to="/admin/product"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/product'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('products')
                  ).length > 0
                ? route.path === '/admin/product'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Products</router-link
          >
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:account-supervisor-circle"
          title="Production Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('production management')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/admin/production"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/production'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('production')
                  ).length > 0
                ? route.path === '/admin/production'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Productions</router-link
          >
          <router-link
            to="/admin/production-details"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/production-details'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('production details')
                  ).length > 0
                ? route.path === '/admin/production-details'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Production Details</router-link
          >
          <router-link
            to="/admin/finished-product"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/finished-product'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('finished product')
                  ).length > 0
                ? route.path === '/admin/finished-product'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Finished Products</router-link
          >
          <router-link
            to="/admin/production-materials"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/production-materials'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('production materials')
                  ).length > 0
                ? route.path === '/admin/production-materials'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Production Materials</router-link
          >
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:account-group"
          title="User Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('user management')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/admin/users"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/users'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('users')
                  ).length > 0
                ? route.path === '/admin/users'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Users</router-link
          >
          <router-link
            to="/admin/user-permissions"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/user-permissions'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('user permissions')
                  ).length > 0
                ? route.path === '/admin/user-permissions'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >User Permissions</router-link
          >
        </CollapsibleMenu>

        <li>
          <div
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/module'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('modules')
                  ).length > 0
                ? route.path === '/admin/module'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
          >
            <UIcon
              name="mdi:receipt-text-arrow-right-outline"
              class="w-5 h-5 mr-5"
            />
            <router-link to="/admin/module" class="text-center"
              >Modules</router-link
            >
          </div>
        </li>

        <CollapsibleMenu
          icon="mdi:account-group"
          title="Quotation Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'supplier'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('quotation management')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/admin/quotations"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'supplier'
                ? route.path === '/admin/quotations'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('quotations')
                  ).length > 0
                ? route.path === '/admin/quotations'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Quotations</router-link
          >
          <!-- <router-link
            to="/admin/quotation-details"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'supplier'
                ? route.path === '/admin/quotation-details'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('quotation details')
                  ).length > 0
                ? route.path === '/admin/quotation-details'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Quotation Details</router-link
          > -->
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:truck-check"
          title="Suppliers"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('suppliers')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/admin/supplier-quotations"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/supplier-quotations'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('supplier quotations')
                  ).length > 0
                ? route.path === '/admin/supplier-quotations'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Suppliers Quotation</router-link
          >
          <router-link
            to="/suppliers/materials"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/suppliers/materials'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('supplier materials')
                  ).length > 0
                ? route.path === '/suppliers/materials'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Supplier Materials</router-link
          >
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:account-group"
          title="Customers"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('customers')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/admin/view-customer"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/view-customer'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('view customers')
                  ).length > 0
                ? route.path === '/admin/view-customer'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >View Customers</router-link
          >
          <router-link
            to="/customers/orders"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/customers/orders'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('customer orders')
                  ).length > 0
                ? route.path === '/customers/orders'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Customer Orders</router-link
          >
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="material-symbols:filter-7-outline"
          title=" Purchase Order Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('order management')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/orders"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/orders'
                  ? 'block p-4 hover:bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('orders')
                  ).length > 0
                ? route.path === '/orders'
                  ? 'block p-4 hover:bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Orders</router-link
          >
          <router-link
            to="/return-orders"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/return-orders'
                  ? 'block p-4 hover:bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('return orders')
                  ).length > 0
                ? route.path === '/return-orders'
                  ? 'block p-4 hover:bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Return Orders</router-link
          >
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="mdi:paypal"
          title="Payments"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('payments')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/payments/view"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/payments/view'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('view payments')
                  ).length > 0
                ? route.path === '/payments/view'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >View Payments</router-link
          >
          <router-link
            to="/payments/manage"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/payments/manage'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('manage payments')
                  ).length > 0
                ? route.path === '/payments/manage'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Manage Payments</router-link
          >
        </CollapsibleMenu>


        

        


        <CollapsibleMenu
          icon="mdi:align-horizontal-left"
          title="Stock Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('stock management')
                ).length > 0
              ? ''
              : 'hidden'
          "
        >
          <router-link
            to="/stock-overview"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/stock-overview'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('stock overview')
                  ).length > 0
                ? route.path === '/stock-overview'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Stock Overview</router-link
          >
          <router-link
            to="/manage-inventory"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/manage-inventory'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('manage inventory')
                  ).length > 0
                ? route.path === '/manage-inventory'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
            >Manage Inventory</router-link
          >
        </CollapsibleMenu>


        

        <li>
          <div
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/material'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('materials')
                  ).length > 0
                ? route.path === '/admin/material'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
          >
            <UIcon name="material-symbols:list-rounded" class="w-5 h-5 mr-5" />
            <router-link to="/admin/material" class="text-center"
              >Materials</router-link
            >
          </div>
        </li>

        <li>
          <div
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/reports'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('reports')
                  ).length > 0
                ? route.path === '/reports'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : 'hidden'
            "
          >
            <UIcon
              name="mdi:receipt-text-arrow-right-outline"
              class="w-5 h-5 mr-5"
            />
            <router-link to="/reports" class="text-center">Reports</router-link>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import CollapsibleMenu from "./AdminCollapsibleMenu.vue";
const route = useRoute();

const userPermission = ref([]);
const userInfo = ref(null);

onMounted(() => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userPermission"));
    const userInfoStorage = JSON.parse(localStorage.getItem("userInfo"));
    userPermission.value = storage ? storage : null;
    userInfo.value = userInfoStorage ? userInfoStorage : null;
  }
});
</script>

<style scoped>
.static-class {
  padding: 10px;
}

.active-class {
  color: blue;
}
</style>
