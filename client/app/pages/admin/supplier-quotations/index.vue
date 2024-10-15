<template>
  <div class="p-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Supplier Quotations</h1>
    </div>

    <!-- Filters -->
    <div class="flex justify-between items-center mb-4">
      <input
        type="text"
        placeholder="Search quotations..."
        class="w-1/3 p-3 border rounded"
        v-model="searchQuery"
      />
      <!-- <select v-model="statusFilter" class="p-3 border rounded w-1/4">
          <option value="">All Status</option>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
        </select> -->
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
            <!-- <th class="p-4">Status</th> -->
            <th class="p-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="quotation in filteredQuotations"
            :key="quotation.id"
            class="border-b"
          >
            <td class="p-4">{{ quotation.quoteID }}</td>
            <td class="p-4">{{ getSupplierName(quotation.userID) }}</td>
            <td class="p-4">{{ `SUP-${quotation.userID}` }}</td>
            <!-- <td class="p-4">
                <span v-if="quotation.status === 'Pending'" class="text-yellow-500"> Pending</span>
                <span v-if="quotation.status === 'Approved'" class="text-green-500"> Approved</span>
                <span v-if="quotation.status === 'Rejected'" class="text-red-500"> Rejected</span>
              </td> -->
            <td class="p-4 flex space-x-4">
              <button
                @click="openDetailsModal(quotation)"
                class="text-blue-500 hover:underline"
              >
                View Details
              </button>
              <button
                @click="openPurchaseOrderModal(quotation)"
                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
              >
                Purchase
              </button>
              <!-- <button
                  @click="openRejectConfirmationModal(quotation)"
                  class="text-red-500 hover:underline"
                  title="Reject Quotation"
                >
                  <i class="fas fa-trash"></i>
                </button> -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-6">
      <span class="text-gray-600">Showing 1-10 of {{ quotations.length }}</span>
      <div class="flex space-x-2">
        <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded">
          Previous
        </button>
        <button class="bg-blue-500 text-white px-3 py-1 rounded">Next</button>
      </div>
    </div>

    <!-- Quotation Details Modal -->
    <div
      v-if="showDetailsModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
        <h2 class="text-xl font-bold mb-4">Quotation Details</h2>
        <table class="table-auto w-full">
          <thead>
            <tr class="bg-gray-100 text-left text-gray-600">
              <th class="p-2">Material ID</th>
              <th class="p-2">Material Name</th>
              <th class="p-2">Quantity</th>
              <th class="p-2">Price</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in quotationDetails" :key="item.id">
              <td class="p-2">{{ item.id }}</td>
              <td class="p-2">
                {{ getMaterialProductName(item.prodtnMtrlID) }}
              </td>
              <td class="p-2">{{ item.quantity }}</td>
              <td class="p-2">{{ item.quotePrice }}</td>
            </tr>
          </tbody>
        </table>
        <div class="mt-6 flex justify-end space-x-4">
          <button
            @click="closeDetailsModal"
            class="bg-red-500 text-white px-4 py-2 rounded"
          >
            Close
          </button>
          <button
            @click="downloadQuotation()"
            class="bg-blue-500 text-white px-4 py-2 rounded"
          >
            Download PDF
          </button>
        </div>
      </div>
    </div>

    <!-- Purchase Order Modal -->
    <div
      v-if="showPurchaseOrderModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <h2 class="text-xl font-bold mb-4">Purchase Order</h2>
        <p>
          Please confirm the purchase order for
          {{
            selectedQuotation ? getSupplierName(selectedQuotation.userID) : ""
          }}.
        </p>
        <div class="mt-6 flex justify-end space-x-4">
          <button
            @click="closePurchaseOrderModal"
            class="bg-red-500 text-white px-4 py-2 rounded"
          >
            Cancel
          </button>
          <button
            @click="confirmPurchaseOrder"
            class="bg-green-500 text-white px-4 py-2 rounded"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>

    <!-- Reject Quotation Confirmation Modal -->
    <div
      v-if="showRejectConfirmationModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <h2 class="text-xl font-bold mb-4">Confirm Rejection</h2>
        <p>
          Are you sure you want to reject quotation
          {{ selectedQuotation ? selectedQuotation.quotationNo : "" }}?
        </p>
        <div class="mt-6 flex justify-end space-x-4">
          <button
            @click="closeRejectConfirmationModal"
            class="bg-red-500 text-white px-4 py-2 rounded"
          >
            Cancel
          </button>
          <button
            @click="rejectQuotation"
            class="bg-green-500 text-white px-4 py-2 rounded"
          >
            Reject
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { apiService } from "~/api/apiService";
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { jsPDF } from "jspdf";
import "jspdf-autotable";

export default {
  data() {
    return {
      users: [],
      materials: [],
      quotations: [
        // {
        //   id: '1',
        //   quotationNo: 'Q-001',
        //   supplierName: 'Supplier 1',
        //   supplierId: 'SUP-123',
        //   status: 'Pending', // Initial status is Pending
        //   date: '2024-09-01',
        //   items: [
        //     { materialId: 'MAT-001', quantity: 10, price: '$100', totalPrice: '$1000' },
        //     { materialId: 'MAT-002', quantity: 5, price: '$200', totalPrice: '$1000' },
        //   ],
        // },
        // {
        //   id: '2',
        //   quotationNo: 'Q-002',
        //   supplierName: 'Supplier 2',
        //   supplierId: 'SUP-456',
        //   status: 'Pending', // Initial status is also Pending
        //   date: '2024-09-05',
        //   items: [
        //     { materialId: 'MAT-003', quantity: 15, price: '$150', totalPrice: '$2250' },
        //   ],
        // },
      ],
      totalQuotations: 2,
      showDetailsModal: false,
      selectedQuotation: null,
      showPurchaseOrderModal: false,
      showRejectConfirmationModal: false,
      searchQuery: "",
      statusFilter: "",
      dateFilter: "",
      quotationDetails: [],
    };
  },
  computed: {
    filteredQuotations() {
      return this.quotations.filter((quotation) => {
        const matchesSearch = this.getSupplierName(quotation.userID)
          .toLowerCase()
          .includes(this.searchQuery.toLowerCase());

        // const matchesStatus = this.statusFilter ? quotation.status === this.statusFilter : true;

        const matchesDate = this.dateFilter
          ? quotation.quotationDate === this.dateFilter
          : true;

        return matchesSearch && matchesDate;
      });
    },
  },
  methods: {
    async openDetailsModal(quotation) {
      await this.fetchMaterialsByProductionID(quotation.productionID);
      this.selectedQuotation = quotation;
      this.showDetailsModal = true;
      const result = await apiService.get(
        `/api/quotationDetails/quotation/${quotation.productionID}`
      );
      this.quotationDetails = result?.quotation_details.map((value, index) => {
        return {
          ...value,
          id: index + 1,
        };
      });
    },
    closeDetailsModal() {
      this.showDetailsModal = false;
    },
    openPurchaseOrderModal(quotation) {
      this.selectedQuotation = quotation;
      this.showPurchaseOrderModal = true;
    },
    closePurchaseOrderModal() {
      this.showPurchaseOrderModal = false;
    },
    confirmPurchaseOrder() {
      // Update the status to Approved when confirmed
      this.selectedQuotation.status = "Approved";
      this.closePurchaseOrderModal();
    },
    openRejectConfirmationModal(quotation) {
      this.selectedQuotation = quotation;
      this.showRejectConfirmationModal = true;
    },
    closeRejectConfirmationModal() {
      this.showRejectConfirmationModal = false;
    },
    rejectQuotation() {
      // Update the status to Rejected when rejected
      this.selectedQuotation.status = "Rejected";
      this.closeRejectConfirmationModal();
    },
    async downloadQuotation() {
    const doc = new jsPDF();
    // const logoUrl = await import('~/assets/images/supplyease.png');

    // Header Background
    doc.setFillColor(37, 150, 190); // Header background color
    doc.rect(0, 0, doc.internal.pageSize.getWidth(), 45, 'F'); // Fill rectangle for header

    // Logo (if available)
    // if (logoUrl) {
    //     doc.addImage(logoUrl, 'PNG', 150, 10, 40, 20); // Adjust position and size as needed
    // }

    // Header Title
    doc.setFontSize(22);
    doc.setTextColor(255, 255, 255); // White text
    doc.text('Quotation', 10, 20);

    // Supplier Information
    doc.setFontSize(12);
    doc.setTextColor(255, 255, 255); // White text
    doc.text(`Quotation No: ${this.selectedQuotation.quoteID}`, 10, 30);
    doc.text(`Supplier Name: ${this.getSupplierName(this.selectedQuotation.userID)}`, 10, 35);
    doc.text(`Supplier ID: SUP-${this.selectedQuotation.userID}`, 10, 40);

    // Draw a line under the header
    doc.setDrawColor(255, 255, 255); // Line color
    doc.setLineWidth(1.5);
    doc.line(10, 65, 200, 65); // Horizontal line

    // Table Header
    const columns = [
        { header: 'Material ID', dataKey: 'id' },
        { header: 'Material', dataKey: 'material' },
        { header: 'Quantity', dataKey: 'quantity' },
        { header: 'Price', dataKey: 'quotePrice' }
    ];

    const rows = this.quotationDetails.map(item => ({
        id: item.id,
        material: this.getMaterialProductName(item.prodtnMtrlID),
        quantity: item.quantity,
        quotePrice: item.quotePrice
    }));

    doc.autoTable({
        head: [columns.map(col => col.header)],
        body: rows.map(row => [row.id, row.material, row.quantity, row.quotePrice]),
        startY: 65, // Adjusting for the header height
        margin: { horizontal: 10 },
        theme: 'grid',
        styles: { cellPadding: 5, fontSize: 10 },
        headStyles: {
            fillColor: [37, 150, 190], // Same as header background
            textColor: [255, 255, 255],
            fontStyle: 'bold'
        },
        // alternateRowStyles: { fillColor: [240, 240, 240] }, // Light gray for alternate rows
    });

    // Save the PDF
    doc.save(`quotation_${this.getSupplierName(this.selectedQuotation.userID)}.pdf`);
},
    getMaterialProductName(prodtnMtrlID) {
      const material = this.materials?.find(
        (val) => val.prodtnMtrlID == prodtnMtrlID
      );
      return `${material?.productName} -> ${material?.description}`;
    },
    getSupplierName(userID) {
      const supplier = this.users?.find((value) => value.userID === userID);
      return supplier
        ? `${supplier.lastName} ${supplier.firstName}`
        : "Unknown";
    },
    async fetchMaterialsByProductionID(productionID) {
      const result = await apiService.get(
        `/api/materials/production/${productionID}`
      );
      this.materials = result;
    },
    async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.users = result.data;
    },
    async fetchQuotationData() {
      const result = await apiService.get("/api/quotations");
      this.quotations = result.data;
    },
  },
  async mounted() {
    await this.fetchUserData();
    await this.fetchQuotationData();
  },
};
</script>

<style scoped>
.table-auto {
  border-collapse: collapse;
}
.table-auto th,
.table-auto td {
  border: 1px solid #ddd;
}
</style>
