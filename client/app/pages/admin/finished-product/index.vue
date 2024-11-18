<template>
    <div class="p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-extrabold">Finished Products</h1>
      </div>
  
      <!-- Finished Products Table -->
      <div class="overflow-x-auto">
        <table class="table-auto w-full bg-white rounded shadow">
          <thead>
            <tr class="bg-gray-100 text-left text-gray-600">
              <th class="p-4">ID</th>
              <th class="p-4">Prod Detail ID</th>
              <th class="p-4">Name</th>
              <th class="p-4">Production Date</th>
              <th class="p-4">Quantity</th>
              <th class="p-4">Status</th>
              <th class="p-4">Remarks</th>
              <!-- <th class="p-4">Created At</th>
              <th class="p-4">Modified At</th>
              <th class="p-4">Deleted At</th> -->
              <!-- <th class="p-4">Actions</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in finishedProducts" :key="product.FnshProductID" class="border-b">
              <td class="p-4">{{ product.fnshProductID  }}</td>
              <td class="p-4">{{ product.prodtnDetailID  }}</td>
              <td class="p-4">{{ product?.production_detail?.product?.productName  }}</td>
              <td class="p-4">{{ product.productionDate }}</td>
              <td class="p-4">{{ product.quantity }}</td>
              <td class="p-4">
                <span v-if="product.status === 'In Production'" class="text-blue-500" title="In Production">🔄</span>
                <span v-if="product.status === 'Completed'" class="text-green-500" title="Completed">✔️</span>
                <span v-if="product.status === 'Pending'" class="text-yellow-500" title="Pending">🕒</span>
                <span v-if="product.status === 'Cancelled'" class="text-red-500" title="Cancelled">❌</span>
              </td>
              <td class="p-4">{{ product.remarks }}</td>
              <!-- <td class="p-4">{{ product.CreatedAt }}</td>
              <td class="p-4">{{ product.ModifiedAt }}</td>
              <td class="p-4">{{ product.DeletedAt }}</td> -->
              <!-- <td class="p-4 flex space-x-4"> -->
                <!-- Action Icons -->
                <!-- <button @click="openDetailsModal(product)" class="text-blue-500 hover:underline" title="View Details">
                  <i class="fas fa-eye"></i>
                </button>
                <button @click="openEditModal(product)" class="text-yellow-500 hover:underline" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button @click="markAsCompleted(product)" class="text-green-500 hover:underline" title="Mark as Completed">
                  <i class="fas fa-check-circle"></i>
                </button> -->
              <!-- </td> -->
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Finished Product Details Modal -->
      <div v-if="showDetailsModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
          <h2 class="text-xl font-bold mb-4">Finished Product Details</h2>
          <p><strong>FnshProductID:</strong> {{ selectedProduct.FnshProductID }}</p>
          <p><strong>ProdDetailID:</strong> {{ selectedProduct.ProdDetailID }}</p>
          <p><strong>Production Date:</strong> {{ selectedProduct.ProductionDate }}</p>
          <p><strong>Quantity:</strong> {{ selectedProduct.Quantity }}</p>
          <p><strong>Unit Price:</strong> {{ selectedProduct.UnitPrice }}</p>
          <p><strong>Status:</strong> {{ selectedProduct.Status }}</p>
          <p><strong>Remarks:</strong> {{ selectedProduct.Remarks }}</p>
          <p><strong>Created At:</strong> {{ selectedProduct.CreatedAt }}</p>
          <p><strong>Modified At:</strong> {{ selectedProduct.ModifiedAt }}</p>
          <p><strong>Deleted At:</strong> {{ selectedProduct.DeletedAt }}</p>
          <div class="mt-6 flex justify-end space-x-4">
            <button @click="closeDetailsModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
          </div>
        </div>
      </div>
  
      <!-- Edit Modal -->
      <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
          <h2 class="text-xl font-bold mb-4">Edit Finished Product</h2>
          <form @submit.prevent="updateProduct">
            <div class="mb-4">
              <label class="block text-gray-700" for="quantity">Quantity</label>
              <input
                type="number"
                id="quantity"
                v-model="selectedProduct.Quantity"
                class="border rounded p-2 w-full"
                required
              />
            </div>
            <div class="mb-4">
              <label class="block text-gray-700" for="unitPrice">Unit Price</label>
              <input
                type="text"
                id="unitPrice"
                v-model="selectedProduct.UnitPrice"
                class="border rounded p-2 w-full"
                required
              />
            </div>
            <div class="mb-4">
              <label class="block text-gray-700" for="remarks">Remarks</label>
              <textarea
                id="remarks"
                v-model="selectedProduct.Remarks"
                class="border rounded p-2 w-full"
                rows="4"
              ></textarea>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
              <button @click="closeEditModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Mark as Completed Modal -->
      <div v-if="showCompleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
          <h2 class="text-xl font-bold mb-4">Mark as Completed</h2>
          <p>Are you sure you want to mark this product as completed?</p>
          <div class="mt-6 flex justify-end space-x-4">
            <button @click="completeProduct" class="bg-green-500 text-white px-4 py-2 rounded">Mark Completed</button>
            <button @click="closeCompleteModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script>
import { apiService } from '~/api/apiService';
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

  export default {
    data() {
      return {
        finishedProducts: [
          // {
          //   FnshProductID: 1,
          //   ProdDetailID: 'A123',
          //   ProductionDate: '2024-09-30',
          //   Quantity: 100,
          //   UnitPrice: '$15.00',
          //   Status: 'In Production', // Example status
          //   Remarks: 'Ready for delivery',
          //   CreatedAt: '2024-09-01',
          //   ModifiedAt: '2024-09-30',
          //   DeletedAt: null,
          // },
          // ... more products
        ],
        selectedProduct: {},
        showDetailsModal: false,
        showEditModal: false,
        showCompleteModal: false,
      };
    },
    methods: {
      openDetailsModal(product) {
        this.selectedProduct = product;
        this.showDetailsModal = true;
      },
      closeDetailsModal() {
        this.showDetailsModal = false;
      },
      openEditModal(product) {
        this.selectedProduct = { ...product }; // Clone the product to edit
        this.showEditModal = true;
      },
      closeEditModal() {
        this.showEditModal = false;
      },
      markAsCompleted(product) {
        this.selectedProduct = product;
        this.showCompleteModal = true;
      },
      closeCompleteModal() {
        this.showCompleteModal = false;
      },
      completeProduct() {
        const index = this.finishedProducts.findIndex(p => p.FnshProductID === this.selectedProduct.FnshProductID);
        
        if (index !== -1) {
          this.finishedProducts[index].Status = 'Completed'; // Update status
          console.log(`Product ${this.finishedProducts[index].FnshProductID} marked as completed.`);
        } else {
          console.error("Product not found for completion.");
        }
  
        this.showCompleteModal = false; // Close the modal
      },
      async fetchFinishProductsData(){
        const result = await apiService.get("/api/finishedProducts");

        this.finishedProducts = result?.data
      }
    },
    async mounted() {
      await this.fetchFinishProductsData()
    }
  };
  </script>
  
  <style scoped>
  .table-auto {
    width: 100%;
    border-collapse: collapse;
  }
  .table-auto th,
  .table-auto td {
    border: 1px solid #e2e8f0;
    padding: 8px;
  }
  .table-auto th {
    background-color: #edf2f7;
  }
  </style>