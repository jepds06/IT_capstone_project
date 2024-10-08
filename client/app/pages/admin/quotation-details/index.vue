 <template> 
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Quotation Details</h2>

    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by Material ID..."
        class="w-1/3 p-2 border rounded-lg"
      />
      <div class="flex space-x-2">
        <button @click="openAddModal" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Quotation">
          <i class="fas fa-plus"></i>
        </button>
        <button @click="openEditModal" class="p-2 bg-yellow-500 text-white rounded hover:bg-yellow-600" :disabled="!selectedQuotation" title="Edit Quotation">
          <i class="fas fa-edit"></i>
        </button>
      </div>
    </div>

    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-black text-left border-b">Material ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Quantity</th>
          <th class="px-6 py-2 text-black text-left border-b">Price</th>
          <th class="px-6 py-2 text-black text-left border-b">Total Price</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in filteredQuotations" :key="quotation.materialId" class="hover:bg-gray-50" @click="selectQuotation(quotation)">
          <td class="px-6 py-4 text-black border-b">{{ quotation.materialId }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.quantity }}</td>
          <td class="px-6 py-4 text-black border-b">${{ quotation.price.toFixed(2) }}</td>
          <td class="px-6 py-4 text-black border-b">${{ quotation.totalPrice.toFixed(2) }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-between">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</button>
    </div>

    <!-- Modal for Add/Edit Quotation -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4 text-black">{{ isEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>
        <form @submit.prevent="saveQuotation">
          <label for="materialId" class="block mb-2 text-black">Material ID:</label>
          <input id="materialId" v-model="quotationForm.materialId" type="text" placeholder="Enter material ID" required class="w-full p-2 border rounded"/>

          <label for="quantity" class="block mb-2 mt-4 text-black">Quantity:</label>
          <input id="quantity" v-model.number="quotationForm.quantity" type="number" required class="w-full p-2 border rounded"/>

          <label for="price" class="block mb-2 mt-4 text-black">Price:</label>
          <input id="price" v-model.number="quotationForm.price" type="number" step="0.01" required class="w-full p-2 border rounded"/>

          <label for="totalPrice" class="block mb-2 mt-4 text-black">Total Price:</label>
          <input id="totalPrice" v-model.number="quotationForm.totalPrice" type="number" step="0.01" required class="w-full p-2 border rounded" readonly/>

          <div class="flex justify-end mt-4">
            <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isEditMode ? 'Update' : 'Add' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
// The script for managing the quotations remains unchanged
import { ref, computed, watch } from 'vue';

// Mock data for quotations
const quotations = ref([
  { materialId: 'M001', quantity: 10, price: 100, totalPrice: 1000 },
  { materialId: 'M002', quantity: 5, price: 50, totalPrice: 250 },
]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 10;
const selectedQuotation = ref(null);
const isModalOpen = ref(false);
const isEditMode = ref(false);
const quotationForm = ref({ materialId: '', quantity: '', price: '', totalPrice: 0 });

// Calculate total price based on quantity and price
watch([quotationForm.quantity, quotationForm.price], () => {
  quotationForm.totalPrice = (quotationForm.quantity || 0) * (quotationForm.price || 0);
});

// Filter quotations based on search query
const filteredQuotations = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = currentPage.value * itemsPerPage;

  return quotations.value
    .filter(quotation => {
      return (
        quotation.materialId.toLowerCase().includes(searchQuery.value.toLowerCase())
      );
    })
    .slice(startIndex, endIndex);
});

const totalPages = computed(() => Math.ceil(quotations.value.length / itemsPerPage));

const selectQuotation = (quotation) => {
  selectedQuotation.value = quotation;
};

const openAddModal = () => {
  quotationForm.value = { materialId: '', quantity: '', price: '', totalPrice: 0 };
  isEditMode.value = false;
  isModalOpen.value = true;
};

const openEditModal = () => {
  if (selectedQuotation.value) {
    quotationForm.value = { ...selectedQuotation.value };
    isEditMode.value = true;
    isModalOpen.value = true;
  }
};

const saveQuotation = () => {
  if (isEditMode.value) {
    const index = quotations.value.findIndex(q => q.materialId === selectedQuotation.value.materialId);
    if (index !== -1) {
      quotations.value[index] = { ...quotationForm.value };
    }
  } else {
    quotations.value.push({ ...quotationForm.value });
  }
  closeModal();
};

const closeModal = () => {
  isModalOpen.value = false;
  selectedQuotation.value = null; // Clear selection after closing
};

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
  border-radius: 5px;
  width: 400px;
}

/* Label styles for better visibility */
label, .modal-content h2 {
  color: black; /* Ensure label and title text is black for visibility */
}

.text-center {
  text-align: center;
}
</style>