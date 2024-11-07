<template>
  <div class="p-6">
    <!-- Main Tabs -->
    <div class="mb-4">
      <ul class="flex space-x-4 border-b">
        <li class="cursor-pointer pb-2 tab" 
            :class="{'border-b-2 border-blue-500': activeTab === 'quotations'}" 
            @click="activeTab = 'quotations'">Quotations
        </li>
        <li class="cursor-pointer pb-2 tab" 
            :class="{'border-b-2 border-blue-500': activeTab === 'purchaseOrder'}" 
            @click="activeTab = 'purchaseOrder'">Purchase Order
        </li>
        <li class="cursor-pointer pb-2 tab" 
            :class="{'border-b-2 border-blue-500': activeTab === 'adminPayments'}" 
            @click="activeTab = 'adminPayments'">Admin Payments
        </li>
      </ul>
    </div>
    
    <!-- Sub-tabs for Quotations -->
    <div class="mb-4" v-if="activeTab === 'quotations'"> 
      <ul class="flex space-x-4">
        <li @click="setActiveSubTab('requests')" 
            class="cursor-pointer pb-2 tab" 
            :class="{ 'border-b-2 border-blue-500': activeSubTab === 'requests' }">Quotation Requests</li>
        <li @click="setActiveSubTab('cancelled')" 
            class="cursor-pointer pb-2 tab" 
            :class="{ 'border-b-2 border-blue-500': activeSubTab === 'cancelled' }">Cancelled Quotations</li>
      </ul>
    </div>

    <!-- Quotations Table with Search and Pagination -->
    <div v-if="activeTab === 'quotations'">
      <div v-if="activeSubTab === 'requests'">
        <h3 class="text-xl font-semibold mb-2">Quotation Requests</h3>
        <input type="text" v-model="searchRequestQuery" placeholder="Search requests..." class="w-1/3 p-2 border rounded-lg mb-4" />
        <table class="min-w-full bg-white border border-gray-300 mb-4">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-2 text-left border-b">Quotation ID</th>
              <th class="px-6 py-2 text-left border-b">Quotation Date</th>
              <th class="px-6 py-2 text-left border-b">Remarks</th>
              <th class="px-6 py-2 text-left border-b">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="request in paginatedQuotationRequests" :key="request.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 border-b">{{ request.id }}</td>
              <td class="px-6 py-4 border-b">{{ request.requestDate }}</td>
              <td class="px-6 py-4 border-b">{{ request.details }}</td>
              <td class="px-6 py-4 border-b">
                <button @click="viewRequestDetails(request)" class="text-blue-500 hover:underline">View</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="flex justify-center items-center space-x-2 mb-4">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
          >
            Previous
          </button>
          <span>Page {{ currentPage }} of {{ totalPages }}</span>
          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
          >
            Next
          </button>
        </div>
      </div>

      <!-- Cancelled Quotations Table with Search and Pagination -->
      <div v-if="activeSubTab === 'cancelled'">
        <h3 class="text-xl font-semibold mb-2">Cancelled Quotations</h3>
        <input type="text" v-model="searchCancelledQuery" placeholder="Search cancelled..." class="w-1/3 p-2 border rounded-lg mb-4" />
        <table class="min-w-full bg-white border border-gray-300 mb-4">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-2 text-left border-b">Quotation ID</th>
              <th class="px-6 py-2 text-left border-b">Quotation Date</th>
              <th class="px-6 py-2 text-left border-b">Remarks</th>
              <th class="px-6 py-2 text-left border-b">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="cancelled in paginatedCancelledQuotations" :key="cancelled.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 border-b">{{ cancelled.id }}</td>
              <td class="px-6 py-4 border-b">{{ cancelled.cancellationDate }}</td>
              <td class="px-6 py-4 border-b">{{ cancelled.remarks }}</td>
              <td class="px-6 py-4 border-b">
                <button @click="restoreCancelledQuotation(cancelled)" class="text-green-500 hover:underline">Restore</button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="flex justify-center items-center space-x-2 mb-4">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
          >
            Previous
          </button>
          <span>Page {{ currentPage }} of {{ totalPages }}</span>
          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <!-- Purchase Order Table with Search and Pagination -->
    <div v-if="activeTab === 'purchaseOrder'">
      <h3 class="text-xl font-semibold mb-2">Purchase Orders</h3>
      <input type="text" v-model="searchPurchaseOrderQuery" placeholder="Search purchase orders..." class="w-1/3 p-2 border rounded-lg mb-4" />
      <table class="min-w-full bg-white border border-gray-300 mb-4">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-2 text-left border-b">Order ID</th>
            <th class="px-6 py-2 text-left border-b">Order Date</th>
            <th class="px-6 py-2 text-left border-b">Total Amount</th>
            <th class="px-6 py-2 text-left border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in paginatedPurchaseOrders" :key="order.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 border-b">{{ order.id }}</td>
            <td class="px-6 py-4 border-b">{{ order.orderDate }}</td>
            <td class="px-6 py-4 border-b">{{ order.totalAmount }}</td>
            <td class="px-6 py-4 border-b">
              <button @click="viewOrderDetails(order)" class="text-blue-500 hover:underline">View</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination Controls -->
      <div class="flex justify-center items-center space-x-2 mb-4">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Previous
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Next
        </button>
      </div>
    </div>
  </div>
  <!-- Admin Payments Table with Search and Pagination -->
<div v-if="activeTab === 'adminPayments'">
  <h3 class="text-xl font-semibold mb-2">Admin Payments</h3>
  <input type="text" v-model="searchAdminPaymentsQuery" placeholder="Search admin payments..." class="w-1/3 p-2 border rounded-lg mb-4" />
  <table class="min-w-full bg-white border border-gray-300 mb-4">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-6 py-2 text-left border-b">Payment ID</th>
        <th class="px-6 py-2 text-left border-b">Payment Date</th>
        <th class="px-6 py-2 text-left border-b">Amount</th>
        <th class="px-6 py-2 text-left border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="payment in paginatedAdminPayments" :key="payment.id" class="hover:bg-gray-50">
        <td class="px-6 py-4 border-b">{{ payment.id }}</td>
        <td class="px-6 py-4 border-b">{{ payment.paymentDate }}</td>
        <td class="px-6 py-4 border-b">{{ payment.amount }}</td>
        <td class="px-6 py-4 border-b">
          <button @click="viewPaymentDetails(payment)" class="text-blue-500 hover:underline">View</button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Pagination Controls -->
  <div class="flex justify-center items-center space-x-2 mb-4">
    <button
      @click="prevPage"
      :disabled="currentPage === 1"
      class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
    >
      Previous
    </button>
    <span>Page {{ currentPage }} of {{ totalPages }}</span>
    <button
      @click="nextPage"
      :disabled="currentPage === totalPages"
      class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
    >
      Next
    </button>
  </div>
</div>
</template>



<script setup>
import { ref, computed } from "vue";
import { apiService } from "~/api/apiService";

const materialDetail = ref(null);
const userInfo = ref({ userID: "" });
const users = ref([]);
const materials = ref([]);
const quotations = ref([]);
// Mock data for quotation details with new fields
const quotationDetails = ref([
  // Add more quotations as needed...
]);

// State variables
const isQuotationDetailInfo = ref(false);
const isQuoDetailModalOpen = ref(false);
const isQuoDetailEditMode = ref(false);
const isQuotationEditMode = ref(false);
const isQuotationModalOpen = ref(false);
const selectedQuotationDetail = ref(null);
const selectedQuotation = ref(null);
const searchQuery = ref("");
const quotationForm = ref({
  id: "",
  quoteID: "",
  quotationDate: "",
  userID: userInfo.value.userID,
  remarks: "",
});
const quotationDetailForm = ref({
  id: "",
  prodtnMtrlID: "",
  quantity: null,
  quotePrice: null,
  quoteID: "",
});


const activeTab = ref("quotations"); // Default active tab
const activeSubTab = ref("requests"); // Default sub-tab to show "Quotation Requests"

// Watch for changes on activeTab to reset activeSubTab
watch(activeTab, (newTab) => {
  if (newTab === 'quotations') {
    activeSubTab.value = 'requests'; // Reset to default sub-tab for quotations
  } else if (newTab === 'purchaseOrder') {
    activeSubTab.value = ''; // Clear sub-tab for purchase orders
  }
  // Add similar logic for other tabs if needed
});


// New methods for managing sub-tabs
const setActiveSubTab = (subTab) => {
  activeSubTab.value = subTab; // Set the active sub-tab
};
// const getUserName = (userID) => {

//   const user = users.value?.find((usr) => usr.userID === userID)
//   return user ? `${user.lastName} ${user.firstName}` : 'Unknown'
// }
// Computed properties
const filteredQuotationDetails = computed(() => {
  return quotations.value?.filter((quotation) => {
    return (
      // getUserName(quotation.userID).toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      quotation.remarks.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
});

// Pagination logic
const currentPage = ref(1);
const itemsPerPage = 5;
const totalPages = computed(() =>
  Math.ceil(filteredQuotationDetails.value.length / itemsPerPage)
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


// Modal functions
const openQuotationDetailAddModal = () => {
  isQuoDetailEditMode.value = false;
  resetForm();
  isQuoDetailModalOpen.value = true;
};

const openQuotationDetailEditModal = (quotation) => {
  selectedQuotationDetail.value = quotation;
  if (selectedQuotationDetail.value) {
    if (selectedQuotationDetail.value?.quotePrice !== null) {
      isQuoDetailEditMode.value = true;
    }
    Object.assign(quotationDetailForm.value, selectedQuotationDetail.value);
    //isQuoDetailModalOpen.value = true;
    getMaterialDetails(quotation.prodtnMtrlID);
  }
};

const openQuotationEditModal = (quotation) => {
  selectedQuotation.value = quotation;
  if (selectedQuotation.value) {
    isQuotationEditMode.value = true;
    Object.assign(quotationForm.value, selectedQuotation.value);
    isQuotationModalOpen.value = true;
  }
};

const openQuotationAddModal = () => {
  isQuotationModalOpen.value = true;
  isQuotationEditMode.value = false;
  quotationForm.value = {
    id: "",
    quoteID: "",
    quotationDate: "",
    userID: userInfo.value.userID,
    remarks: "",
  };
};

const openQuotationDetailInfo = async (quotation) => {
  quotationDetails.value = [];
  await fetchMaterialsByProductionID(quotation.productionID);
  selectedQuotation.value = quotation;
  isQuotationDetailInfo.value = true;
  const result = await apiService.get(
    `/api/quotationDetails/quotation/${quotation.quoteID}`
  );
  const transformData = materials.value?.map((material) => {
    let productMaterial = result?.quotation_details.find(
      (detail) =>
        detail.production_material.product_material.material.materialID ===
          material.materialID &&
        detail.production_material.product_material.productID ===
          material.productID
    );

    if (!productMaterial) {
      productMaterial = {
        prodtnMtrlID: material.prodtnMtrlID,
        quantity: material.qtyNeeded,
        quotePrice: null,
      };
    }
    return productMaterial;
  });
  console.log("transformData---", transformData);
  quotationDetails.value = transformData.map((value, index) => {
    return {
      ...value,
      id: index + 1,
    };
  });
};
const closQuoDetailModal = () => {
  isQuoDetailModalOpen.value = false;
};

const closeQuotationModal = () => {
  isQuotationModalOpen.value = false;
};

const closeQuotationDetailInfo = () => {
  isQuotationDetailInfo.value = false;
};

const resetForm = () => {
  quotationDetailForm.value = {
    id: "",
    prodtnMtrlID: "",
    quantity: null,
    quotePrice: null,
    quoteID: "",
  };
};

const saveQuotaion = async () => {
  try {
    if (isQuotationEditMode.value) {
      await apiService.put(
        `/api/quotations/${quotationForm.value.quoteID}`,
        quotationForm.value
      );
      const index = quotations.value.findIndex(
        (quo) => quo.quoteID === quotationForm.value.quoteID
      );
      if (index !== -1) {
        quotations.value[index] = { ...quotationForm.value };
      }
      alert("Quotation edited successfully");
    } else {
      const result = await apiService.post(
        "/api/quotations",
        quotationForm.value
      );
      const id = quotations.value.length + 1;
      quotations.value.push({ ...result.data, id });
      alert("Quotation added successfully");
    }
    isQuotationModalOpen.value = false;
  } catch (error) {
    console.log(error);
  }
};

const saveQuotationDetail = async () => {
  if (!quotationDetailForm.value?.quotePrice) {
    alert("Quote Price should not be blank!");
    return;
  }
  if (isQuoDetailEditMode.value) {
    // Update existing quotation detaiil
    const result = await apiService.put(
      `/api/quotationDetails/${quotationDetailForm.value.qteDetailID}`,
      { ...quotationDetailForm.value, quoteID: selectedQuotation.value.quoteID }
    );
    const index = quotationDetails.value?.findIndex(
      (value) => value.id === quotationDetailForm.value.id
    );
    // Object.assign(selectedQuotationDetail.value, quotationDetailForm.value);
    if (index !== -1) {
      quotationDetails.value[index] = { ...result.data, id: index + 1 };
    }
    alert("Quotation detail edited successfully!");
  } else {
    // Add new quotation detail
    const result = await apiService.post("/api/quotationDetails", {
      ...quotationDetailForm.value,
      quoteID: selectedQuotation.value.quoteID,
    });
    const index = quotationDetails.value?.findIndex(
      (value) => value.id === quotationDetailForm.value.id
    );
    if (index !== -1) {
      quotationDetails.value[index] = { ...result.data, id: index + 1 };
    }
    alert("Quotation detail added successfully!");
  }
  selectedQuotationDetail.value = null;
  isQuoDetailEditMode.value = false;
};

// Selecting a quotation
const selectQuotation = (quotation) => {
  selectedQuotationDetail.value = quotation;
};

const getMaterialDetails = (prodtnMtrlID) => {
  console.log(
    "prodtnMtrlID",
    prodtnMtrlID,
    materials.value?.find((val) => val.prodtnMtrlID == prodtnMtrlID)
  );
  materialDetail.value = materials.value?.find(
    (val) => val.prodtnMtrlID == prodtnMtrlID
  );
};

const getMaterialProductName = (prodtnMtrlID) => {
  const material = materials.value?.find(
    (val) => val.prodtnMtrlID == prodtnMtrlID
  );
  return `${material?.productName} -> ${material?.description}`;
};
// Fetching of APIs
const fetchUsers = async () => {
  const result = await apiService.get("/api/users");
  users.value = result.data;
};

const fetchQuotations = async () => {
  const result = await apiService.get("/api/quotations");
  quotations.value = result.data
    ?.filter((value) => value.userID == userInfo.value.userID)
    .map((value, index) => {
      return {
        ...value,
        id: index + 1,
      };
    });
};

const fetchMaterialsByProductionID = async (productionID) => {
  const result = await apiService.get(
    `/api/materials/production/${productionID}`
  );
  materials.value = result;
};

onMounted(async () => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
  }
  await fetchUsers();
  await fetchQuotations();
});
</script>


<style scoped>
  .tab {
  transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

.tab:hover {
  background-color: rgba(0, 0, 255, 0.1); /* Light blue background on hover */
  color: #000; /* Change text color on hover */
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
}
</style>