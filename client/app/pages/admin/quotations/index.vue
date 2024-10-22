update button doesnt work in the modal for view also could you add a button for generate PO in the modal when viewing the details pls?
<template>
  <div>
    <!-- Button to Open Modal -->
    <button @click="openAddQuotationModal" class="bg-green-500 text-white px-4 py-2 rounded">
      Add Quotation
    </button>

    <!-- Modal for Adding Quotations -->
    <div v-if="showAddQuotationModal" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg h-auto">
        <h2 class="text-lg font-semibold mb-4">{{ isQuotationEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>
        <form @submit.prevent="isQuotationEditMode ? updateQuotation() : addQuotation()" class="space-y-4">
          <!-- Choose Supplier Dropdown -->
          <div>
            <label for="supplier" class="block text-black">Choose Supplier:</label>
            <select
              id="supplier"
              v-model="newQuotation.supplierName"
              required
              class="w-full p-2 border rounded"
            >
              <option value="">Select Supplier</option>
              <option v-for="supplier in uniqueSuppliers" :key="supplier.id" :value="supplier.name">
                {{ supplier.name }}
              </option>
            </select>
          </div>

          <!-- Quotation No (auto-generated) -->
          <div>
            <label class="block text-black">Quotation No:</label>
            <input type="text" :value="generateQuotationNo()" disabled class="w-full p-2 border rounded bg-gray-200" />
          </div>

          <!-- Materials Input -->
          <div>
            <label class="block text-black">Materials:</label>
            <div v-for="(material, index) in newQuotation.materials" :key="index" class="flex space-x-2 mb-2">
              <input
                v-model="material.name"
                type="text"
                placeholder="Material Name"
                required
                class="w-1/3 p-2 border rounded"
              />
              <input
                v-model.number="material.quantity"
                type="number"
                placeholder="Quantity"
                required
                class="w-1/3 p-2 border rounded"
              />
              <input
                v-model.number="material.price"
                type="number"
                placeholder="Price"
                required
                class="w-1/3 p-2 border rounded"
                @input="updateMaterialTotal()"
              />
              <button type="button" @click="removeMaterial(index)" class="bg-red-500 text-white px-2 py-1 rounded">Remove</button>
            </div>
            <button type="button" @click="addMaterial" class="bg-blue-500 text-white px-4 py-2 rounded">Add Material</button>
          </div>

          <!-- Total Amount -->
          <div>
            <label class="block text-black">Total Amount:</label>
            <input
              type="text"
              v-model="formattedTotalAmount"
              disabled
              class="w-full p-2 border rounded bg-gray-200"
            />
          </div>

          <!-- Purchase Order and Delivery Date -->
          <div>
            <label for="purchaseOrder" class="block text-black">Purchase Order:</label>
            <input id="purchaseOrder" v-model="newQuotation.purchaseOrder" type="text" required class="w-full p-2 border rounded" />
          </div>

          <div>
            <label for="deliveryDate" class="block text-black">Delivery Date:</label>
            <input
              id="deliveryDate"
              type="date"
              v-model="newQuotation.deliveryDate"
              required
              class="w-full p-2 border rounded"
            />
          </div>

          <div>
            <label for="status" class="block text-black">Status:</label>
            <select id="status" v-model="newQuotation.status" class="w-full p-2 border rounded">
              <option value="pending">Pending</option>
              <option value="accepted">Accepted</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>

          <div>
            <label for="remark" class="block text-black">Remark:</label>
            <textarea
              id="remark"
              v-model="newQuotation.remark"
              placeholder="Enter any remarks"
              class="w-full p-2 border rounded"
              rows="3"
            ></textarea>
          </div>

          <!-- Buttons for Actions -->
          <div class="flex justify-between space-x-4 mt-4">
            <button type="button" @click="closeAddQuotationModal" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
            <button type="button" @click="generateQuotation()" class="bg-yellow-500 text-white px-4 py-2 rounded">
              Generate Quotation
            </button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
              {{ isQuotationEditMode ? 'Update Quotation' : 'Add Quotation' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Quotation Table -->
    <table class="min-w-full mt-6 border border-gray-300">
      <thead>
        <tr class="bg-gray-200">
          <th class="border px-4 py-2">Quotation No.</th>
          <th class="border px-4 py-2">Total Amount</th>
          <th class="border px-4 py-2">Materials</th>
          <th class="border px-4 py-2">Purchase Order</th>
          <th class="border px-4 py-2">Delivery Date</th>
          <th class="border px-4 py-2">Status</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in quotations" :key="quotation.quotationNo">
          <td class="border px-4 py-2">{{ quotation.quotationNo }}</td>
          <td class="border px-4 py-2">{{ formatCurrency(calculateTotalAmount(quotation.materials)) }}</td>
          <td class="border px-4 py-2">
            <ul>
              <li v-for="material in quotation.materials" :key="material.name">
                {{ material.name }} ({{ material.quantity }} @ {{ formatCurrency(material.price) }} each)
              </li>
            </ul>
          </td>
          <td class="border px-4 py-2">{{ quotation.purchaseOrder }}</td>
          <td class="border px-4 py-2">{{ quotation.deliveryDate }}</td>
          <td class="border px-4 py-2">{{ quotation.status }}</td>
          <td class="border px-4 py-2">
            <button @click="viewQuotation(quotation)" class="bg-green-500 text-white px-2 py-1 rounded">View</button>
            <button @click="deleteQuotation(quotation.quotationNo)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
            <button v-if="quotation.status === 'accepted'" @click="generatePO(quotation)" class="bg-blue-500 text-white px-2 py-1 rounded">Generate PO</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for Viewing Quotation Details -->
    <div v-if="showViewQuotationModal" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg h-auto">
        <h2 class="text-lg font-semibold mb-4">Quotation Details</h2>
        <div>
          <strong>Quotation No:</strong> {{ selectedQuotation.quotationNo }}
        </div>
        <div>
          <strong>Supplier:</strong> {{ selectedQuotation.supplierName }}
        </div>
        <div>
          <strong>Total Amount:</strong> {{ formatCurrency(calculateTotalAmount(selectedQuotation.materials)) }}
        </div>
        <div>
          <strong>Materials:</strong>
          <ul>
            <li v-for="material in selectedQuotation.materials" :key="material.name">
              {{ material.name }} ({{ material.quantity }} @ {{ formatCurrency(material.price) }} each)
            </li>
          </ul>
        </div>
        <div>
          <strong>Purchase Order:</strong> {{ selectedQuotation.purchaseOrder }}
        </div>
        <div>
          <strong>Delivery Date:</strong> {{ selectedQuotation.deliveryDate }}
        </div>
        <div>
          <strong>Status:</strong> {{ selectedQuotation.status }}
        </div>
        <div>
          <strong>Remark:</strong> {{ selectedQuotation.remark }}
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between space-x-4 mt-4">
          <button type="button" @click="updateQuotation(selectedQuotation)" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
          <button type="button" @click="closeViewQuotationModal" class="bg-gray-400 text-white px-4 py-2 rounded">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quotations: [],
      uniqueSuppliers: [
        { id: 1, name: 'Supplier A' },
        { id: 2, name: 'Supplier B' },
        { id: 3, name: 'Supplier C' },
      ],
      newQuotation: {
        supplierName: '',
        materials: [{ name: '', quantity: 0, price: 0 }],
        purchaseOrder: '',
        deliveryDate: '',
        status: 'pending',
        remark: '',
      },
      formattedTotalAmount: 0,
      showAddQuotationModal: false,
      showViewQuotationModal: false,
      selectedQuotation: null,
      isQuotationEditMode: false,
    };
  },
  methods: {
    openAddQuotationModal() {
      this.showAddQuotationModal = true;
      this.resetNewQuotation();
    },
    closeAddQuotationModal() {
      this.showAddQuotationModal = false;
    },
    resetNewQuotation() {
      this.newQuotation = {
        supplierName: '',
        materials: [{ name: '', quantity: 0, price: 0 }],
        purchaseOrder: '',
        deliveryDate: '',
        status: 'pending',
        remark: '',
      };
      this.formattedTotalAmount = 0;
      this.isQuotationEditMode = false;
    },
    addQuotation() {
      const quotationNo = this.generateQuotationNo();
      const totalAmount = this.calculateTotalAmount(this.newQuotation.materials);
      const newQuotation = { ...this.newQuotation, quotationNo, totalAmount };

      this.quotations.push(newQuotation);
      this.closeAddQuotationModal();
    },
    generateQuotationNo() {
      return 'QT-' + new Date().getTime(); // Simple timestamp-based number
    },
    calculateTotalAmount(materials) {
      return materials.reduce((total, material) => total + (material.price * material.quantity), 0);
    },
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
    },
    viewQuotation(quotation) {
      this.selectedQuotation = quotation;
      this.showViewQuotationModal = true;
    },
    closeViewQuotationModal() {
      this.showViewQuotationModal = false;
      this.selectedQuotation = null;
    },
    deleteQuotation(quotationNo) {
      this.quotations = this.quotations.filter(quotation => quotation.quotationNo !== quotationNo);
    },
    updateQuotation() {
      // Implement the update logic here
    },
    addMaterial() {
      this.newQuotation.materials.push({ name: '', quantity: 0, price: 0 });
    },
    removeMaterial(index) {
      this.newQuotation.materials.splice(index, 1);
      this.updateMaterialTotal();
    },
    updateMaterialTotal() {
      this.formattedTotalAmount = this.calculateTotalAmount(this.newQuotation.materials);
    },
    generatePO(quotation) {
      // Implement PO generation logic here
    },
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
