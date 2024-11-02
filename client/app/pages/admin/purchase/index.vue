<template>
  <div class="container mx-auto py-10">
    <!-- Quotation Table -->
    <h2 class="text-2xl font-bold mb-6">Purcahse Orders</h2>

    <!-- Search Bar -->
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search..."
      class="p-2 border border-gray-300 rounded w-48 mb-4"
    />
    <table class="table-auto w-full bg-white shadow-lg rounded-lg">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-4 text-center">PO ID</th>
          <th class="p-4 text-center">Supplier</th>
          <th class="p-4 text-center">Quotation ID</th>
          <th class="p-4 text-center">Total Amount</th>
          <th class="p-4 text-center">Status</th>
          <th class="p-4 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="po in purchaseOrders" :key="po.id" class="border-t">
          <td class="p-4 text-center">{{ po.id }}</td>
          <td class="p-4 text-center">{{ po.supplier }}</td>
          <td class="p-4 text-center">{{ po.quotationId }}</td>
          <td class="p-4 text-center">{{ po.total | currency }}</td>
          <td class="p-4 text-center">
            <span :class="statusClass(po.status)" class="py-1 px-3 rounded-full text-white text-sm">
              {{ po.status }}
            </span>
          </td>
          <td class="p-4 text-center">
            <button @click="viewDetails(po)" class="text-blue-600 mr-2">
              <i class="fas fa-eye"></i> <!-- View Icon -->
            </button>
            <button @click="updateStatus(po, 'Waiting for Delivery')" class="text-yellow-600 mr-2">
              <i class="fas fa-truck"></i> <!-- Mark as Delivered Icon -->
            </button>
            <button @click="cancelPO(po)" class="text-red-600">
              <i class="fas fa-trash"></i> <!-- Cancel Icon -->
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="statusMessage" class="mt-4 p-2 bg-green-100 text-green-700 rounded-md">
      {{ statusMessage }}
    </div>
    
      <!-- Modal for Supplier Material Selection -->
      <div v-if="selectedPO" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-md w-1/2">
              <h3 class="text-lg font-bold mb-2">Select Materials for Purchase Order</h3>

        <!-- Scrollable Table Container -->
        <div class="max-h-64 overflow-y-auto border border-gray-300 rounded-md mb-4">
          <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
              <tr>
                <th class="py-2 px-4 text-left">Material ID</th>
                <th class="py-2 px-4 text-left">Material Name</th>
                <th class="py-2 px-4 text-left">Quantity</th>
                <th class="py-2 px-4 text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="material in selectedPO.materials" :key="material.id" class="border-t">
                <td class="py-2 px-4">{{ material.id }}</td>
                <td class="py-2 px-4">{{ material.name }}</td>
                <td class="py-2 px-4">{{ material.quantity }}</td>
                <td class="py-2 px-4">
                  <button @click="removeMaterial(material)" class="text-red-600">
                    <i class="fas fa-times"></i> Drop
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <button @click="confirmMaterialsSelection" class="bg-blue-500 text-white px-4 py-2 rounded-md">Confirm</button>
        <button @click="closeModal" class="text-gray-600 ml-2">Close</button>
        <div v-if="modalMessage" class="mt-2 p-2 bg-green-100 text-green-700 rounded-md">
          {{ modalMessage }}
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-gray-300 px-4 py-2 rounded">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-gray-300 px-4 py-2 rounded">Next</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      purchaseOrders: [
        {
          id: 'PO001',
          supplier: 'Supplier A',
          quotationId: 'Q001',
          total: 5000,
          status: 'Pending',
          materials: [
            { id: 'M001', name: 'Material 1', quantity: 100 },
            { id: 'M002', name: 'Material 2', quantity: 50 },
          ],
        },
        {
          id: 'PO002',
          supplier: 'Supplier B',
          quotationId: 'Q002',
          total: 7000,
          status: 'Waiting for Delivery',
          materials: [
            { id: 'M003', name: 'Material 3', quantity: 75 },
            { id: 'M004', name: 'Material 4', quantity: 20 },
          ],
        },
        // Additional purchase orders...
      ],
      selectedPO: null,
      statusMessage: '',
      modalMessage: '',
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
    };
  },

  computed: {
    filteredPurchaseOrders() {
      return this.purchaseOrders.filter(
        (po) =>
          po.id.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          po.quotationId.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    totalPages() {
      return Math.ceil(this.filteredPurchaseOrders.length / this.itemsPerPage);
    },
    paginatedPurchaseOrders() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredPurchaseOrders.slice(start, end);
    },
  },

  methods: {
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    setTemporaryMessage(messageType, message) {
      if (messageType === 'status') {
        this.statusMessage = message;
      } else if (messageType === 'modal') {
        this.modalMessage = message;
      }
      setTimeout(() => {
        if (messageType === 'status') {
          this.statusMessage = '';
        } else if (messageType === 'modal') {
          this.modalMessage = '';
        }
      }, 3000);
    },
    statusClass(status) {
      switch (status) {
        case 'Pending':
          return 'bg-yellow-500';
        case 'Waiting for Delivery':
          return 'bg-blue-500';
        case 'Delivered':
          return 'bg-green-500';
        case 'Cancelled':
          return 'bg-red-500';
        default:
          return 'bg-gray-500';
      }
    },
    viewDetails(po) {
      this.selectedPO = po;
      this.modalMessage = '';
    },
    closeModal() {
      this.selectedPO = null;
      this.modalMessage = '';
    },
    removeMaterial(material) {
      this.selectedPO.materials = this.selectedPO.materials.filter((m) => m.id !== material.id);
      this.setTemporaryMessage('modal', `Material ${material.name} has been removed.`);
    },
    confirmMaterialsSelection() {
      this.setTemporaryMessage('status', 'Materials selection confirmed.');
      this.closeModal();
    },
    updateStatus(po, newStatus) {
      po.status = newStatus;
      this.setTemporaryMessage('status', `PO ID ${po.id} marked as ${newStatus}.`);
    },
    cancelPO(po) {
      po.status = 'Cancelled';
      this.setTemporaryMessage('status', `PO ID ${po.id} has been cancelled.`);
    },
  },
};
</script>



<style scoped>
.container {
  font-family: 'Arial', sans-serif;
  background-color: #f9fafb;
  padding: 50px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  color: #333;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 12px 15px;
  text-align: left;
}

th {
  background-color: #0e8bf1;
  color: white;
  text-transform: uppercase;
}

tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

tbody tr:hover {
  background-color: #d1e7f7;
  cursor: pointer;
}

button {
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

button i {
  font-size: 1.2rem;
}

button:hover i {
  color: #0e76a8;
}

.fixed {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.bg-gray-600 {
  background-color: rgba(0, 0, 0, 0.75);
}

.bg-white {
  background-color: white;
}

.p-6 {
  padding: 24px;
}

.rounded-md {
  border-radius: 8px;
}

.bg-blue-500 {
  background-color: #0e8bf1;
}

.bg-blue-500:hover {
  background-color: #1069b5;
}

.text-blue-600 {
  color: #0e8bf1;
}

.text-blue-600:hover {
  color: #0c6399;
}

.text-red-600 {
  color: #e3342f;
}

.text-red-600:hover {
  color: #c7281d;
}

button:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

@media (max-width: 768px) {
  table {
    display: block;
    width: 100%;
    overflow-x: auto;
  }
}
</style>
