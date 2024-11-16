<template>
  <input
    type="text"
    placeholder="Search Purchase Order..."
    class="mb-4 p-2 border rounded w-3/4"
    v-model="searchQuery"
  />
  <table class="w-full border border-gray-200">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 border-b">Purchase Order ID</th>
        <th class="p-2 border-b">Order Date</th>
        <th class="p-2 border-b">Status</th>
        <th class="p-2 border-b">Order Items</th>
        <th class="p-2 border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="item in filteredPurchaseOrderData"
        :key="item.id"
        class="text-center"
      >
        <td class="p-2 border-b">{{ item.adminOrdID }}</td>
        <td class="p-2 border-b">{{ item.orderDate }}</td>
        <td class="p-2 border-b">
          <span
            :class="statusClass(item.status)"
            class="py-1 px-3 rounded-full text-white text-sm"
          >
            {{ item.status }}
          </span>
        </td>
        <td class="p-2 border-b">
          {{ `${item.admin_order_detail?.length} ordered material(s)` }}
        </td>
        <td class="p-2 border-b">
          <UButton
            class="mr-2"
            icon="lets-icons:view-alt-duotone"
            @click="viewDetails(item)"
            rounded="false"
            title="View details"
            color="white"
            square
          />
          <UButton
            :disabled="item.status === 'Unpaid' || item.status === 'Delivered'"
            icon="emojione:delivery-truck"
            @click="openDeliveryModal(item)"
            rounded="false"
            title="Process delivery"
            color="white"
            square
          />
        </td>
      </tr>
    </tbody>
  </table>
  <div class="mt-4 flex justify-between">
    <button
      @click="prevPage"
      :disabled="currentPage === 1"
      class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
    >
      Previous
    </button>
    <span>Page {{ currentPage }} of {{ totalPages }}</span>
    <button
      @click="nextPage"
      :disabled="currentPage === totalPages"
      class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
    >
      Next
    </button>
  </div>
  <!-- Modal for Supplier Material Selection -->
  <div
    v-if="selectedPO"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-md w-1/2">
      <h3 class="text-lg font-bold mb-2">
        {{ `Materials for Purchase Order No: ${selectedPO.adminOrdID}` }}
      </h3>

      <label for="materialId" class="block mb-2 mt-4 text-black"
        >Purchase Order No: <span>{{ selectedPO.adminOrdID }}</span></label
      >
      <label for="materialId" class="block mb-2 mt-4 text-black"
        >Status: <span>{{ selectedPO.paymentStatus }}</span></label
      >
      <label for="materialId" class="block mb-2 mt-4 text-black"
        >Amount Paid:
        <span>{{
          new Intl.NumberFormat("en-PH", {
            style: "currency",
            currency: "PHP",
          }).format(selectedPO.admin_payments?.amountPaid ?? 0)
        }}</span></label
      >

      <label for="materialId" class="block mb-2 mt-4 text-black"
        >Payment Date:
        <span>{{selectedPO.admin_payments?.paymentDate
        }}</span></label
      >
      <!-- Scrollable Table Container -->
      <div
        class="max-h-64 overflow-y-auto border border-gray-300 rounded-md mb-4"
      >
        <table class="min-w-full bg-white">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-2 px-4 text-left">ID</th>
              <th class="py-2 px-4 text-left">Product Material</th>
              <th class="py-2 px-4 text-left">Quantity</th>
              <th class="py-2 px-4 text-left">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(material, index) in selectedPO.admin_order_detail"
              :key="material.id"
              class="border-t"
            >
              <td class="py-2 px-4">{{ index + 1 }}</td>
              <td class="py-2 px-4">
                {{ getMaterialProductName(material?.prodtnMtrlID) }}
              </td>
              <td class="py-2 px-4">{{ material.qtyOrdered }}</td>
              <td class="py-2 px-4">
                {{
                  new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                  }).format(material.amount)
                }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-between">
        <button @click="selectedPO = null" class="text-gray-600 ml-2">
          Close
        </button>
        <span
          >Total Amount:
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(totalAmount)
          }}</span
        >
      </div>
    </div>
  </div>
  <!-- Modal for Processing Delivery -->
  <div
    v-if="isDeliveryModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-md w-1/2">
      <h2 class="text-xl font-bold mb-4 text-black">Process Delivery</h2>
      <form @submit.prevent="saveDelivery">
        <label for="deliveryDate" class="block mb-2 mt-4 text-black"
          >Delivery Date:</label
        >
        <input
          id="deliveryDate"
          v-model="deliveryForm.deliveryDate"
          type="date"
          required
          class="w-full p-2 border rounded"
        />

        <div class="flex justify-end mt-4">
          <button
            type="button"
            @click="closeDeliveryModal"
            class="bg-gray-300 px-4 py-2 mr-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          >
            Process
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from "vue";
import { apiService } from "~/api/apiService";

const userInfo = ref({ userID: "" });
const searchQuery = ref("");
const purchaseOrderData = ref([]);
const materials = ref([]);
const totalAmount = ref(0);

const selectedPO = ref(null);

const currentPage = ref(1);
const itemsPerPage = 5;

const isDeliveryModal = ref(false);
const deliveryForm = ref({
  deliveryDate: "",
  adminOrdID: "",
  deliveryStatus: "Process Delivery",
  qtyReceived: 0,
  adminDlvrID: null,
});

// Computed properties for filtering
const filteredPurchaseOrderData = computed(() => {
  return purchaseOrderData.value?.filter((quotation) => {
    return quotation?.adminOrdID
      ?.toString()
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase());
  });
});

const totalPages = computed(() =>
  Math.ceil(filteredPurchaseOrderData.value.length / itemsPerPage)
);

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const statusClass = (status) => {
  switch (status) {
    case "Processed delivery":
      return "bg-yellow-500";
    case "Waiting for delivery":
      return "bg-blue-500";
    case "Delivered":
      return "bg-green-500";
    case "Unpaid":
      return "bg-red-500";
    default:
      return "bg-gray-500";
  }
};
const saveDelivery = async () => {
  if (deliveryForm.value.adminDlvrID) {
    await apiService.put(
      `/api/adminDeliveries/${deliveryForm.value.adminDlvrID}`,
      {
        adminDlvrID: deliveryForm.value.adminDlvrID,
        deliveryDate: deliveryForm.value.deliveryDate,
        adminOrdID: deliveryForm.value.adminOrdID,
        deliveryStatus: "Rescheduled delivery",
        qtyReceived: 0,
      }
    );
  } else {
    await apiService.post("/api/adminDeliveries", {
      deliveryDate: deliveryForm.value.deliveryDate,
      adminOrdID: deliveryForm.value.adminOrdID,
      deliveryStatus: "Processed delivery",
      qtyReceived: 0,
    });
  }
    await fetchAdminOrderData();
    alert("Processed delivery successfully");
    isDeliveryModal.value = false;
};

const openDeliveryModal = async (po) => {
  if (po.admin_deliveries) {
    deliveryForm.value = {...po.admin_deliveries};
  } else {
    deliveryForm.value = {
      adminOrdID: po.adminOrdID,
      deliveryStatus: "Process Delivery",
      qtyReceived: 0,
      adminDlvrID: null,
      deliveryDate: null,
    };
  }
  isDeliveryModal.value = true;
};

const closeDeliveryModal = () => {
  isDeliveryModal.value = false;
  deliveryForm.value = {
    deliveryDate: null,
    adminOrdID: "",
    deliveryStatus: "Process Delivery",
    qtyReceived: 0,
    adminDlvrID: null,
  };
};

const viewDetails = async (po) => {
await fetchMaterialsByProductionID(po.quotation.productionID);
  totalAmount.value = po.admin_order_detail.reduce((total, detail) => {
    return total + parseFloat(detail.amount);
  }, 0);
  selectedPO.value = po;
};

const getMaterialProductName = (prodtnMtrlID) => {
  const material = materials.value?.find(
    (val) => val.prodtnMtrlID == prodtnMtrlID
  );
  return `${material?.productName} -> ${material?.description}`;
};

const fetchMaterialsByProductionID = async (productionID) => {
  const result = await apiService.get(
    `/api/materials/production/${productionID}`
  );
  materials.value = result;
};
const fetchAdminOrderData = async () => {
  const result = await apiService.get("/api/adminOrders");
  purchaseOrderData.value = result.data
    .filter((value) => value?.quotation?.userID === userInfo.value.userID)
    .map((order) => {
      const totalAmount = order.admin_order_detail.reduce((total, detail) => {
        return total + parseFloat(detail.amount);
      }, 0);
      if (order.admin_deliveries) {
        if( parseFloat(order.admin_payments?.amountPaid) >= (totalAmount / 2)){
            order.paymentStatus = "Partially paid";
          } else {
            order.paymentStatus = "Fully paid"
          }
        order.status = order.admin_deliveries.deliveryStatus;
      } else {
        if (totalAmount === parseFloat(order.admin_payments?.amountPaid) || parseFloat(order.admin_payments?.amountPaid) >= (totalAmount / 2)  ) {
          if(parseFloat(order.admin_payments?.amountPaid) >= (totalAmount / 2) ){
            order.paymentStatus = "Partially paid";
          } else {
            order.paymentStatus = "Fully paid"
          }
          order.status = "Waiting for delivery";
        } else {
          order.status = "Pending";
          order.paymentStatus = "Unpaid"
        }
      }
      return order;
    });
};

onMounted(async () => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
  }
  await fetchAdminOrderData();
});
</script>
