<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Manage Suppliers</h1>
      <div class="mb-4 flex justify-between items-center">
        <input
          type="text"
          placeholder="Search suppliers..."
          class="border p-2 rounded"
          v-model="searchQuery"
        />
        <button
          @click="showAddSupplierModal = true"
          class="bg-blue-500 text-white px-4 py-2 rounded flex items-center"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-2"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 4v16m8-8H4"
            />
          </svg>
          Add Supplier
        </button>
      </div>
  
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 text-center">Supplier Name</th>
            <th class="py-2 px-4 text-center">Contact Person</th>
            <th class="py-2 px-4 text-center">Email</th>
            <th class="py-2 px-4 text-center">Phone Number</th>
            <th class="py-2 px-4 text-center">Status</th>
            <th class="py-2 px-4 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="supplier in filteredSuppliers" :key="supplier.id">
            <td class="border-t px-4 py-2 text-center">{{ supplier.name }}</td>
            <td class="border-t px-4 py-2 text-center">{{ supplier.contactPerson }}</td>
            <td class="border-t px-4 py-2 text-center">{{ supplier.email }}</td>
            <td class="border-t px-4 py-2 text-center">{{ supplier.phone }}</td>
            <td class="border-t px-4 py-2 text-center">
                <span v-if="supplier.status === 'Active'" class="text-green-500">✔️</span>
                <span v-if="supplier.status === 'Inactive'" class="text-red-500">❌</span>
            </td>
            <td class="border-t px-4 py-2 text-center flex justify-center space-x-2">
              <button @click="viewSupplierDetails(supplier)" class="text-green-500">
                👁️
              </button>
              <button @click="editSupplier(supplier)" class="text-blue-500">
                ✏️
              </button>
              <button @click="confirmDelete(supplier.id)" class="text-red-600">
                🗑️
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Add Supplier Modal -->
      <div v-if="showAddSupplierModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4">Add Supplier</h2>
          <form @submit.prevent="addSupplier">
            <input type="text" v-model="newSupplier.name" placeholder="Supplier Name" class="border p-2 rounded mb-4 w-full" required />
            <input type="text" v-model="newSupplier.contactPerson" placeholder="Contact Person" class="border p-2 rounded mb-4 w-full" required />
            <input type="email" v-model="newSupplier.email" placeholder="Email" class="border p-2 rounded mb-4 w-full" required />
            <input type="text" v-model="newSupplier.phone" placeholder="Phone Number" class="border p-2 rounded mb-4 w-full" required />
            <div class="flex justify-end">
              <button type="button" @click="showAddSupplierModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Supplier</button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- View Supplier Details Modal -->
      <div v-if="showViewSupplierModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4">Supplier Details</h2>
          <p><strong>Name:</strong> {{ selectedSupplier.name }}</p>
          <p><strong>Contact Person:</strong> {{ selectedSupplier.contactPerson }}</p>
          <p><strong>Email:</strong> {{ selectedSupplier.email }}</p>
          <p><strong>Phone Number:</strong> {{ selectedSupplier.phone }}</p>
          <p><strong>Status:</strong> {{ selectedSupplier.status }}</p>
          <div class="flex justify-end">
            <button type="button" @click="showViewSupplierModal = false" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
          </div>
        </div>
      </div>
  
      <!-- Edit Supplier Modal -->
      <div v-if="showEditSupplierModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4">Edit Supplier</h2>
          <form @submit.prevent="updateSupplier">
            <input type="text" v-model="selectedSupplier.name" placeholder="Supplier Name" class="border p-2 rounded mb-4 w-full" required />
            <input type="text" v-model="selectedSupplier.contactPerson" placeholder="Contact Person" class="border p-2 rounded mb-4 w-full" required />
            <input type="email" v-model="selectedSupplier.email" placeholder="Email" class="border p-2 rounded mb-4 w-full" required />
            <input type="text" v-model="selectedSupplier.phone" placeholder="Phone Number" class="border p-2 rounded mb-4 w-full" required />
            <div class="flex justify-end">
              <button type="button" @click="showEditSupplierModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Supplier</button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Delete Confirmation Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
          <p>Are you sure you want to delete this supplier?</p>
          <div class="flex justify-end mt-4">
            <button type="button" @click="showDeleteModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="button" @click="confirmDeletion" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        suppliers: [
          { id: 1, name: 'Supplier A', contactPerson: 'John Doe', email: 'john@example.com', phone: '1234567890', status: 'Active' },
          { id: 2, name: 'Supplier B', contactPerson: 'Jane Smith', email: 'jane@example.com', phone: '0987654321', status: 'Inactive' },
        ],
        searchQuery: '',
        showAddSupplierModal: false,
        showViewSupplierModal: false,
        showEditSupplierModal: false,
        showDeleteModal: false,
        newSupplier: {
          name: '',
          contactPerson: '',
          email: '',
          phone: '',
        },
        selectedSupplier: null,
        supplierToDelete: null,
      };
    },
    computed: {
      filteredSuppliers() {
        return this.suppliers.filter((supplier) =>
          supplier.name.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      },
    },
    methods: {
      addSupplier() {
        const newId = this.suppliers.length ? Math.max(this.suppliers.map(s => s.id)) + 1 : 1;
        this.suppliers.push({ ...this.newSupplier, id: newId, status: 'Active' });
        this.newSupplier = { name: '', contactPerson: '', email: '', phone: '' };
        this.showAddSupplierModal = false;
      },
      viewSupplierDetails(supplier) {
        this.selectedSupplier = supplier;
        this.showViewSupplierModal = true;
      },
      editSupplier(supplier) {
        this.selectedSupplier = { ...supplier };
        this.showEditSupplierModal = true;
      },
      updateSupplier() {
        const index = this.suppliers.findIndex(s => s.id === this.selectedSupplier.id);
        if (index !== -1) {
          this.suppliers[index] = this.selectedSupplier;
        }
        this.showEditSupplierModal = false;
      },
      confirmDelete(supplierId) {
        this.supplierToDelete = supplierId;
        this.showDeleteModal = true;
      },
      confirmDeletion() {
        this.suppliers = this.suppliers.filter(supplier => supplier.id !== this.supplierToDelete);
        this.showDeleteModal = false;
        this.supplierToDelete = null;
      },
    },
  };
  </script>
  
  <style scoped>
  .table th,
  .table td {
    text-align: center;
  }
  </style>
  