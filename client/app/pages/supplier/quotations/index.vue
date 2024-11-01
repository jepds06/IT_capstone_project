<template>
  <div class="p-6">
    <!-- Title -->
    <h2 class="text-2xl font-bold mb-4">Supplier Dashboard</h2>

    <!-- Tabs -->
    <div class="mb-4">
      <ul class="flex space-x-4 border-b">
        <li 
          class="cursor-pointer pb-2 tab" 
          :class="{'border-b-2 border-blue-500': activeTab === 'quotations'}" 
          @click="activeTab = 'quotations'">Quotations
        </li>
        <li 
          class="cursor-pointer pb-2 tab" 
          :class="{'border-b-2 border-blue-500': activeTab === 'purchaseOrder'}" 
          @click="activeTab = 'purchaseOrder'">Purchase Order
        </li>
        <li 
          class="cursor-pointer pb-2 tab" 
          :class="{'border-b-2 border-blue-500': activeTab === 'adminPayments'}" 
          @click="activeTab = 'adminPayments'">Admin Payments
        </li>
      </ul>
    </div>
    
    <!-- Sub-tabs for Quotations -->
    <div class="mb-4" v-if="activeTab === 'quotations'"> <!-- Conditional rendering -->
      <ul class="flex space-x-4">
        <li @click="setActiveSubTab('requests')" class="cursor-pointer pb-2 tab" :class="{ 'border-b-2 border-blue-500': activeSubTab === 'requests' }">Quotation Requests</li>
        <li @click="setActiveSubTab('cancelled')" class="cursor-pointer pb-2 tab" :class="{ 'border-b-2 border-blue-500': activeSubTab === 'cancelled' }">Cancelled Quotations</li>
      </ul>
    </div>

    <!-- Quotation Requests Table -->
    <div v-if="activeTab === 'quotations' && activeSubTab === 'requests'">
      <h3 class="text-xl font-semibold mb-2">Quotation Requests</h3>
      <table class="min-w-full bg-white border border-gray-300 mb-4">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-2 text-black text-left border-b">Request ID</th>
            <th class="px-6 py-2 text-black text-left border-b">Request Date</th>
            <th class="px-6 py-2 text-black text-left border-b">Remarks</th>
            <th class="px-6 py-2 text-black text-left border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="request in paginatedQuotationRequests" :key="request.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 text-black border-b">{{ request.id }}</td>
            <td class="px-6 py-4 text-black border-b">{{ request.requestDate }}</td>
            <td class="px-6 py-4 text-black border-b">{{ request.details }}</td>
            <td class="px-6 py-4 text-black border-b">
              <button @click="viewRequestDetails(request)" class="text-blue-500 hover:underline">View Details</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination Controls for Quotation Requests -->
      <div class="mt-4 flex justify-between">
        <button @click="prevRequestPage" :disabled="currentRequestPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Previous
        </button>
        <span>Page {{ currentRequestPage }} of {{ totalRequestPages }}</span>
        <button @click="nextRequestPage" :disabled="currentRequestPage === totalRequestPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Next
        </button>
      </div>
    </div>

    <!-- Cancelled Quotations Table -->
    <div v-if="activeTab === 'quotations' && activeSubTab === 'cancelled'">
      <h3 class="text-xl font-semibold mb-2">Cancelled Quotations</h3>
      <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-2 text-black text-left border-b">Request ID</th>
            <th class="px-6 py-2 text-black text-left border-b">Cancellation Date</th>
            <th class="px-6 py-2 text-black text-left border-b">Remarks</th>
            <th class="px-6 py-2 text-black text-left border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cancelled in paginatedCancelledQuotations" :key="cancelled.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 text-black border-b">{{ cancelled.id }}</td>
            <td class="px-6 py-4 text-black border-b">{{ cancelled.cancellationDate }}</td>
            <td class="px-6 py-4 text-black border-b">{{ cancelled.remarks }}</td>
            <td class="px-6 py-4 text-black border-b">
              <button @click="restoreCancelledQuotation(cancelled)" class="text-green-500 hover:underline">Restore</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination Controls for Cancelled Quotations -->
      <div class="mt-4 flex justify-between">
        <button @click="prevCancelledPage" :disabled="currentCancelledPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Previous
        </button>
        <span>Page {{ currentCancelledPage }} of {{ totalCancelledPages }}</span>
        <button @click="nextCancelledPage" :disabled="currentCancelledPage === totalCancelledPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Next
        </button>
      </div>
    </div>

    <!-- Existing Quotation Table and Functionality -->
    <h2 class="text-2xl font-bold mb-4">Quotations</h2>
    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="w-1/3 p-2 border rounded-lg"
      />
    </div>

    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-black text-left border-b">Quotation ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Quotation Date</th>
          <th class="px-6 py-2 text-black text-left border-b">Remarks</th>
          <th class="px-6 py-2 text-black text-left border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in filteredQuotationDetails" :key="quotation.id" class="hover:bg-gray-50">
          <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.quotationDate }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.remarks }}</td>
          <td class="px-6 py-4 text-black border-b">
            <button @click="openQuotationDetailInfo(quotation)" class="text-blue-500 hover:underline ml-2">
              <i class="fas fa-cogs"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls for Quotations -->
    <div class="mt-4 flex justify-between">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Next
      </button>
    </div>

    <!-- Modal for Adding/Editing Quotations Details -->
    <div v-if="isQuoDetailModalOpen" class="modal-overlay" @click.self="closQuoDetailModal">
      <div class="modal-content">
        <h2 class="text-2xl font-bold mb-4 text-black">{{ isEditMode ? 'Edit' : 'Add' }} Quotation Details</h2>
        <form @submit.prevent="saveQuotationDetails">
          <input v-model="quotationDetailData.quotationDate" type="date" class="mb-4" required />
          <input v-model="quotationDetailData.remarks" type="text" placeholder="Remarks" class="mb-4" required />
          <button type="submit" class="bg-blue-500 text-white rounded hover:bg-blue-600">
            {{ isEditMode ? 'Update' : 'Save' }}
          </button>
          <button @click="closQuoDetailModal" type="button" class="bg-red-500 text-white rounded hover:bg-red-600 ml-4">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</template>





<script setup>
import { ref, computed, onMounted } from "vue";
import { apiService } from "~/api/apiService";

const materialDetail = ref(null);
const userInfo = ref({ userID: "" });
const users = ref([]);
const materials = ref([]);
const quotations = ref([]);

// Mock data for quotation details with new fields
const quotationDetails = ref([]);

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

// State for tab management
const activeTab = ref("quotationRequest"); // Default active tab
const activeSubTab = ref("requests"); // Default sub-tab to show "Quotation Requests"
const isDemoModalOpen = ref(false); // Modal state

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
// Pagination logic for Quotation Requests 
const currentQuotationRequestPage = ref(1);
const itemsPerQuotationRequestPage = 5;
const totalQuotationRequestPages = computed(() =>
  Math.ceil(filteredQuotationRequests.value.length / itemsPerQuotationRequestPage)
);

const prevQuotationRequestPage = () => {
  if (currentQuotationRequestPage.value > 1) {
    currentQuotationRequestPage.value--;
  }
};

const nextQuotationRequestPage = () => {
  if (currentQuotationRequestPage.value < totalQuotationRequestPages.value) {
    currentQuotationRequestPage.value++;
  }
};

// Pagination logic for Cancelled Quotations
const currentCancelledQuotationPage = ref(1);
const itemsPerCancelledQuotationPage = 5;
const totalCancelledQuotationPages = computed(() =>
  Math.ceil(filteredCancelledQuotations.value.length / itemsPerCancelledQuotationPage)
);

const prevCancelledQuotationPage = () => {
  if (currentCancelledQuotationPage.value > 1) {
    currentCancelledQuotationPage.value--;
  }
};

const nextCancelledQuotationPage = () => {
  if (currentCancelledQuotationPage.value < totalCancelledQuotationPages.value) {
    currentCancelledQuotationPage.value++;
  }
};

// New methods for managing sub-tabs
const setActiveSubTab = (subTab) => {
  activeSubTab.value = subTab; // Set the active sub-tab
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
    // Update existing quotation detail
    const result = await apiService.put(
      `/api/quotationDetails/${quotationDetailForm.value.qteDetailID}`,
      { ...quotationDetailForm.value, quoteID: selectedQuotation.value.quoteID }
    );
    const index = quotationDetails.value?.findIndex(
      (value) => value.id === quotationDetailForm.value.id
    );
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

// Fetch quotations on mount
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
