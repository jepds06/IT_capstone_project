<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Quotation Management</h1>
    <button @click="openAddQuotationModal" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
      <i class="fas fa-plus"></i>
    </button>

    <!-- Quotation Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b">Quotation No</th>
            <th class="py-2 px-4 border-b">Supplier</th>
            <th class="py-2 px-4 border-b">Total Amount</th>
            <th class="py-2 px-4 border-b">Status</th>
            <th class="py-2 px-4 border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="quotation in quotations" :key="quotation.quotationNo">
            <td class="py-2 px-4 border-b text-center">{{ quotation.quotationNo }}</td>
            <td class="py-2 px-4 border-b text-center">{{ quotation.supplierName }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatCurrency(calculateTotalAmount(quotation.materials)) }}</td>
            <td class="py-2 px-4 border-b text-center" :class="{'text-yellow-500': quotation.status === 'pending', 'text-green-500': quotation.status === 'accepted'}">
              {{ quotation.status }}
            </td>
            <td class="py-2 px-4 border-b text-center">
              <button @click="viewQuotation(quotation)" class="bg-green-500 text-white px-2 py-1 rounded mr-2">
                <i class="fas fa-eye"></i>
              </button>
              <button v-if="quotation.status === 'accepted'" @click="notifySupplier(quotation)" class="bg-yellow-500 text-white px-2 py-1 rounded mr-2">
                <i class="fas fa-envelope"></i>
              </button>
              <button v-if="quotation.status === 'pending'" @click="approveQuotation(quotation)" class="bg-blue-500 text-white px-2 py-1 rounded">
                <i class="fas fa-check"></i>
              </button>
              <button v-if="quotation.status === 'accepted'" @click="generatePO(quotation)" class="bg-blue-500 text-white px-2 py-1 rounded">
                <i class="fas fa-file-pdf"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Add Quotation Modal -->
    <div v-if="showAddQuotationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow-md w-1/2">
        <h2 class="text-xl font-bold mb-4">{{ isQuotationEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>

        <!-- Removed Quotation Number Input -->
        <div class="mb-4">
          <span class="block text-sm font-medium text-gray-700">Quotation No: {{ newQuotation.quotationNo }}</span>
        </div>

        <div class="mb-4">
          <label for="supplier" class="block text-sm font-medium text-gray-700">Select Supplier</label>
          <select v-model="newQuotation.supplierName" id="supplier" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            <option disabled value="">Please select a supplier</option>
            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.name">{{ supplier.name }}</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Materials</label>
          <div v-for="(material, index) in newQuotation.materials" :key="index" class="flex items-center mb-2">
            <input v-model="material.name" placeholder="Material Name" class="flex-1 mr-2 p-2 border rounded" />
            <input v-model.number="material.quantity" type="number" placeholder="Quantity" class="mr-2 p-2 border rounded w-20" />
            <input v-model.number="material.price" type="number" placeholder="Price" class="mr-2 p-2 border rounded w-20" />
            <button @click="removeMaterial(index)" class="bg-red-500 text-white px-2 py-1 rounded">X</button>
          </div>
          <button @click="addMaterial" class="bg-green-500 text-white px-4 py-2 rounded">Add Material</button>
        </div>

        <div class="mb-4">
          <label for="deliveryDate" class="block text-sm font-medium text-gray-700">Delivery Date</label>
          <input v-model="newQuotation.deliveryDate" type="date" id="deliveryDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" />
        </div>

        <div class="mb-4">
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select v-model="newQuotation.status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            <option value="pending">Pending</option>
            <option value="accepted">Accepted</option>
          </select>
        </div>

        <div v-if="warningMessage" class="text-red-500 mb-4">{{ warningMessage }}</div>

        <div class="flex justify-end">
          <button @click="closeAddQuotationModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
          <button @click="isQuotationEditMode ? updateQuotation() : addQuotation()" class="bg-blue-500 text-white px-4 py-2 rounded">
            {{ isQuotationEditMode ? 'Update' : 'Add' }}
          </button>
        </div>
      </div>
    </div>

    <!-- View Quotation Modal -->
    <div v-if="showViewQuotationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow-md w-1/2">
        <h2 class="text-xl font-bold mb-4">View Quotation</h2>
        <p><strong>Quotation No:</strong> {{ selectedQuotation.quotationNo }}</p>
        <p><strong>Supplier:</strong> {{ selectedQuotation.supplierName }}</p>
        <p><strong>Total Amount:</strong> {{ formatCurrency(calculateTotalAmount(selectedQuotation.materials)) }}</p>
        <p><strong>Status:</strong> {{ selectedQuotation.status }}</p>
        <p><strong>Delivery Date:</strong> {{ selectedQuotation.deliveryDate }}</p>
        <h3 class="font-bold mt-4">Materials</h3>
        <ul class="list-disc pl-5">
          <li v-for="material in selectedQuotation.materials" :key="material.name">
            {{ material.name }} - {{ material.quantity }} x {{ formatCurrency(material.price) }}
          </li>
        </ul>
        <div class="flex justify-end mt-4">
          <button @click="closeViewQuotationModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Close</button>
          <button @click="editSelectedQuotation" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";

export default {
  data() {
    return {
      showAddQuotationModal: false,
      showViewQuotationModal: false,
      newQuotation: {
        quotationNo: "", // Will be auto-generated
        supplierName: "",
        materials: [{ name: "", quantity: 0, price: 0 }],
        purchaseOrder: "",
        deliveryDate: "",
        status: "pending",
        remark: "",
      },
      suppliers: [
        { id: 1, name: "Smith Jane" },
        { id: 2, name: "John Doe" },
        { id: 3, name: "ACME Corp" },
      ],
      quotations: [],
      selectedQuotation: null,
      isQuotationEditMode: false,
      warningMessage: "",
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
    addMaterial() {
      this.newQuotation.materials.push({ name: "", quantity: 0, price: 0 });
    },
    removeMaterial(index) {
      this.newQuotation.materials.splice(index, 1);
    },
    calculateTotalAmount(materials) {
      return materials.reduce((total, material) => total + material.price * material.quantity, 0);
    },
    formatCurrency(amount) {
      return `$${amount.toFixed(2)}`;
    },
    addQuotation() {
      if (!this.newQuotation.supplierName || !this.newQuotation.deliveryDate) {
        this.warningMessage = "Please fill all required fields.";
        return;
      }

      this.warningMessage = ""; // Clear warning message
      this.newQuotation.quotationNo = `Q-${this.quotations.length + 1}`; // Generate Quotation No
      this.quotations.push({ ...this.newQuotation });
      this.closeAddQuotationModal();
    },
    viewQuotation(quotation) {
      this.selectedQuotation = quotation;
      this.showViewQuotationModal = true;
    },
    closeViewQuotationModal() {
      this.showViewQuotationModal = false;
    },
    editSelectedQuotation() {
      this.isQuotationEditMode = true;
      this.newQuotation = { ...this.selectedQuotation }; // Copy selected quotation
      this.closeViewQuotationModal();
      this.openAddQuotationModal();
    },
    updateQuotation() {
      const index = this.quotations.findIndex(q => q.quotationNo === this.newQuotation.quotationNo);
      if (index !== -1) {
        this.quotations.splice(index, 1, { ...this.newQuotation });
        this.closeAddQuotationModal();
      }
    },
    approveQuotation(quotation) {
      const index = this.quotations.findIndex(q => q.quotationNo === quotation.quotationNo);
      if (index !== -1) {
        this.quotations[index].status = "accepted"; // Change status to accepted
      }
    },
    notifySupplier(quotation) {
      alert(`Notifying supplier for quotation ${quotation.quotationNo}.`);
      // Implement actual notification logic here
    },
    generatePO(quotation) { 
      const doc = new jsPDF();
      
      // Set up PDF metadata and styles
      doc.setFontSize(12);
      
      // Add a header to the document
      doc.setFontSize(18);
      doc.text('PURCHASE ORDER', 105, 15, { align: 'center' }); // Title centered
      
      // Add PO and Supplier information
      doc.setFontSize(12);
      doc.text(`Purchase Order No: ${quotation.quotationNo}`, 10, 30);
      doc.text(`Supplier: ${quotation.supplierName}`, 10, 40);
      doc.text(`Delivery Date: ${quotation.deliveryDate}`, 10, 50);
      
      // Add a horizontal line below the header
      doc.line(10, 55, 200, 55); // Draw a line
      
      // Create a table for the materials
      doc.autoTable({
        startY: 60,
        head: [['Material', 'Quantity', 'Price', 'Total']],
        body: quotation.materials.map(material => [
          material.name,
          material.quantity,
          this.formatCurrency(material.price),
          this.formatCurrency(material.quantity * material.price)
        ]),
        theme: 'grid', // Adds grid lines to the table for clarity
        styles: { cellPadding: 2, fontSize: 10 },
        headStyles: { fillColor: [22, 160, 133] } // Table header color (teal-like)
      });

      // Calculate and add the total amount below the table
      const totalAmount = this.calculateTotalAmount(quotation.materials);
      
      // Use autoTable.previous.finalY to get the correct Y position after the table
      const finalY = doc.autoTable.previous.finalY + 10;
      
      doc.setFontSize(12);
      doc.text(`Total Amount: ${this.formatCurrency(totalAmount)}`, 10, finalY);
  
      // Add a footer
      doc.setFontSize(10);
      doc.text('Thank you for your business!', 105, 285, { align: 'center' });
      doc.text('Authorized Signature: ___________________', 10, 295);
      
      // Save the PDF with the PO number in the filename
      doc.save(`PO-${quotation.quotationNo}.pdf`);
    },
    resetNewQuotation() {
      this.newQuotation = {
        quotationNo: "",
        supplierName: "",
        materials: [{ name: "", quantity: 0, price: 0 }],
        deliveryDate: "",
        status: "pending",
      };
      this.isQuotationEditMode = false;
    },
  },
};
</script>


<style scoped>
/* Add your styles here */
</style>
