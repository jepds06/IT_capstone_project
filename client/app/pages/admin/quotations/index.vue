<template>
  <div class="p-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Supplier Quotations</h1>
      <button
        @click="openAddQuotationModal"
        class="bg-blue-500 text-white px-4 py-2 rounded-lg"
      >
        + Add Quotation
      </button>
    </div>

    <!-- Supplier Selection (Combo Box) -->
    <div class="mb-6">
      <h2 class="text-xl font-semibold mb-2">Select Supplier</h2>
      <Listbox v-model="selectedSupplier">
        <div class="relative mt-1">
          <ListboxButton class="relative w-full py-2 pl-3 pr-10 text-left bg-white rounded-lg shadow-md cursor-default focus:outline-none focus:ring-2 focus:ring-opacity-75 focus:ring-blue-500">
            <span class="block truncate">{{ selectedSupplier || 'Choose a supplier' }}</span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
              <svg
                class="w-5 h-5 text-gray-400"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
          </ListboxButton>

          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <ListboxOptions class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
              <ListboxOption
                v-for="supplier in uniqueSuppliers"
                :key="supplier"
                :value="supplier"
                class="cursor-pointer select-none relative py-2 pl-10 pr-4"
              >
                <span
                  :class="{
                    'font-medium': selectedSupplier === supplier,
                    'font-normal': selectedSupplier !== supplier
                  }"
                  class="block truncate"
                >
                  {{ supplier }}
                </span>
              </ListboxOption>
            </ListboxOptions>
          </transition>
        </div>
      </Listbox>
    </div>

    <!-- Quotation Table -->
    <div v-if="selectedSupplier" class="bg-white p-6 rounded-lg shadow-lg">
      <h3 class="text-2xl font-bold mb-4">Quotations for {{ selectedSupplier }}</h3>
      <table class="table-auto w-full text-left">
        <thead class="bg-gray-200 text-gray-600">
          <tr>
            <th class="px-4 py-2">Quotation No.</th>
            <th class="px-4 py-2">Total Amount</th>
            <th class="px-4 py-2">Purchase Order</th>
            <th class="px-4 py-2">Delivery Date</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="quotation in filteredQuotations"
            :key="quotation.id"
            class="border-b"
          >
            <td class="px-4 py-2">{{ quotation.quotationNo }}</td>
            <td class="px-4 py-2">{{ quotation.totalAmount | currency }}</td>
            <td class="px-4 py-2">{{ quotation.purchaseOrder }}</td>
            <td class="px-4 py-2">{{ quotation.deliveryDate }}</td>
            <td class="px-4 py-2">
              <span
                :class="{
                  'bg-yellow-300 text-yellow-800': quotation.status === 'pending',
                  'bg-green-300 text-green-800': quotation.status === 'accepted',
                  'bg-red-300 text-red-800': quotation.status === 'rejected'
                }"
                class="px-2 py-1 rounded"
              >
                {{ quotation.status }}
              </span>
            </td>
            <td class="px-4 py-2">
              <button
                @click="viewQuotationDetails(quotation)"
                class="text-blue-500 hover:underline"
              >
                View
              </button>
              <button
                @click="deleteQuotation(quotation.id)"
                class="text-red-500 hover:underline ml-2"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- View Quotation Modal -->
    <div
      v-if="showQuotationModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
        <h2 class="text-xl font-bold mb-4">Quotation Details</h2>
        <p><strong>Supplier Name:</strong> {{ currentQuotation.supplierName }}</p>
        <p><strong>Quotation No.:</strong> {{ currentQuotation.quotationNo }}</p>
        <p><strong>Total Amount:</strong> {{ currentQuotation.totalAmount | currency }}</p>
        <p><strong>Purchase Order:</strong> {{ currentQuotation.purchaseOrder }}</p>
        <p><strong>Delivery Date:</strong> {{ currentQuotation.deliveryDate }}</p>
        <p><strong>Status:</strong> {{ currentQuotation.status }}</p>
        <div class="mt-6 flex justify-end space-x-4">
          <button
            @click="closeQuotationModal"
            class="bg-gray-400 text-white px-4 py-2 rounded"
          >
            Close
          </button>
        </div>
      </div>
    </div>

<<<<<<< HEAD
    <!-- Add Quotation Modal -->
    <div
      v-if="showAddQuotationModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
        <h2 class="text-xl font-bold mb-4">Add New Quotation</h2>
        <form @submit.prevent="addQuotation">
          <div class="grid grid-cols-2 gap-4">
            <input
              v-model="newQuotation.supplierName"
              type="text"
              placeholder="Supplier Name"
              class="p-3 border rounded"
              required
            />
            <input
              v-model="newQuotation.quotationNo"
              type="text"
              placeholder="Quotation No."
              class="p-3 border rounded"
              required
            />
            <input
              v-model="newQuotation.totalAmount"
              type="number"
              placeholder="Total Amount"
              class="p-3 border rounded"
              required
            />
            <input
              v-model="newQuotation.purchaseOrder"
              type="text"
              placeholder="Purchase Order"
              class="p-3 border rounded"
              required
            />
            <input
              v-model="newQuotation.deliveryDate"
              type="date"
              class="p-3 border rounded"
              required
            />
            <select
              v-model="newQuotation.status"
              class="p-3 border rounded"
              required
            >
              <option value="pending">Pending</option>
              <option value="accepted">Accepted</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
=======
     <!-- Modal for Adding/Editing Quotations Details -->
     <div v-if="isQuotationModalOpen" class="modal-overlay" @click.self="closeQuotationModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4 text-black">{{ isQuotationEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>
        <form @submit.prevent="saveQuotaion">
           <!-- Production ID Field -->
          <label for="productionId" class="block mb-2 mt-4 text-black">Production ID:</label>
          <input id="productionId" v-model="quotationForm.productionId" type="text" required class="w-full p-2 border rounded" />
          <label for="quotationDate" class="block mb-2 mt-4 text-black">Quotation Date:</label>
          <input id="quotationDate" v-model="quotationForm.quotationDate" type="date" required class="w-full p-2 border rounded"/>
          <label for="remarks" class="block mb-2 mt-4 text-black">Remarks:</label>
          <textarea id="remarks" v-model="quotationForm.remarks" placeholder="Enter any remarks" class="w-full p-2 border rounded"></textarea>
>>>>>>> 5b6dbfb805c04a29aa28a095b71022ed64a0bcf8

          <div class="mt-6 flex justify-end space-x-4">
            <button
              @click="closeAddQuotationModal"
              class="bg-gray-400 text-white px-4 py-2 rounded"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded"
            >
              Add Quotation
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue';

export default {
  components: { Listbox, ListboxButton, ListboxOptions, ListboxOption },
  data() {
    return {
      quotations: [], // Data source for quotations
      selectedSupplier: null,
      showQuotationModal: false,
      showAddQuotationModal: false,
      currentQuotation: {},
      newQuotation: {
        supplierName: '',
        quotationNo: '',
        totalAmount: '',
        purchaseOrder: '',
        deliveryDate: '',
        status: 'pending',
      },
    };
  },
  computed: {
    uniqueSuppliers() {
      const supplierSet = new Set(this.quotations.map((q) => q.supplierName));
      return [...supplierSet];
    },
    filteredQuotations() {
      return this.quotations.filter(
        (quotation) => quotation.supplierName === this.selectedSupplier
      );
    },
  },
  methods: {
    viewQuotationDetails(quotation) {
      this.currentQuotation = quotation;
      this.showQuotationModal = true;
    },
    closeQuotationModal() {
      this.showQuotationModal = false;
    },
    openAddQuotationModal() {
      this.showAddQuotationModal = true;
    },
    closeAddQuotationModal() {
      this.showAddQuotationModal = false;
    },
    addQuotation() {
      this.quotations.push({ ...this.newQuotation });
      this.newQuotation = {
        supplierName: '',
        quotationNo: '',
        totalAmount: '',
        purchaseOrder: '',
        deliveryDate: '',
        status: 'pending',
      };
      this.closeAddQuotationModal();
    },
    deleteQuotation(id) {
      this.quotations = this.quotations.filter((q) => q.id !== id);
    },
  },
  created() {
    // Populate quotations with sample data
    this.quotations = [
      {
        id: 1,
        supplierName: 'ABC Supplies',
        quotationNo: 'Q001',
        totalAmount: 1200,
        purchaseOrder: 'PO001',
        deliveryDate: '2024-10-15',
        status: 'pending',
      },
      {
        id: 2,
        supplierName: 'XYZ Industries',
        quotationNo: 'Q002',
        totalAmount: 3500,
        purchaseOrder: 'PO002',
        deliveryDate: '2024-11-10',
        status: 'accepted',
      },
      {
        id: 3,
        supplierName: 'ABC Supplies',
        quotationNo: 'Q003',
        totalAmount: 800,
        purchaseOrder: 'PO003',
        deliveryDate: '2024-12-01',
        status: 'rejected',
      },
    ];
  },
};
</script>

<style>
/* Add your necessary styles */
</style>
