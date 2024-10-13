<template>
  <div class="p-6">
    <!-- Title -->
    <h2 class="text-2xl font-bold mb-4">Quotations</h2>

    <!-- Search and Action Buttons -->
    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="w-1/3 p-2 border rounded-lg"
      />
      <div class="flex space-x-2">
        <button @click="openQuotationAddModal" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Quotation">
          <i class="fas fa-plus"></i>
          Add Quotation
        </button>
      </div>
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
        <tr v-for="quotation in filteredQuotationDetails" :key="quotation.id" class="hover:bg-gray-50" @click="selectQuotation(quotation)">
          <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.quotationDate }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.remarks }}</td>
          <td class="px-6 py-4 text-black border-b">
            <button
               @click="openQuotationEditModal(quotation)"
              class="text-yellow-500 hover:text-yellow-700 ml-2"
              title="Edit Production"
            >
              <i class="fas fa-edit"></i>
            </button>

            <button 
            @click="openQuotationDetailInfo" 
            class="text-blue-500 hover:underline ml-2">
              <i class="fas fa-cogs"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Quotations Details Table -->
    <div v-if="isQuotationDetailInfo" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" @click.self="closeQuotationDetailInfo">
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4 text-black">Quotation Details</h2>
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-black text-left border-b">Quotation ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Material ID</th>
          <!-- <th class="px-6 py-2 text-black text-left border-b">Unit of Measure</th>
          <th class="px-6 py-2 text-black text-left border-b">Contact Person</th> -->
          <th class="px-6 py-2 text-black text-left border-b">Quantity Quoted</th>
          <!-- <th class="px-6 py-2 text-black text-left border-b">Unit Price</th> -->
          <th class="px-6 py-2 text-black text-left border-b">Total Price</th>
          <!-- <th class="px-6 py-2 text-black text-left border-b">Quotation Date</th> -->
          <!-- <th class="px-6 py-2 text-black text-left border-b">Validity Date</th> -->
          <!-- <th class="px-6 py-2 text-black text-left border-b">Remarks</th> -->
          <!-- <th class="px-6 py-2 text-black text-left border-b">Supplier ID</th> -->
          <!-- <th class="px-6 py-2 text-black text-left border-b">Status</th> -->
          <th class="px-6 py-2 text-black text-left border-b">Actions</th>
          
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in quotationDetails" :key="quotation.id" class="hover:bg-gray-50" @click="selectQuotation(quotation)">
          <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.materialId }}</td>
          <!-- <td class="px-6 py-4 text-black border-b">{{ quotation.unitOfMeasure }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.contactPerson }}</td> -->
          <td class="px-6 py-4 text-black border-b">{{ quotation.quantityQuoted }}</td>
          <!-- <td class="px-6 py-4 text-black border-b">${{ quotation.unitPrice.toFixed(2) }}</td> -->
          <td class="px-6 py-4 text-black border-b">${{ quotation.totalPrice.toFixed(2) }}</td>
          <!-- <td class="px-6 py-4 text-black border-b">{{ quotation.quotationDate }}</td> -->
          <!-- <td class="px-6 py-4 text-black border-b">{{ quotation.validityDate }}</td> -->
          <!-- <td class="px-6 py-4 text-black border-b">{{ quotation.remarks }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.supplierId }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.status }}</td> -->
          <td class="px-6 py-4 text-black border-b">
            <button @click="openQuotationDetailEditModal(quotation)" class="p-2 bg-yellow-500 text-white rounded hover:bg-yellow-600" :disabled="!selectedQuotationDetail" title="Edit Quotation">
              <i class="fas fa-edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="flex justify-end mt-2">
      <button @click="openQuotationDetailAddModal" class="p-2 mr-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Quotation Details">
        <i class="fas fa-plus"></i>
        Add Quotation Details
      </button>
      <button @click="closeQuotationDetailInfo" class="bg-gray-300 text-black px-4 py-2 rounded">Close</button>
    </div>
    </div>
    </div>

    <!-- Pagination Controls -->
    <div class="mt-4 flex justify-between">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</button>
    </div>

    <!-- Modal for Adding/Editing Quotations Details -->
    <div v-if="isQuoDetailModalOpen" class="modal-overlay" @click.self="closQuoDetailModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4 text-black">{{ isQuoDetailEditMode ? 'Edit Quotation Detail' : 'Add Quotation Detail' }}</h2>
        <form @submit.prevent="saveQuotationDetail">
          <!-- <label for="supplier" class="block mb-2 text-black">Supplier ID:</label>
          <input id="supplier" v-model="quotationDetailForm.supplierId" type="text" placeholder="Enter supplier's ID" required class="w-full p-2 border rounded"/> -->

          <label for="materialId" class="block mb-2 mt-4 text-black">Material ID:</label>
          <select
            v-model="quotationDetailForm.materialId"
            id="materialID"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          >
            <option
              v-for="material in materials"
              :key="material.materialID"
              :value="material.materialID"
            >
              {{ material.description }}
            </option>
          </select>
          <!-- <input id="materialId" v-model="quotationDetailForm.materialId" type="text" placeholder="Enter material ID" required class="w-full p-2 border rounded"/> -->

          <!-- <label for="unitOfMeasure" class="block mb-2 mt-4 text-black">Unit of Measure:</label>
          <input id="unitOfMeasure" v-model="quotationDetailForm.unitOfMeasure" type="text" placeholder="Enter unit of measure" required class="w-full p-2 border rounded"/>

          <label for="contactPerson" class="block mb-2 mt-4 text-black">Contact Person:</label>
          <input id="contactPerson" v-model="quotationDetailForm.contactPerson" type="text" placeholder="Enter contact person's name" required class="w-full p-2 border rounded"/> -->

          <label for="quantityQuoted" class="block mb-2 mt-4 text-black">Quantity Quoted:</label>
          <input id="quantityQuoted" v-model.number="quotationDetailForm.quantityQuoted" type="number" placeholder="Enter quantity quoted" required class="w-full p-2 border rounded"/>

          <!-- <label for="unitPrice" class="block mb-2 mt-4 text-black">Unit Price:</label>
          <input id="unitPrice" v-model.number="quotationDetailForm.unitPrice" type="number" step="0.01" placeholder="Enter unit price" required class="w-full p-2 border rounded"/> -->

          <label for="totalPrice" class="block mb-2 mt-4 text-black">Total Price:</label>
          <input id="totalPrice" v-model.number="quotationDetailForm.totalPrice" type="number" step="0.01" placeholder="Enter total price" required class="w-full p-2 border rounded" disabled/>

          <!-- <label for="quotationDate" class="block mb-2 mt-4 text-black">Quotation Date:</label>
          <input id="quotationDate" v-model="quotationDetailForm.quotationDate" type="date" required class="w-full p-2 border rounded"/>

          <label for="validityDate" class="block mb-2 mt-4 text-black">Validity Date:</label>
          <input id="validityDate" v-model="quotationDetailForm.validityDate" type="date" required class="w-full p-2 border rounded"/>

          <label for="remarks" class="block mb-2 mt-4 text-black">Remarks:</label>
          <textarea id="remarks" v-model="quotationDetailForm.remarks" placeholder="Enter any remarks" class="w-full p-2 border rounded"></textarea> -->

          <!-- Dropdown for Status -->
      <!-- <label for="status" class="block mb-2 mt-4 text-black">Status:</label>
      <select id="status" v-model="quotationDetailForm.status" class="w-full p-2 border rounded">
        <option value="Pending">Pending</option>
        <option value="Rejected">Rejected</option>
        <option value="Approved">Approved</option>
      </select> -->

          <div class="flex justify-end mt-4">
            <button type="button" @click="closQuoDetailModal" class="bg-gray-300 px-4 py-2 mr-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isQuoDetailEditMode ? 'Update' : 'Add' }}</button>
          </div>
        </form>
      </div>
    </div>

     <!-- Modal for Adding/Editing Quotations Details -->
     <div v-if="isQuotationModalOpen" class="modal-overlay" @click.self="closeQuotationModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4 text-black">{{ isQuotationEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>
        <form @submit.prevent="saveQuotaion">
          <label for="quotationDate" class="block mb-2 mt-4 text-black">Quotation Date:</label>
          <input id="quotationDate" v-model="quotationForm.quotationDate" type="date" required class="w-full p-2 border rounded"/>
          <label for="remarks" class="block mb-2 mt-4 text-black">Remarks:</label>
          <textarea id="remarks" v-model="quotationForm.remarks" placeholder="Enter any remarks" class="w-full p-2 border rounded"></textarea>

          <div class="flex justify-end mt-4">
            <button type="button" @click="closeQuotationModal" class="bg-gray-300 px-4 py-2 mr-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isQuotationEditMode ? 'Update' : 'Add' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { apiService } from '~/api/apiService';

const userInfo = ref({userID:""})
const users = ref([]);
const materials = ref([]);
const quotations = ref([
])
// Mock data for quotation details with new fields
const quotationDetails = ref([
  {
    id: 1,
    materialId: 'M001',
    unitOfMeasure: 'kg',
    contactPerson: 'John Doe',
    quantityQuoted: 10,
    unitPrice: 120,
    totalPrice: 1200,
    quotationDate: '2024-09-23',
    validityDate: '2024-10-23',
    remarks: 'Urgent order',
    supplierId: 'S001',
    status: 'Pending'
  },
  {
    id: 2,
    supplierId: 'S002',
    materialId: 'M002',
    unitOfMeasure: 'liters',
    contactPerson: 'Jane Smith',
    quantityQuoted: 200,
    unitPrice: 3.5,
    totalPrice: 700.0,
    quotationDate: '2024-10-02',
    validityDate: '2024-10-16',
    remarks: ''

  },
  // Add more quotations as needed...
]);

// State variables
const isQuotationDetailInfo = ref(false);
const isQuoDetailModalOpen = ref(false);
const isQuoDetailEditMode = ref(false);
const isQuotationEditMode = ref(false);
const isQuotationModalOpen = ref(false);
const selectedQuotationDetail = ref({
    id: 1,
    materialId: 'M001',
    unitOfMeasure: 'kg',
    contactPerson: 'John Doe',
    quantityQuoted: 10,
    unitPrice: 120,
    totalPrice: 1200,
    quotationDate: '2024-09-23',
    validityDate: '2024-10-23',
    remarks: 'Urgent order',
    supplierId: 'S001',
    status: 'Pending'
  });
const selectedQuotation = ref(null);
const searchQuery = ref('');
const quotationForm = ref(
  {
    id: "",
    quoteID: "",
    quotationDate: '',
    userID: userInfo.value.userID,
    remarks: ""
  },
)
const quotationDetailForm = ref({
  materialId: '',
  quantityQuoted: null,
  totalPrice: null,
});

// const getUserName = (userID) => {

//   const user = users.value?.find((usr) => usr.userID === userID)
//   return user ? `${user.lastName} ${user.firstName}` : 'Unknown'
// }
// Computed properties
const filteredQuotationDetails = computed(() => {
  return quotations.value?.filter(quotation => {
    return (
      // getUserName(quotation.userID).toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      quotation.remarks.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
});

// Pagination logic
const currentPage = ref(1);
const itemsPerPage = 5;
const totalPages = computed(() => Math.ceil(filteredQuotationDetails.value.length / itemsPerPage));

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
  selectedQuotationDetail.value = quotation
  if (selectedQuotationDetail.value) {
    isQuoDetailEditMode.value = true;
    Object.assign(quotationDetailForm.value, selectedQuotationDetail.value);
    isQuoDetailModalOpen.value = true;
  }
};

const openQuotationEditModal = (quotation) => {
  selectedQuotation.value = quotation
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
    quotationDate: '',
    userID: userInfo.value.userID,
    remarks: ""
  }
};


const openQuotationDetailInfo = () => {
  isQuotationDetailInfo.value = true;
};
const closQuoDetailModal = () => {
  isQuoDetailModalOpen.value = false;
};

const closeQuotationModal = () => {
  isQuotationModalOpen.value = false;
};

const closeQuotationDetailInfo = () =>{
  isQuotationDetailInfo.value = false;
}

const resetForm = () => {
  quotationDetailForm.value = {
    supplierId: '',
    materialId: '',
    unitOfMeasure: '',
    contactPerson: '',
    quantityQuoted: null,
    unitPrice: null,
    totalPrice: null,
    quotationDate: '',
    validityDate: '',
    remarks: ''
  };
};

const saveQuotaion = async() => {
  try {
    if (isQuotationEditMode.value){
    await apiService.put(`/api/quotations/${quotationForm.value.quoteID}`, quotationForm.value)
    const index = quotations.value.findIndex((quo) => quo.quoteID === quotationForm.value.quoteID)
    if(index !== -1){
      quotations.value[index] = {...quotationForm.value}
    }
    alert("Quotation edited successfully")
  } else {
    const result = await apiService.post("/api/quotations", quotationForm.value);
    const id = quotations.value.length + 1
    quotations.value.push({...result.data, id})
    alert("Quotation added successfully")
  }
  isQuotationModalOpen.value = false
  } catch (error) {
    console.log(error)
  }
}

const saveQuotationDetail = () => {
  if (isQuoDetailEditMode.value) {
    // Update existing quotation detaiil
    Object.assign(selectedQuotationDetail.value, quotationDetailForm.value);
  } else {
    // Add new quotation detail
    const newQuotation = { id: quotationDetails.value.length + 1, ...quotationDetailForm.value };
    newQuotation.totalPrice = newQuotation.unitPrice * newQuotation.quantityQuoted; // Calculate total price
    quotationDetails.value.push(newQuotation);
  }
  closQuoDetailModal();
};

// Selecting a quotation
const selectQuotation = (quotation) => {
  selectedQuotationDetail.value = quotation;
};

// Fetching of APIs
const fetchUsers = async() => {
  const result = await apiService.get("/api/users");
  users.value = result.data
}

const fetchQuotations = async() => {
  const result = await apiService.get("/api/quotations")
  quotations.value = result.data?.filter((value) => value.userID == userInfo.value.userID).map((value,index) => {
    return {
      ...value,
      id: index + 1
    }
  })
};

onMounted(async() => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
  }
  await fetchUsers();
  await fetchQuotations();
})
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
