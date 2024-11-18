<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Productions</h2>

    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="w-1/3 p-2 border rounded-lg"
      />
      <div class="flex space-x-2">
        <button
          @click="openAddModal"
          class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600"
          title="Add Production"
        >
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>

    <table class="min-w-full bg-white border border-gray-300 shadow-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-left border-b">ID</th>
          <!-- <th class="px-6 py-2 text-left border-b">Created By</th> -->
          <th class="px-6 py-2 text-left border-b">Date Encoded</th>
          <th class="px-6 py-2 text-left border-b">Start Date</th>
          <th class="px-6 py-2 text-left border-b">Completion Date</th>
          <th class="px-6 py-2 text-left border-b">Remarks</th>
          <th class="px-6 py-2 text-left border-b">Status</th>
          <th class="px-6 py-2 text-left border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="production in paginatedProductions"
          :key="production.productionID"
          class="hover:bg-gray-50"
        >
          <td class="px-6 py-4 border-b">{{ production.productionID }}</td>
          <!-- <td class="px-6 py-4 border-b">
            {{ getUserName(production.userID) }}
          </td> -->
          <td class="px-6 py-4 border-b">{{ production.dateEncoded }}</td>
          <td class="px-6 py-4 border-b">{{ production.startDate }}</td>
          <td class="px-6 py-4 border-b">{{ production.completionDate }}</td>
          <td class="px-6 py-4 border-b">{{ production.remarks }}</td>
          <td class="px-6 py-4 border-b">
            <span
            :class="statusClass(production.status)"
            class="py-1 px-3 rounded-full text-white text-sm"
          >
           {{ production.status }}
          </span>
          </td>
          <td class="px-6 py-4 border-b">
            <!-- <button
              @click="openViewModal(production)"
              class="text-green-500 hover:text-green-700"
              title="View Production"
            >
              <i class="fas fa-eye"></i>
            </button> -->
            <button
              @click="openEditModal(production)"
              class="text-yellow-500 hover:text-yellow-700 ml-2"
              title="Edit Production"
            >
              <i class="fas fa-edit"></i>
            </button>

            <button
              @click="showProductionDetails(production)"
              class="text-blue-500 hover:underline ml-2"
              title="Production Details View"
            >
              <i class="fas fa-cogs"></i>
            </button>
            <!-- <button
              @click="openDeleteModal(production)"
              class="text-red-500 hover:text-red-700 ml-2"
              title="Delete Production"
            >
              <i class="fas fa-trash"></i>
            </button> -->
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-between">
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

    <!-- Modal for Add/Edit Production -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">
          {{ isEditMode ? "Edit Production" : "Add Production" }}
        </h2>
        <form @submit.prevent="confirmProductiontSave">
          <label for="year" class="block mb-2 mt-4">Start Date:</label>
          <input
            id="startDate"
            v-model="productionForm.startDate"
            type="date"
            class="w-full p-2 border rounded"
          />
          <label for="month" class="block mb-2 mt-4">Completion Date:</label>
          <input
            id="completionDate"
            v-model="productionForm.completionDate"
            type="date"
            class="w-full p-2 border rounded"
          />

          <label for="remarks" class="block mb-2 mt-4">Remarks:</label>
          <input
            id="remarks"
            v-model="productionForm.remarks"
            placeholder="Enter remarks"
            class="w-full p-2 border rounded"
          />

          <div v-if="isEditMode">
            <label for="status" class="block mb-2 mt-4">Status:</label>
            <select
              disabled
              v-model="productionForm.status"
              id="userID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            >
              <option v-for="status in statuses" :key="status" :value="status">
                {{ status }}
              </option>
            </select>
          </div>

          <div class="flex justify-end mt-4">
            <button
              type="button"
              @click="closeModal"
              class="bg-gray-300 px-4 py-2 mr-2 rounded hover:bg-gray-400"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              {{ isEditMode ? "Update" : "Add" }}
            </button>
          </div>
        </form>
      </div>
    </div>

     <!-- Confirmation Modal Production-->
     <div v-if="isProductionConfirmationVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-black">Are you sure you want to proceed?</h3>
        <div class="flex justify-end mt-4">
          <button class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2" @click="saveProduction">
            Yes
          </button>
          <button class="text-red-600 py-1 px-3 rounded-md" @click="closeProductionConfirmation">
            No
          </button>
        </div>
      </div>
    </div>

   <!-- Success Message for Production Modal -->
<div v-if="isSuccessProductionVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
    <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
    <p class="text-black">
      Production has been {{ isEditMode ? 'updated' : 'created' }} successfully!
    </p>
    <div class="flex justify-end mt-4">
      <button class="bg-blue-500 text-white py-1 px-3 rounded-md" @click="closeProductionConfirmation">
        OK
      </button>
    </div>
  </div>
</div>

    <!-- Modal for Viewing Production Details -->
    <!-- Modal for Viewing Production Details -->
    <div
      v-if="isViewModalOpen"
      class="modal-overlay"
      @click.self="closeViewModal"
    >
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">Production Details</h2>
        <div>
          <p>
            <strong>Production Details No:</strong>
            {{ selectedProduction.detailsNo }}
          </p>
          <p><strong>Production ID:</strong> {{ selectedProduction.id }}</p>
          <p><strong>Quantity:</strong> {{ selectedProduction.quantity }}</p>
          <p>
            <strong>Status:</strong>
            <span class="inline-flex items-center">
              <i
                v-if="selectedProduction.status === 'active'"
                class="fas fa-check-circle text-green-500"
              ></i>
              <i
                v-else-if="selectedProduction.status === 'inactive'"
                class="fas fa-times-circle text-red-500"
              ></i>
              <span class="ml-1">{{ selectedProduction.status }}</span>
            </span>
          </p>
          <p><strong>Remarks:</strong> {{ selectedProduction.remarks }}</p>
        </div>
        <div class="flex justify-end mt-4">
          <!-- <button
            @click="openGenerateMaterialsModal(selectedProduction)"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2"
          >
            Generate Materials
          </button> -->
          <button
            @click="closeViewModal"
            class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
          >
            Close
          </button>
        </div>
      </div>
    </div>

    <!-- Modal for Generating Materials -->
    <div
      v-if="isGenerateMaterialsModalOpen"
      class="modal-overlay"
      @click.self="closeGenerateMaterialsModal"
    >
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">
          Generate Materials for Production ID: {{ selectedProduction.id }}
        </h2>
        <p>Are you sure you want to generate materials for this production?</p>
        <div class="flex justify-end mt-4">
          <button
            @click="confirmGenerateMaterials"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          >
            Generate
          </button>
          <button
            @click="closeGenerateMaterialsModal"
            class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="isDeleteModalOpen"
      class="modal-overlay"
      @click.self="closeDeleteModal"
    >
      <div class="modal-content">
        <h3 class="text-lg font-bold">Delete Production</h3>
        <p>
          Are you sure you want to delete production ID
          {{ selectedProduction?.id }}?
        </p>
        <div class="flex justify-end mt-4">
          <button
            @click="confirmDelete"
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
          >
            Delete
          </button>
          <button
            @click="closeDeleteModal"
            class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="isProductionDetailsInfo"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative">
        <!-- Close Button -->
        <button
          @click="closeProductionInfo"
          class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"
        >
          <i class="fas fa-times"></i>
        </button>
        <div class="flex justify-between">
          <h2 class="text-lg text-black font-semibold mb-4">
            Production Details
          </h2>
          <!-- <span>{{selectedProduction.deliveryStatus}}</span> -->
          <UButton :loading="isLoadingMarkAsCompleted" @click="markAsCompleted" class="mb-4" icon="material-symbols-light:list-alt-check-outline-sharp" label="Mark as Completed" :disabled="selectedProduction.deliveryStatus === 'In Progress' || (selectedProduction.status === 'Completed' || selectedProduction.status === 'Pending')" />
        </div>
        
        <!-- Product Info View Table (Read-Only) -->
        <table class="min-w-full border border-gray-300 rounded-lg mb-4">
          <thead class="bg-gray-200">
            <tr class="p-2 border-b text-black text-center">
              <th>Production ID</th>
              <!-- <th>Created By</th> -->
              <th>Date Encoded</th>
              <th>Start Date</th>
              <th>Completion Date</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            <tr class="p-2 border-b text-black text-center">
              <td class="px-6 py-4 border-b">
                {{ selectedProduction.productionID }}
              </td>
              <!-- <td class="px-6 py-4 border-b">
                {{ getUserName(selectedProduction.userID) }}
              </td> -->
              <td class="px-6 py-4 border-b">
                {{ selectedProduction.dateEncoded }}
              </td>
              <td class="px-6 py-4 border-b">
                {{ selectedProduction.startDate }}
              </td>
              <td class="px-6 py-4 border-b">
                {{ selectedProduction.completionDate }}
              </td>
              <td class="px-6 py-4 border-b">
                {{ selectedProduction.remarks }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mb-4">
          <table
            class="min-w-full border border-gray-300 rounded-lg"
            :key="selectedProductionDetails.length"
          >
            <thead class="bg-gray-100">
              <tr class="p-2 border-b text-black text-center">
                <th>ID</th>
                <th>Product</th>
                <th>Qty.</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody v-if="selectedProductionDetails.length > 0">
              <tr
                v-for="prodDetail in selectedProductionDetails"
                :key="prodDetail.prodtnDetailID"
                class="p-2 border-b text-black text-center"
              >
                <td>{{ prodDetail.prodtnDetailID }}</td>
                <td>{{ getProduct(prodDetail.productID) }}</td>
                <td>{{ prodDetail.quantity }}</td>
                <td>{{ prodDetail.status }}</td>
                <td>{{ prodDetail.remarks }}</td>
                <td
                  class="p-2 border-b text-center flex justify-center space-x-2"
                >
                  <button
                    @click="editProductionDetail(prodDetail)"
                    class="text-yellow-500 hover:underline"
                  >
                    <i class="fas fa-edit"></i>
                  </button>
                  <!-- <button @click="removeMaterial(material)" class="text-red-500 hover:underline">
                    <i class="fas fa-trash"></i>
                  </button> -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex justify-end">
          <UButton
            icon="oui:ml-create-single-metric-job"
            @click="openProductionDetailModal"
            :color="isQuotationRequested ? 'gray' : 'blue'"
            :disabled="isQuotationRequested"
            class="mr-2"
            label="Add Production Details"
          />
          <UButton
            icon="material-symbols:request-quote-outline"
            :loading="isLoadingQuotationRequested"
            @click="confirmQuotationSave"
            size="sm"
            :color="isQuotationRequested || selectedProductionDetails.length === 0 ? 'gray' : 'green'"
            :disabled="isQuotationRequested || selectedProductionDetails.length === 0"
            label="Request Quotation"
          />
        </div>
      </div>
    </div>

    <!-- Confirmation Modal Request Quotation-->
    <div v-if="isQuotationConfirmationVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-black">Are you sure you want to proceed?</h3>
        <div class="flex justify-end mt-4">
          <button class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2" @click="requestQuotation">
            Yes
          </button>
          <button class="text-red-600 py-1 px-3 rounded-md" @click="closeQuotationConfirmation">
            No
          </button>
        </div>
      </div>
    </div>

    <!-- Success Message for Request Quotation -->
    <div v-if="isSuccessQuotationVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
          <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
          <p class="text-black">
            Quotation has been {{ quotationMode ? 'updated' : 'requested' }} successfully!
          </p>
        <div class="flex justify-end mt-4">
          <button class="bg-blue-500 text-white py-1 px-3 rounded-md" @click="closeQuotationConfirmation">
          OK
          </button>
        </div>
      </div>
    </div>

    <!-- Modal for Adding Production Details -->
    <div
      v-if="isProductionDetailsModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close Button -->
        <button
          @click="closeProductionDetailModal"
          class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"
        >
          <i class="fas fa-times"></i>
        </button>
        <h2 class="text-lg font-semibold mb-4">
          {{
            productionDetailMode === "add"
              ? "Add Production Detail"
              : "Edit Production Detail"
          }}
        </h2>
        <form @submit.prevent="confirmProductionDetailtSave">
          <div class="mb-4" v-if="formMode === 'edit'">
            <label
              for="materialId"
              class="block text-sm font-medium text-gray-700"
              >Product Material Id</label
            >
            <input
              v-model="productionDetailForm.prodtnDetailID"
              type="text"
              id="productMatsID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              :readonly="materialMode === 'edit'"
            />
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700"
              >Product</label
            >
            <select
              v-model="productionDetailForm.productID"
              id="prodCat"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              :disabled=" productionDetailMode === 'edit'"
            >
              <option
                v-for="product in notAddedProducts"
                :key="product.productID"
                :value="product.productID"
              >
                {{ product.productName }}
              </option>
            </select>
          </div>
          <div class="mb-4" v-if="productionDetailMode !== 'add'">
            <label for="status" class="block text-sm font-medium text-gray-700"
              >Status</label
            >
            <select
              v-model="productionDetailForm.status"
              id="userID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            >
              <option v-for="status in statuses" :key="status" :value="status">
                {{ status }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700"
              >Remarks</label
            >
            <input
              v-model="productionDetailForm.remarks"
              id="remarks"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="mb-4">
            <label for="qty" class="block text-sm font-medium text-gray-700"
              >Quantity</label
            >
            <input
              v-model="productionDetailForm.quantity"
              type="number"
              id="qty"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
            >
              Save
            </button>
            <button
              @click="closeProductionDetailModal"
              class="ml-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            >
              Cancel
          </button>
        </div>
      </form>
    </div>
  </div>


    <!-- Confirmation Modal Production Details-->
    <div v-if="isProductionDetailConfirmationVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-black">Are you sure you want to proceed?</h3>
        <div class="flex justify-end mt-4">
          <button class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2" @click="saveProductionDetail">
            Yes
          </button>
          <button class="text-red-600 py-1 px-3 rounded-md" @click="closeProductionDetailConfirmation">
            No
          </button>
        </div>
      </div>
    </div>

     <!-- Success Message for Product Production Details -->
     <div v-if="isSuccessProductionDetailVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
          <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
          <p class="text-black">
            Production Detail has been {{ productionDetailMode === 'add' ? 'created' : 'updated' }} successfully!
          </p>
        <div class="flex justify-end mt-4">
          <button class="bg-blue-500 text-white py-1 px-3 rounded-md" @click="closeProductionDetailConfirmation">
          OK
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { apiService } from "~/api/apiService";
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from "vue";

const productions = ref([
  // {
  //   id: 1,
  //   detailsNo: "PD-001",
  //   quantity: 100,
  //   status: "active",
  //   createdBy: "Admin",
  //   dateEncoded: "2024-09-23",
  //   year: 2024,
  //   month: "September",
  //   remarks: "Initial production",
  // },
  // {
  //   id: 2,
  //   detailsNo: "PD-002",
  //   quantity: 200,
  //   status: "inactive",
  //   createdBy: "User1",
  //   dateEncoded: "2024-09-22",
  //   year: 2024,
  //   month: "September",
  //   remarks: "Follow-up production",
  // },
  // Add more sample data as needed for testing pagination
]);

const userInfo = ref({ userID: "" });
const selectedProductionDetails = ref([]);
const users = ref([]);

const productionDetailMode = ref("add");

const products = ref([]);
const notAddedProducts = ref([]);

function formatDate(date) {
  var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

const statuses = ["Pending", "In Progress", "Completed"];

const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 5;

const quotations = ref([]);
const isLoadingMarkAsCompleted = ref(false);
const isSuccessProductionVisible = ref(false);
const isProductionConfirmationVisible = ref(false);
const isSuccessProductionDetailVisible = ref(false);
const isProductionDetailConfirmationVisible = ref(false);
const isSuccessQuotationVisible = ref(false);
const isQuotationConfirmationVisible = ref(false);

const isLoadingQuotationRequested = ref(false);
const isQuotationRequested = ref(false);
const isProductionDetailsInfo = ref(false);
const isProductionDetailsModal = ref(false);
const isModalOpen = ref(false);
const isViewModalOpen = ref(false);
const isGenerateMaterialsModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedProduction = ref(null);
const isEditMode = ref(false);
const productionForm = ref({
  userID: userInfo.value.userID,
  dateEncoded: formatDate(new Date()),
  completionDate: "",
  startDate: "",
  remarks: "",
  status: "Pending",
  productionID: "",
});

const productionDetailForm = ref({
  prodtnDetailID: "",
  productionID: "",
  productID: "",
  quantity: "",
  status: "Pending",
  remarks: "",
});

const productionInfo = ref(null);

const statusClass = ( status) => {
  switch (status) {
    case "Pending":
      return "bg-yellow-500";
    case "Completed":
      return "bg-green-500";
    case "In Progress":
      return "bg-red-500";
    default:
      return "bg-gray-500";
  }
}
const openProductionDetailModal = async () => {
  if(selectedProductionDetails.value.length > 0){
    console.log("selectedProductionDetails", selectedProductionDetails)
    const addedProducts = selectedProductionDetails.value.map((val) => val.productID)
    notAddedProducts.value = products.value?.filter((product) => !addedProducts.includes(product.productID))
  } else {
    notAddedProducts.value = products.value
  }
  productionDetailMode.value = "add";
  isProductionDetailsModal.value = true;
  productionDetailForm.value = {
    prodtnDetailID: "",
    productionID: "",
    productID: "",
    quantity: "",
    status: "Pending",
    remarks: "",
  };
};

const confirmProductiontSave = () => {
  isProductionConfirmationVisible.value = true;
};
const closeProductionConfirmation = () => {
  isProductionConfirmationVisible.value = false;
  isSuccessProductionVisible.value = false;
};

const showSuccessProductionMessage = (message) => {
  isSuccessProductionVisible.value = true;
  setTimeout(() => {
  }, 3000); // Automatically close after 3 seconds
  };

  const confirmProductionDetailtSave = () => {
    isProductionDetailConfirmationVisible.value = true;
};
const closeProductionDetailConfirmation = () => {
  isProductionDetailConfirmationVisible.value = false;
  isSuccessProductionDetailVisible.value = false;
};

const showSuccessProductionDetailMessage = (message) => {
  isSuccessProductionDetailVisible.value = true;
  setTimeout(() => {
  }, 3000); // Automatically close after 3 seconds
  };
  const closeProductionDetailModal = () => {
    isProductionDetailsModal.value = false;
  }

const confirmQuotationSave = () => {
  isQuotationConfirmationVisible.value = true;
};
const closeQuotationConfirmation = () => {
  isQuotationConfirmationVisible.value = false;
  isSuccessQuotationVisible.value = false;
};

const showSuccessQuotationMessage = (message) => {
  isSuccessQuotationVisible.value = true;
  setTimeout(() => {
  }, 3000); // Automatically close after 3 seconds
  };

const filterQuotation = (productionID) => {
  const data = quotations.value?.filter(
    (value) => value.productionID === productionID
  );
  isQuotationRequested.value = data.length > 0;
};

const showProductionDetails = async (production) => {
  
  filterQuotation(production.productionID);
  selectedProduction.value = production;
  await fetchProductsData();
  await fetchProductionDetailsData();
  await fetchProductionByIDData();
  
  isProductionDetailsInfo.value = true;
  selectedProduction.value = {
    ...selectedProduction.value,
    deliveryStatus: productionInfo.value?.some((value) => value !== 'Delivered') ? 'In Progress' : 'Delivered'
  }
  productionForm.value = { ...production, status: productionInfo.value?.some((value) => value !== 'Delivered') ? production.status : 'Completed' }; 
};

const closeProductionInfo = () => {
  isProductionDetailsInfo.value = false;
};

const filteredProductions = computed(() => {
  return productions.value.filter((production) =>
    getUserName(production.userID)
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase())
  );
});

const totalPages = computed(() => {
  return Math.ceil(filteredProductions.value.length / itemsPerPage);
});

const paginatedProductions = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredProductions.value.slice(start, start + itemsPerPage);
});

const openAddModal = () => {
  isModalOpen.value = true;
  isEditMode.value = false; // Set to false for adding
  productionForm.value = {
    userID: userInfo.value.userID,
    dateEncoded: formatDate(new Date()),
    completionDate: "",
    startDate: "",
    remarks: "",
    status: "Pending",
    productionID: "",
  };
};

const openEditModal = (production) => {
  isModalOpen.value = true;
  isEditMode.value = true; // Set to true for editing
  productionForm.value = { ...production }; // Load existing production data
};


const editProductionDetail = (prodDetail) => {
  notAddedProducts.value = products.value
  productionDetailMode.value = "edit";
  productionDetailForm.value = { ...prodDetail };
  isProductionDetailsModal.value = true;
};

const requestQuotation = async () => {
  isLoadingQuotationRequested.value = true
  if (users.value.filter((user) => user.userTypeID === 3).length > 0) {
    await Promise.all(
      users.value
        .filter((user) => user.userTypeID === 3)
        .map(async (user) => {
          await apiService.post("/api/quotations", {
            quotationDate: formatDate(new Date()),
            userID: user.userID,
            remarks: selectedProduction.value.remarks ?? "NA",
            productionID: selectedProduction.value.productionID,
            isCompleted: false
          });
        })
    );
    await fetchQuotationData();
    isLoadingQuotationRequested.value = false
    showSuccessQuotationMessage("Quotation requested successfully");
    isProductionDetailsInfo.value = false;
  } else {
    showSuccessQuotationMessage("Supplier list is empty!");
  }
};


const saveProduction = async () => {
  if (isEditMode.value) {
    await apiService.put(
      `/api/productions/${productionForm.value.productionID}`,
      productionForm.value
    );
    const index = productions.value.findIndex(
      (p) => p.productionID === productionForm.value.productionID
    );
    if (index !== -1) {
      productions.value[index] = { ...productionForm.value };
    }
    showSuccessProductionMessage(productionForm.value.status === "Completed" ? "Production completed successfully!" : "Production edited successfully!");
  } else {
    const result = await apiService.post(
      "/api/productions",
      productionForm.value
    );
    productions.value.push({
      ...productionForm.value,
      productionID: result.data.productionID,
    });
    showSuccessProductionMessage("Production created successfully!");
  }
  isProductionDetailsInfo.value = false
  closeModal();
};

const markAsCompleted = async () => {
  isEditMode.value = true;
  isLoadingMarkAsCompleted.value = true
  await Promise.all(selectedProductionDetails.value?.map(async(value) => {
    return await apiService.put(`/api/productionDetails/${value.prodtnDetailID}`, {...value, status: "Completed"})
  }))
  const finishedProducts = selectedProductionDetails.value?.map((value) => {
    return {
      prodtnDetailID: value.prodtnDetailID,
      productionDate: formatDate(new Date()),
      quantity: value.quantity,
      unitPrice: value.product.unitPrice,
      status: "Completed",
      remarks: selectedProduction.value.remarks
    }
  })
  console.log("finishedProducts", finishedProducts)
  await Promise.all(finishedProducts?.map(async(value) => {
    return await apiService.post("/api/finishedProducts", value)
  }))
  await saveProduction()
  isLoadingMarkAsCompleted.value = false
}
const saveProductionDetail = async () => {
  if (productionDetailMode.value === "add") {
    const result = await apiService.post("/api/productionDetails", {
      ...productionDetailForm.value,
      productionID: selectedProduction.value.productionID,
    });
    selectedProductionDetails.value.push({
      ...productionDetailForm.value,
      productionID: selectedProduction.value.productionID,
      prodtnDetailID: result.data.prodtnDetailID,
    });
    showSuccessProductionDetailMessage(
      `Production detail added successfully for Production No. ${selectedProduction.value.productionID}`
    );
  } else {
    await apiService.put(
      `/api/productionDetails/${productionDetailForm.value.prodtnDetailID}`,
      {
        ...productionDetailForm.value,
        productionID: selectedProduction.value.productionID,
      }
    );
    const index = selectedProductionDetails.value.findIndex(
      (p) => p.prodtnDetailID === productionDetailForm.value.prodtnDetailID
    );
    if (index !== -1) {
      selectedProductionDetails.value[index] = {
        ...productionDetailForm.value,
      };
    }
    showSuccessProductionDetailMessage(
      `Production detail edited successfully for Production No. ${selectedProduction.value.productionID}`
    );
  }
  closeProductionDetailModal();
};

const closeModal = () => {
  isModalOpen.value = false;
};

const openViewModal = (production) => {
  selectedProduction.value = production;
  isViewModalOpen.value = true;
};

const closeViewModal = () => {
  isViewModalOpen.value = false;
};

const openGenerateMaterialsModal = (production) => {
  selectedProduction.value = production;
  isGenerateMaterialsModalOpen.value = true;
};

const closeGenerateMaterialsModal = () => {
  isGenerateMaterialsModalOpen.value = false;
};

const confirmGenerateMaterials = () => {
  console.log(
    "Materials generated for production ID:",
    selectedProduction.value.id
  );
  closeGenerateMaterialsModal();
};

const openDeleteModal = (production) => {
  selectedProduction.value = production;
  isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
  isDeleteModalOpen.value = false;
};

const confirmDelete = () => {
  productions.value = productions.value.filter(
    (p) => p.id !== selectedProduction.value.id
  );
  closeDeleteModal();
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const getUserName = (userID) => {
  const user = users.value?.find((usr) => usr.userID === userID);
  return `${user.lastName}, ${user.firstName}`;
};

const getProduct = (productID) => {
  const product = products.value?.find((prod) => prod.productID === productID);
  return product.productName ?? "Unknown";
};

const fetchQuotationData = async () => {
  const result = await apiService.get("/api/quotations");
  quotations.value = result.data;
};

const fetchUsersData = async () => {
  const result = await apiService.get("/api/users");
  users.value = result.data;
};

const fetchProductionData = async () => {
  const result = await apiService.get("/api/productions");
  productions.value = result.data;
};

const fetchProductsData = async () => {
  const result = await apiService.get("/api/products");
  products.value = result.data;
};

const fetchProductionDetailsData = async () => {
  const result = await apiService.get(
    `/api/productionDetails/production/${selectedProduction.value.productionID}`
  );
  selectedProductionDetails.value = result?.production_details;
};

const fetchProductionByIDData = async () => {
  const result = await apiService.get(
    `/api/productions/${selectedProduction.value.productionID}`
  );
  productionInfo.value = result?.data?.quotations?.map((value) => {
    console.log("value", value)
    const deliveryStatus = value?.admin_orders?.admin_deliveries?.deliveryStatus ?? ''
    return deliveryStatus
  });
};

onMounted(() => {
  fetchUsersData();
  fetchProductionData();
  fetchQuotationData();
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
  }
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
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  width: 100%;
}
</style>
