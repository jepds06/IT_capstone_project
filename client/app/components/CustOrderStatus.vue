<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <!-- Tab Navigation -->
    <div class="flex justify-center mb-8">
      <button
        class="px-6 py-3 text-xl font-semibold rounded-lg transition-all duration-300"
        :class="{
          'bg-blue-500 text-white shadow-md': activeTab === 'To Receive',
          'bg-white text-gray-600 border-gray-300': activeTab !== 'To Receive',
        }"
        @click="activeTab = 'To Receive'"
      >
        To Receive
      </button>
      <button
        class="px-6 py-3 text-xl font-semibold rounded-lg ml-4 transition-all duration-300"
        :class="{
          'bg-blue-500 text-white shadow-md': activeTab === 'Completed',
          'bg-white text-gray-600 border-gray-300': activeTab !== 'Completed',
        }"
        @click="activeTab = 'Completed'"
      >
        Completed
      </button>
    </div>

    <!-- Scrollable Section -->
    <div class="overflow-y-auto max-h-[calc(100vh-100px)] px-4"></div>

    <!-- To Receive Section -->
    <div v-if="activeTab === 'To Receive'">
      <div
        v-for="order in orders"
        :key="order.salesID"
        class="bg-gradient-to-r from-white to-gray-50 rounded-xl shadow-lg p-6 mb-6"
      >
        <div class="flex justify-between items-center border-b pb-3">
          <h2 class="text-2xl font-bold text-gray-800">
            Order ID: {{ order.salesID }}
          </h2>
          <span class="text-lg font-semibold uppercase text-blue-500">
            To Receive
          </span>
        </div>
        <div class="">
          <div
            class="border-b pb-3 flex items-start gap-6 mt-4"
            v-for="item in order?.sales_orders"
          >
            <img
              :src="item.product.image_url"
              alt="Product Image"
              class="w-32 h-32 object-cover rounded-lg shadow-lg hover:opacity-95"
            />
            <div>
              <h3 class="text-xl font-semibold text-gray-700">
                {{ item.productName }}
              </h3>
              <p class="text-lg text-gray-500">
                {{ item.specifications }}
              </p>
              <p class="mt-2 text-lg text-gray-500">
                Quantity:
                <span class="font-medium text-gray-700">{{
                  item.qtyOrdered
                }}</span>
              </p>
              <p class="mt-1 text-lg text-gray-500">
                Price:
                <span class="font-medium text-gray-700"
                  >₱{{ parseFloat(item.product.unitPrice).toFixed(2) }}</span
                >
              </p>
              <p class="mt-4 text-lg font-medium text-gray-800">
                Total: ₱{{ parseFloat(item.amount).toFixed(2) }}
              </p>
            </div>
          </div>
        </div>

        <div class="mt-6">
          <p class="text-lg text-gray-500">
            Expected Delivery:
            <span class="font-medium text-gray-700">{{
              order?.sales_deliveries?.deliveryDate
            }}</span>
          </p>
          <p class="mt-1 text-lg text-gray-500">
            Status:
            <span class="font-medium text-gray-700">{{
              order?.sales_deliveries?.deliveryStatus
            }}</span>
          </p>
        </div>

        <div class="mt-6 text-right">
          <UButton :loading="isLoadingReceived" @click="orderReceived(order)" label="RECEIVED"/>
        </div>
      </div>
    </div>

    <!-- Completed Section -->
    <div v-if="activeTab === 'Completed'">
      <div
        v-for="order in completedOrders"
        :key="order.storeName"
        class="bg-gradient-to-r from-gray-50 to-white rounded-xl shadow-lg p-6 mb-6 transition-transform duration-300 hover:scale-105"
      >
        <div class="flex justify-between items-center border-b pb-3">
          <h2 class="text-2xl font-bold text-gray-800">
            Order ID: {{ order.salesID }}
          </h2>
          <span class="text-lg font-semibold uppercase text-blue-500">
            Completed
          </span>
        </div>

        <div class="">
          <div
            class="border-b pb-3 flex items-start gap-6 mt-4"
            v-for="item in order?.sales_orders"
          >
            <img
              :src="item.product.image_url"
              alt="Product Image"
              class="w-32 h-32 object-cover rounded-lg shadow-lg hover:opacity-95"
            />
            <div>
              <h3 class="text-xl font-semibold text-gray-700">
                {{ item.productName }}
              </h3>
              <p class="text-lg text-gray-500">
                {{ item.specifications }}
              </p>
              <p class="mt-2 text-lg text-gray-500">
                Quantity:
                <span class="font-medium text-gray-700">{{
                  item.qtyOrdered
                }}</span>
              </p>
              <p class="mt-1 text-lg text-gray-500">
                Price:
                <span class="font-medium text-gray-700"
                  >₱{{ parseFloat(item.product.unitPrice).toFixed(2) }}</span
                >
              </p>
              <p class="mt-4 text-lg font-medium text-gray-800">
                Total: ₱{{ parseFloat(item.amount).toFixed(2) }}
              </p>
            </div>
          </div>
        </div>

        <!-- <div class="mt-6">
            <p class="text-lg text-gray-500">
              Rated On:
              <span class="font-medium text-gray-700">{{ order.ratedOn }}</span>
            </p>
            <div class="mt-6 flex justify-end gap-3">
              <button
                class="bg-blue-500 text-white text-lg font-semibold px-5 py-3 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-600"
              >
                BUY AGAIN
              </button>
              <button
                class="bg-yellow-400 text-white text-lg font-semibold px-5 py-3 rounded-lg shadow-md transition-all duration-300 hover:bg-yellow-500"
              >
                RATE
              </button>
            </div>
          </div> -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { apiService } from "~/api/apiService";

const activeTab = ref("To Receive"); // Track active tab

const userInfo = ref({ userID: "" });

const isLoadingReceived = ref(false);
const orders = ref([
  // {
  //   storeName: 'Furniture Store',
  //   status: 'To Receive',
  //   product: {
  //     image: 'https://via.placeholder.com/100',
  //     name: 'Wooden Chair',
  //     specifications: 'Color: Brown, Material: Oak Wood',
  //     quantity: 2,
  //     price: 1500,
  //   },
  //   totalItems: 2,
  //   totalAmount: 3000,
  //   expectedDelivery: '2024-11-22',
  //   deliveryStatus: 'Out for Delivery',
  // },
]);

const completedOrders = ref([
  // {
  //   storeName: 'Furniture Store',
  //   status: 'Completed',
  //   product: {
  //     image: 'https://via.placeholder.com/100',
  //     name: 'Wooden Desk',
  //     specifications: 'Color: Natural Wood, Material: Pine',
  //     quantity: 1,
  //     price: 2000,
  //   },
  //   totalItems: 1,
  //   totalAmount: 2000,
  //   ratedOn: '12 Dec',
  // },
]);

const orderReceived = async (order) => {
  isLoadingReceived.value = true
  const delivery = { ...order.sales_deliveries, deliveryStatus: "Completed" };
  await apiService.put(`/api/salesDeliveries/${delivery.deliveryID}`, delivery);
  await fetchOrdersData();
  isLoadingReceived.value = false
  alert("Order(s) received successfully!");
};

const fetchOrdersData = async () => {
  const result = await apiService.get(
    `/api/sales/user/${userInfo.value.userID}`
  );
  orders.value = result.data?.filter(
    (value) => value.sales_deliveries.deliveryStatus === "Out for delivery"
  );
  completedOrders.value = result.data?.filter(
    (value) => value.sales_deliveries.deliveryStatus === "Completed"
  );
};

onMounted(async () => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
  }

  await fetchOrdersData();
});
</script>

<style scoped>
img:hover {
  opacity: 0.9;
}

/* Base Styles */
body {
  font-family: "Inter", sans-serif;
  color: #333;
}

.bg-gray-100 {
  background-color: #f8fafc;
}

.bg-white {
  background-color: #ffffff;
}

.rounded-lg {
  border-radius: 12px;
}

/* Tab Navigation */
button.px-4 {
  transition: all 0.3s ease;
}

button.px-4:hover {
  background-color: #e5f0fc;
  border-color: #007bff;
}

/* Cards */
.shadow-lg {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.card-header {
  background-color: #f1f5f9;
  border-bottom: 1px solid #e5e7eb;
  padding: 10px 15px;
  border-radius: 12px 12px 0 0;
}

.card-footer {
  background-color: #f8fafc;
  padding: 10px 15px;
  border-radius: 0 0 12px 12px;
}

/* Buttons */
button.bg-blue-500 {
  background-color: #0ea5e9;
}

button.bg-blue-500:hover {
  background-color: #0284c7;
}

button.bg-yellow-400 {
  background-color: #facc15;
}

button.bg-yellow-400:hover {
  background-color: #eab308;
}

button.bg-gray-300:hover {
  background-color: #d1d5db;
}

/* Images */
img {
  border-radius: 10px;
  transition: transform 0.3s ease, opacity 0.3s ease;
}

img:hover {
  transform: scale(1.05);
}
</style>
