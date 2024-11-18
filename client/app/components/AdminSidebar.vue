<template>
  <div class="w-70 bg-gray-950 text-white">
    <nav :key="userPermission.length">
      <ul>
        <li>
          <div
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('admin')
                ).length > 0
                  ? route.path === '/admin'
                    ? 'block p-4 bg-gray-800'
                    : 'block p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >
            <UIcon
              name="material-symbols:dashboard-2-outline"
              class="w-5 h-5 mr-5"
            />
            <router-link
              to="/admin"
              class="text-center"
            >
              Dashboard
            </router-link>
          </div>
        </li>
        <!-- <li>
          <div
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === 'admin/calendar'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('calendar')
                ).length > 0
                  ? route.path === 'admin/calendar'
                    ? 'block p-4 bg-gray-800'
                    : 'block p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >
            <UIcon
              name="mdi:receipt-text-arrow-right-outline"
              class="w-5 h-5 mr-5"
            />
            <router-link
              to="/admin/calendar"
              class="text-center"
            >
              Calendar
            </router-link>
          </div>
        </li> -->

        <!-- <li>
          <div
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === 'admin/reports'
                  ? 'block p-4 bg-gray-800'
                  : 'block p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('reports')
                ).length > 0
                  ? route.path === 'admin/reports'
                    ? 'block p-4 bg-gray-800'
                    : 'block p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >
            <UIcon
              name="mdi:receipt-text-arrow-right-outline"
              class="w-5 h-5 mr-5"
            />
            <router-link
              to="/admin/reports"
              class="text-center"
            >
              Reports
            </router-link>
          </div>
        </li> -->

        <!-- <CollapsibleMenu
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
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('view payments')
                ).length > 0
                  ? route.path === '/payments/view'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >View Payments</router-link>
          <router-link
            to="/admin/manage-payment"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/manage-payment'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('manage payment')
                ).length > 0
                  ? route.path === '/admin/manage-payment'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Manage Payments</router-link>
        </CollapsibleMenu> -->

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
          <!-- <li>
            <div
              :class="
                userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                  ? route.path === '/admin/module'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('modules')
                  ).length > 0
                    ? route.path === '/admin/module'
                      ? 'block pl-10 p-4 bg-gray-800'
                      : 'block pl-10 p-4 hover:bg-gray-800'
                    : 'hidden'
              "
            >
              <UIcon
                name="mdi:receipt-text-arrow-right-outline"
                class="w-5 h-5 mr-5"
              />
              <router-link
                to="/admin/module"
                class="text-center"
              >Modules</router-link>
            </div>
          </li> -->

          <router-link
            to="/admin/module"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/module'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('modules')
                ).length > 0
                  ? route.path === '/admin/module'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Modules</router-link>
          <router-link
            to="/admin/users"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/users'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('users')
                ).length > 0
                  ? route.path === '/admin/users'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Users</router-link>
          <router-link
            to="/admin/user-permissions"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/user-permissions'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('user permissions')
                ).length > 0
                  ? route.path === '/admin/user-permissions'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >User Permissions</router-link>
        </CollapsibleMenu>

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
                  ? 'block pl-10 p-4 bg-gray-900'
                  : 'block pl-10 p-4 hover:bg-gray-900'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('product categories')
                ).length > 0
                  ? route.path === '/admin/product-categories'
                    ? 'block pl-10 p-4 bg-gray-900'
                    : 'block pl-10 p-4 hover:bg-gray-900'
                  : 'hidden'
            "
          >Product Categories</router-link>
          <router-link
            to="/admin/product"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/product'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('products')
                ).length > 0
                  ? route.path === '/admin/product'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Products</router-link>

          <router-link
            to="/admin/material"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/material'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('materials')
                ).length > 0
                  ? route.path === '/admin/material'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : ' block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Materials</router-link>
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
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('production')
                ).length > 0
                  ? route.path === '/admin/production'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Productions</router-link>
          <router-link
            to="/admin/production-details"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/production-details'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('production details')
                ).length > 0
                  ? route.path === '/admin/production-details'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Production Details</router-link>
          <router-link
            to="/admin/finished-product"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/finished-product'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('finished product')
                ).length > 0
                  ? route.path === '/admin/finished-product'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Finished Products</router-link>
          <!-- <router-link
            to="/admin/production-materials"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/production-materials'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('production materials')
                ).length > 0
                  ? route.path === '/admin/production-materials'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Production Materials</router-link> -->
        </CollapsibleMenu>

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
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('quotations')
                ).length > 0
                  ? route.path === '/admin/quotations'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Quotations</router-link>
          <!-- <router-link
            to="/admin/quotation-details"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'supplier'
                ? route.path === '/admin/quotation-details'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                    up.moduleName.toLowerCase().includes('quotation details')
                  ).length > 0
                ? route.path === '/admin/quotation-details'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
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
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('supplier quotations')
                ).length > 0
                  ? route.path === '/admin/supplier-quotations'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Suppliers Quotation</router-link>
          <!-- <router-link
            to="/suppliers/materials"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/suppliers/materials'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('supplier materials')
                ).length > 0
                  ? route.path === '/suppliers/materials'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Supplier Materials</router-link> -->

          <router-link
            to="/admin/bills-payment"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/bills-payment'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('bills payment')
                ).length > 0
                  ? route.path === '/admin/bills-payment'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Bills Payment</router-link>
          <router-link
            to="/admin/manage-payment"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/manage-payment'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('manage payment')
                ).length > 0
                  ? route.path === '/admin/manage-payment'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Manage Payments</router-link>
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
            to="/admin/customer-bills-payment"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/customer-bills-payment'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('customer bill payment')
                ).length > 0
                  ? route.path === '/admin/customer-bills-payment'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Bills Payment</router-link>
          <router-link
            to="/admin/customer-manage-payment"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/customer-manage-payment'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('customer orders')
                ).length > 0
                  ? route.path === '/admin/customer-manage-payment'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Manage Payment</router-link>
        </CollapsibleMenu>

        <CollapsibleMenu
          icon="material-symbols:filter-7-outline"
          title="Order Management"
          :class="
            userInfo?.userTypeDescription.toLowerCase() === 'administrator'
              ? ''
              : userPermission?.filter((up) =>
                up.moduleName.toLowerCase().includes('purchase order management')
              ).length > 0
                ? ''
                : 'hidden'
          "
        >
          <router-link
            to="/admin/purchase"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/purchase'
                  ? 'block pl-10 p-4 hover:bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('purchase orders')
                ).length > 0
                  ? route.path === '/admin/purchase'
                    ? 'block pl-10 p-4 hover:bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Purchase Orders</router-link>
          <router-link
            to="/admin/delivery"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/delivery'
                  ? 'block pl-10 p-4 hover:bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('delivery orders')
                ).length > 0
                  ? route.path === '/admin/delivery'
                    ? 'block pl-10 p-4 hover:bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Delivery Orders</router-link>
        </CollapsibleMenu>

        <!-- <CollapsibleMenu
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

        </CollapsibleMenu> -->

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
            to="/admin/stock-overview"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === '/admin/stock-overview'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('stock overview')
                ).length > 0
                  ? route.path === '/admin/stock-overview'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Stock Overview</router-link>
          <router-link
            to="/admin/inventory"
            :class="
              userInfo?.userTypeDescription.toLowerCase() === 'administrator'
                ? route.path === 'admin/inventory'
                  ? 'block pl-10 p-4 bg-gray-800'
                  : 'block pl-10 p-4 hover:bg-gray-800'
                : userPermission?.filter((up) =>
                  up.moduleName.toLowerCase().includes('inventory')
                ).length > 0
                  ? route.path === 'admin/inventory'
                    ? 'block pl-10 p-4 bg-gray-800'
                    : 'block pl-10 p-4 hover:bg-gray-800'
                  : 'hidden'
            "
          >Manage Inventory</router-link>
        </CollapsibleMenu>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import CollapsibleMenu from './AdminCollapsibleMenu.vue'

const route = useRoute()

const userPermission = ref([])
const userInfo = ref(null)

onMounted(() => {
  if (import.meta.client) {
    const storage = JSON.parse(localStorage.getItem('userPermission'))
    const userInfoStorage = JSON.parse(localStorage.getItem('userInfo'))
    userPermission.value = storage ? storage : null
    userInfo.value = userInfoStorage ? userInfoStorage : null
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