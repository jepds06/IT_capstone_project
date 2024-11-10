<template>
    <div class="p-6">
      <!-- Search and Action Buttons -->
      <div class="flex justify-between mb-4">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search..."
          class="w-1/3 p-2 border rounded-lg"
        />
        <!-- <div class="flex space-x-2">
          <button @click="openQuotationAddModal" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Quotation">
            <i class="fas fa-plus"></i>
            Add Quotation
          </button>
        </div> -->
      </div>
  
      <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-2 text-black text-left border-b">Quotation ID</th>
            <th class="px-6 py-2 text-black text-left border-b">
              Quotation Date
            </th>
            <th class="px-6 py-2 text-black text-left border-b">Remarks</th>
            <th class="px-6 py-2 text-black text-left border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="quotation in filteredQuotationDetails"
            :key="quotation.id"
            class="hover:bg-gray-50"
          >
            <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
            <td class="px-6 py-4 text-black border-b">
              {{ quotation.quotationDate }}
            </td>
            <td class="px-6 py-4 text-black border-b">{{ quotation.remarks }}</td>
            <td class="px-6 py-4 text-black border-b">
              <!-- <button
                 @click="openQuotationEditModal(quotation)"
                class="text-yellow-500 hover:text-yellow-700 ml-2"
                title="Edit Production"
              >
                <i class="fas fa-edit"></i>
              </button> -->
  
              <button
                @click="openQuotationDetailInfo(quotation)"
                class="text-blue-500 hover:underline ml-2"
              >
                <i class="fas fa-cogs"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Quotations Details Table -->
      <div
        v-if="isQuotationDetailInfo"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
        @click.self="closeQuotationDetailInfo"
      >
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-black">Quotation Details</h2>
          <label for="materialId" class="block mb-2 mt-4 text-black"
            >Quotation No:<span>{{ `QN-${selectedQuotation.id}` }}</span></label
          >
  
          <label for="materialId" class="block mb-2 mt-4 text-black"
            >Quotation Date:
            <span>{{ selectedQuotation.quotationDate }}</span></label
          >
  
          <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-6 py-2 text-black text-left border-b">ID</th>
                <th class="px-6 py-2 text-black text-left border-b">
                  Product Material
                </th>
                <th class="px-6 py-2 text-black text-left border-b">
                  Quantity
                </th>
                <th class="px-6 py-2 text-black text-left border-b">
                  Unit Price
                </th>
                <th class="px-6 py-2 text-black text-left border-b">
                  Total Price
                </th>
                <th class="px-6 py-2 text-black text-left border-b" v-if="!selectedQuotation.isCompleted">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="quotation in quotationDetails"
                :key="quotation.id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
                <td class="px-6 py-4 text-black border-b">
                  {{ getMaterialProductName(quotation.prodtnMtrlID) }}
                </td>
                <td class="px-6 py-4 text-black border-b">
                  {{ quotation.quantity }}
                </td>
                <td class="px-6 py-4 text-black border-b">
                  <div v-if="quotation.id === selectedQuotationDetail?.id">
                    <input
                      id="totalPrice"
                      v-model.number="quotationDetailForm.quotePrice"
                      type="number"
                      step="0.01"
                      placeholder="Enter total price"
                      required
                      class="w-full p-2 border rounded"
                    />
                  </div>
                  <div v-else>
                    {{
                      quotation.quotePrice
                        ? new Intl.NumberFormat("en-PH", {
                            style: "currency",
                            currency: "PHP",
                          }).format(quotation.quotePrice)
                        : 0
                    }}
                  </div>
                </td>
                <td class="px-6 py-4 text-black border-b">
                  {{
                    quotation.quotePrice
                      ? new Intl.NumberFormat("en-PH", {
                          style: "currency",
                          currency: "PHP",
                        }).format(quotation.quantity * quotation.quotePrice)
                      : 0
                  }}
                </td>
                <td class="px-6 py-4 text-black border-b" v-if="!selectedQuotation.isCompleted">
                  <div v-if="quotation.id === selectedQuotationDetail?.id">
                    <button
                      class="p-2 bg-red-500 text-white rounded hover:bg-red-600 mr-2"
                      title="Cancel"
                      @click="selectedQuotationDetail = null"
                    >
                      <i class="fas fa-close"></i>
                    </button>
                    <button
                      class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                      title="Save Quotation Detall"
                      @click="saveQuotationDetail"
                    >
                      <i class="fas fa-save"></i>
                    </button>
                  </div>
                  <div v-else>
                    <button
                      @click="openQuotationDetailEditModal(quotation)"
                      class="p-2 bg-green-500 text-white rounded hover:bg-green-600"
                      title="Edit Quotation"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
  
          <div class="flex  justify-between mt-2">
            <!-- <button @click="openQuotationDetailAddModal" class="p-2 mr-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Quotation Details">
          <i class="fas fa-plus"></i>
          Add Quotation Details
        </button> -->
            <UButton
              @click="closeQuotationDetailInfo"
              label="Close"
              color="red"
              icon="material-symbols:close"
            />
  
            <UButton
              icon="material-symbols-light:list-alt-check-outline-sharp"
              @click="completeQuotation"
              rounded="false"
              size="sm"
              :color="selectedQuotation.isCompleted ? 'gray' : 'blue'"
              :disabled="selectedQuotation.isCompleted"
              :loading="isCompleteLoading"
              title="Complete Quotation"
              label="Complete"
            />
          </div>
        </div>
      </div>
  
      <!-- Pagination Controls -->
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
  
      <!-- Modal for Adding/Editing Quotations Details -->
      <div
        v-if="isQuoDetailModalOpen"
        class="modal-overlay"
        @click.self="closQuoDetailModal"
      >
        <div class="modal-content">
          <h2 class="text-xl font-bold mb-4 text-black">
            {{
              isQuoDetailEditMode
                ? "Edit Quotation Detail"
                : "Add Quotation Detail"
            }}
          </h2>
          <form @submit.prevent="saveQuotationDetail">
            <label for="materialId" class="block mb-2 mt-4 text-black"
              >Material ID:</label
            >
            <select
              :disabled="isQuoDetailEditMode"
              v-model="quotationDetailForm.prodtnMtrlID"
              id="materialID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              @change="
                (e) => {
                  getMaterialDetails(e.target.value);
                  return e.target.value;
                }
              "
            >
              <option
                v-for="material in materials.filter(
                  (value) =>
                    !quotationDetails
                      .map((v) => v.prodtnMtrlID)
                      .includes(value.prodtnMtrlID)
                )"
                :key="material.prodtnMtrlID"
                :value="material.prodtnMtrlID"
              >
                {{ `${material.productName} -> ${material.description}` }}
              </option>
            </select>
            <div v-if="materialDetail" :key="quotationDetailForm.prodtnMtrlID">
              <label for="quantityQuoted" class="block mb-2 mt-4 text-black"
                >Quantity Needed: {{ materialDetail.qtyNeeded }}</label
              >
            </div>
            <label for="quantityQuoted" class="block mb-2 mt-4 text-black"
              >Quantity Quoted:</label
            >
            <input
              id="quantityQuoted"
              v-model.number="quotationDetailForm.quantity"
              type="number"
              placeholder="Enter quantity quoted"
              required
              class="w-full p-2 border rounded"
            />
  
            <label for="totalPrice" class="block mb-2 mt-4 text-black"
              >Total Price:</label
            >
            <input
              id="totalPrice"
              v-model.number="quotationDetailForm.quotePrice"
              type="number"
              step="0.01"
              placeholder="Enter total price"
              required
              class="w-full p-2 border rounded"
            />
  
            <div class="flex justify-end mt-4">
              <button
                type="button"
                @click="closQuoDetailModal"
                class="bg-gray-300 px-4 py-2 mr-2 rounded hover:bg-gray-400"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
              >
                {{ isQuoDetailEditMode ? "Update" : "Add" }}
              </button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Modal for Adding/Editing Quotations Details -->
      <div
        v-if="isQuotationModalOpen"
        class="modal-overlay"
        @click.self="closeQuotationModal"
      >
        <div class="modal-content">
          <h2 class="text-xl font-bold mb-4 text-black">
            {{ isQuotationEditMode ? "Edit Quotation" : "Add Quotation" }}
          </h2>
          <form @submit.prevent="saveQuotaion">
            <label for="quotationDate" class="block mb-2 mt-4 text-black"
              >Quotation Date:</label
            >
            <input
              id="quotationDate"
              v-model="quotationForm.quotationDate"
              type="date"
              required
              class="w-full p-2 border rounded"
            />
            <label for="remarks" class="block mb-2 mt-4 text-black"
              >Remarks:</label
            >
            <textarea
              id="remarks"
              v-model="quotationForm.remarks"
              placeholder="Enter any remarks"
              class="w-full p-2 border rounded"
            ></textarea>
  
            <div class="flex justify-end mt-4">
              <button
                type="button"
                @click="closeQuotationModal"
                class="bg-gray-300 px-4 py-2 mr-2 rounded hover:bg-gray-400"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
              >
                {{ isQuotationEditMode ? "Update" : "Add" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, defineProps } from "vue";
  import { apiService } from "~/api/apiService";
  
  // Define the `isCompleted` prop (optional)
const props = defineProps({
  isCompleted: {
    type: Boolean,
    default: false, // Default value is `false` if not provided
  },
});
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
  const isCompleteLoading = ref(false);
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
    quotationDetails.value = transformData.map((value, index) => {
      return {
        ...value,
        id: index + 1,
      };
    });
  };
  
  const completeQuotation = async() => {
    isCompleteLoading.value = true
    const result =  await apiService.put(`/api/quotations/${selectedQuotation.value.quoteID}`, {
              ...selectedQuotation.value,
              isCompleted: true
    });
    selectedQuotation.value = result.data
    isCompleteLoading.value = false
    alert("Quotation successfully completed");
  };
  
  const closQuoDetailModal = () => {
    isQuoDetailModalOpen.value = false;
  };
  
  const closeQuotationModal = () => {
    isQuotationModalOpen.value = false;
  };
  
  const closeQuotationDetailInfo = () => {
    isQuotationDetailInfo.value = false;
    selectedQuotationDetail.value = null
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
      await apiService.delete(
        `/api/quotationDetails/${quotationDetailForm.value.qteDetailID}`
      ); 
      const index = quotationDetails.value?.findIndex(
        (value) => value.id === quotationDetailForm.value.id
      );
      if (index !== -1) {
        quotationDetails.value[index] = { ...quotationDetailForm.value, id: index + 1 };
      }
      alert("Quotation detail added successfully!");
      selectedQuotationDetail.value = null;
      isQuoDetailEditMode.value = false;
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
      ?.filter((value) => value.userID == userInfo.value.userID && value.isCompleted == props.isCompleted ? 1 : 0 )
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
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    max-height: 80%;
    overflow-y: auto;
    width: 600px;
  }
  </style>