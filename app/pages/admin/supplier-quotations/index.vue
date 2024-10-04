<template>
  <div class="p-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Supplier Quotations</h1>
    </div>

    <!-- Filters -->
    <div class="flex justify-between items-center mb-4">
      <!-- Search Bar -->
      <input
        type="text"
        placeholder="Search quotations..."
        class="w-1/3 p-3 border rounded"
        v-model="searchQuery"
      />

      <!-- Status Filter -->
      <select v-model="statusFilter" class="p-3 border rounded w-1/4">
        <option value="">All Status</option>
        <option value="Submitted">Submitted</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
      </select>

      <!-- Date Filter -->
      <input
        type="date"
        v-model="dateFilter"
        class="p-3 border rounded w-1/4"
      />
    </div>

    <!-- Supplier Quotations Table -->
    <div class="overflow-x-auto">
      <table class="table-auto w-full bg-white rounded shadow">
        <thead>
          <tr class="bg-gray-100 text-left text-gray-600">
            <th class="p-4">Quotation No</th>
            <th class="p-4">Supplier Name</th>
            <th class="p-4">Supplier ID</th>
            <th class="p-4">Status</th>
            <th class="p-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="quotation in filteredQuotations"
            :key="quotation.id"
            class="border-b"
          >
            <td class="p-4">{{ quotation.quotationNo }}</td>
            <td class="p-4">{{ quotation.supplierName }}</td>
            <td class="p-4">{{ quotation.supplierId }}</td>
            <td class="p-4">
              <span v-if="quotation.status === 'Submitted'" class="text-yellow-500">📄 Submitted</span>
              <span v-if="quotation.status === 'Approved'" class="text-green-500">✔️ Approved</span>
              <span v-if="quotation.status === 'Rejected'" class="text-red-500">❌ Rejected</span>
            </td>
            <td class="p-4 flex space-x-4">
              <button @click="openDetailsModal(quotation)" class="text-blue-500 hover:underline">View Details</button>
              <button @click="approveQuotation(quotation)" class="text-green-500 hover:underline">✔️</button>
              <button @click="rejectQuotation(quotation)" class="text-red-500 hover:underline">❌</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination (if necessary) -->
    <div class="flex justify-between items-center mt-6">
      <span class="text-gray-600">Showing 1-10 of {{ totalQuotations }}</span>
      <div class="flex space-x-2">
        <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded">Previous</button>
        <button class="bg-blue-500 text-white px-3 py-1 rounded">Next</button>
      </div>
    </div>

    <!-- Quotation Details Modal -->
    <div v-if="showDetailsModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
        <h2 class="text-xl font-bold mb-4">Quotation Details</h2>
        <table class="table-auto w-full">
          <thead>
            <tr class="bg-gray-100 text-left text-gray-600">
              <th class="p-2">Material ID</th>
              <th class="p-2">Quantity</th>
              <th class="p-2">Price</th>
              <th class="p-2">Total Price</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in selectedQuotation.items" :key="item.id">
              <td class="p-2">{{ item.materialId }}</td>
              <td class="p-2">{{ item.quantity }}</td>
              <td class="p-2">{{ item.price }}</td>
              <td class="p-2">{{ item.totalPrice }}</td>
            </tr>
          </tbody>
        </table>
        <div class="mt-6 flex justify-end space-x-4">
          <button @click="closeDetailsModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
          <button @click="downloadQuotation(selectedQuotation)" class="bg-blue-500 text-white px-4 py-2 rounded">Download PDF</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { jsPDF } from 'jspdf'; // Add this import statement at the top

export default {
  data() {
    return {
      quotations: [
        {
          id: '1',
          quotationNo: 'Q-001',
          supplierName: 'Supplier 1',
          supplierId: 'SUP-123',
          status: 'Submitted',
          date: '2024-09-01',
          items: [
            { materialId: 'MAT-001', quantity: 10, price: '$100', totalPrice: '$1000' },
            { materialId: 'MAT-002', quantity: 5, price: '$200', totalPrice: '$1000' },
          ],
        },
        {
          id: '2',
          quotationNo: 'Q-002',
          supplierName: 'Supplier 2',
          supplierId: 'SUP-456',
          status: 'Approved',
          date: '2024-09-05',
          items: [
            { materialId: 'MAT-003', quantity: 15, price: '$150', totalPrice: '$2250' },
          ],
        },
      ],
      totalQuotations: 2, // Adjust this dynamically
      showDetailsModal: false,
      selectedQuotation: null,
      searchQuery: '',
      statusFilter: '',
      dateFilter: '',
    };
  },
  computed: {
    filteredQuotations() {
      return this.quotations.filter((quotation) => {
        const matchesSearch = quotation.quotationNo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          quotation.supplierName.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          quotation.supplierId.toLowerCase().includes(this.searchQuery.toLowerCase());
        
        const matchesStatus = this.statusFilter ? quotation.status === this.statusFilter : true;
        
        const matchesDate = this.dateFilter ? quotation.date === this.dateFilter : true;
        
        return matchesSearch && matchesStatus && matchesDate;
      });
    },
  },
  methods: {
    openDetailsModal(quotation) {
      this.selectedQuotation = quotation;
      this.showDetailsModal = true;
    },
    closeDetailsModal() {
      this.showDetailsModal = false;
      this.selectedQuotation = null;
    },
    approveQuotation(quotation) {
      // Update the status to 'Approved'
      quotation.status = 'Approved';
    },
    rejectQuotation(quotation) {
      // Update the status to 'Rejected'
      quotation.status = 'Rejected';
    },
    downloadQuotation(quotation) {
      const doc = new jsPDF();
      doc.setFontSize(20);
      doc.text('Quotation Details', 14, 22);
      doc.setFontSize(12);
      doc.text(`Quotation No: ${quotation.quotationNo}`, 14, 35);
      doc.text(`Supplier Name: ${quotation.supplierName}`, 14, 42);
      doc.text(`Supplier ID: ${quotation.supplierId}`, 14, 49);
      doc.text(`Status: ${quotation.status}`, 14, 56);
      doc.text('Items:', 14, 63);

      const headers = ['Material ID', 'Quantity', 'Price', 'Total Price'];
      const data = quotation.items.map(item => [item.materialId, item.quantity, item.price, item.totalPrice]);
      
      let startY = 70;
      const columnWidths = [40, 30, 30, 30];
      headers.forEach((header, i) => {
        doc.text(header, 14 + columnWidths.slice(0, i).reduce((a, b) => a + b, 0), startY);
      });

      startY += 7;

      data.forEach(row => {
        row.forEach((cell, i) => {
          doc.text(cell.toString(), 14 + columnWidths.slice(0, i).reduce((a, b) => a + b, 0), startY);
        });
        startY += 7;
      });

      doc.save(`quotation-${quotation.quotationNo}.pdf`);
    },
  },
};
</script>

<style>

</style>
