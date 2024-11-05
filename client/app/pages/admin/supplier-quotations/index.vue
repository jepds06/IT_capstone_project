<template>
  <div class="mx-auto py-10">
    <!-- Quotation Table -->
    <h2 class="text-2xl font-bold mb-6">Supplier Quotation</h2>

    <!-- Search Bar -->
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search..."
      class="p-2 border border-gray-300 rounded w-48 mb-4"
    />

    <!-- Quotation Table with Remarks Column -->
    <table class="min-w-full border border-gray-300 rounded-lg mb-4">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 text-left">Quotation No.</th>
          <th class="py-2 px-4 text-left">Date</th>
          <th class="py-2 px-4 text-left">Sent By</th>
          <th class="py-2 px-4 text-left">Status</th>
          <th class="py-2 px-4 text-left">Remarks</th>
          <th class="py-2 px-4 text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(quotation, index) in paginatedQuotations" :key="index">
          <td class="py-2 px-4">
            {{ `QN-${quotation.id}` }}
          </td>
          <td class="py-2 px-4">
            {{ quotation.dateEncoded }}
          </td>
          <td class="py-2 px-4">
            {{ getUserName(quotation.userID) }}
          </td>
          <td class="py-2 px-4">
            {{
              `Requested quotation to ${quotation.quotations.length} supplier(s)`
            }}
          </td>
          <td class="py-2 px-4">
            {{ quotation.remarks }}
          </td>
          <td class="py-2 px-4">
            <button
              class="text-blue-600"
              @click="openQuotationModal(quotation)"
            >
              <i class="fas fa-eye" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Quotation View Modal -->
    <div
      v-if="selectedQuotation"
      class="fixed inset-0 bg-gray-700 bg-opacity-75 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-md w-1/2">
        <h3 class="text-xl font-bold mb-4">
          Quotation Details (Quotation No: {{ `QN-${selectedQuotation.id}` }})
        </h3>
        <table class="min-w-full bg-white border border-gray-300 mb-4">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-2 px-4 text-left">Supplier</th>
              <th class="py-2 px-4 text-left">Remarks</th>
              <th class="py-2 px-4 text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(supplier, index) in selectedQuotation.quotations"
              :key="index"
            >
              <td class="py-2 px-4 relative">
                <span
                  class="text-blue-600 underline cursor-pointer"
                  @click="openSupplierDetailsModal(supplier)"
                >
                  {{ getSupplierName(supplier.userID) }}
                </span>
              </td>
              <td class="py-2 px-4">
                {{ supplier?.quotationRemarks }}
              </td>
              <td class="py-2 px-4">
                <!-- <button
                  :class="
                    supplier.quotation_details.length > 0
                      ? 'bg-blue-500 text-white py-1 px-3 rounded-md mr-2'
                      : 'bg-gray-300 py-1 px-3 mr-2 rounded-md cursor-not-allowed'
                  "
                  :disabled="!supplier.quotation_details.length > 0"
                  @click="confirmPurchaseOrder(supplier)"
                >
                  Generate PO
                </button> -->
                <button
                  :class="
                    supplier.quotation_details.length > 0
                      ? 'bg-red-800 text-white py-1 px-3 rounded-md'
                      : 'bg-gray-300 py-1 px-3 rounded-md cursor-not-allowed'
                  "
                  :disabled="!supplier.quotation_details.length > 0"
                  @click="downloadQuotation(supplier)"
                >
                  <UIcon name="vscode-icons:file-type-pdf2" class="w-5" />
                  Download
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <button class="text-red-600" @click="closeQuotationModal">Close</button>
      </div>
    </div>

    <!-- Supplier Quotation Details Modal -->
    <div
      v-if="showSupplierDetailsModal"
      class="fixed inset-0 bg-gray-700 bg-opacity-75 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-md w-1/2">
        <h3 class="text-xl font-bold mb-4">Product Material Details</h3>
        <label for="materialId" class="block mb-2 mt-4 text-black"
          >Supplier:<span>{{
            `${getSupplierName(selectedSupplier?.userID)}`
          }}</span></label
        >
        <label for="materialId" class="block mb-2 mt-4 text-black"
          >Quotation No: <span>{{ `QN-${selectedQuotation.id}` }}</span></label
        >
        <table class="min-w-full bg-white border border-gray-300 mb-4">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-2 px-4 text-left"></th>
              <th class="py-2 px-4 text-left">Product Material</th>
              <th class="py-2 px-4 text-left">Qty.</th>
              <th class="py-2 px-4 text-left">Unit Price</th>
              <th class="py-2 px-4 text-left">Total Price</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(material, index) in selectedSupplier?.quotation_details"
              :key="index"
            >
              <td>
                <input
                  type="checkbox"
                  class="form-checkbox"
                  @change="(e) => { checkedPurchaseMaterial(e.target.checked, material)}"
                />
              </td>
              <td class="py-2 px-4">
                {{ this.getMaterialProductName(material?.prodtnMtrlID) }}
              </td>
              <td class="py-2 px-4">{{ material?.quantity }}</td>
              <td class="py-2 px-4">
                {{
                  material.quotePrice
                    ? new Intl.NumberFormat("en-PH", {
                        style: "currency",
                        currency: "PHP",
                      }).format(material.quotePrice)
                    : 0
                }}
              </td>
              <td class="py-2 px-4">
                {{
                  material.quotePrice
                    ? new Intl.NumberFormat("en-PH", {
                        style: "currency",
                        currency: "PHP",
                      }).format(material.quantity * material.quotePrice)
                    : 0
                }}
              </td>
              <!-- <button
                  class="bg-blue-500 text-white rounded-md mr-2"
                  @click="confirmPurchaseOrder(material)"
                >
                <UIcon name="material-symbols:shopping-cart-checkout" title="Purchase"/>
                  
                </button> -->
            </tr>
          </tbody>
        </table>

        <!-- Total Price Calculation -->
        <div class="flex justify-end mt-2">
          <strong>Total:</strong>
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(getTotalPrice(selectedSupplier.quotation_details))
          }}
        </div>

        <div class="flex justify-between mt-2">
          <button @click="closeSupplierDetailsModal" class="text-red-600">
            Close
          </button>

          <UButton
            :disabled="purchasedMaterials.length === 0"
            @click="confirmPurchaseOrder(material)"
          >
            <UIcon
              name="material-symbols:shopping-cart-checkout"
              title="Purchase"
            />
            Purchase
          </UButton>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div
      v-if="showConfirmationModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-md w-1/3">
        <h3 class="text-xl font-bold mb-4">
          Are you sure you want to purchase this?
        </h3>
        <div class="flex justify-end">
          <button
            class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2"
            @click="generatePurchaseOrder()"
          >
            Yes
          </button>
          <button class="text-red-600" @click="showConfirmationModal = false">
            No
          </button>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div
      v-if="showSuccessModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-md w-1/3">
        <h3 class="text-xl font-bold mb-4">
          Purchase Order Successfully Generated!
        </h3>
        <button
          class="bg-blue-500 text-white py-1 px-3 rounded-md"
          @click="closeSuccessModal"
        >
          Close
        </button>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <button
        :disabled="currentPage === 1"
        class="bg-gray-300 px-4 py-2 rounded"
        @click="prevPage"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        :disabled="currentPage === totalPages"
        class="bg-gray-300 px-4 py-2 rounded"
        @click="nextPage"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";
import auth from "../../../../middleware/auth";
import { apiService } from "~/api/apiService";
import "jspdf-autotable";

// This page requires authentication
definePageMeta({
  middleware: [auth],
});

export default {
  data() {
    return {
      users: [],
      quotations: [
      ],
      selectedQuotation: null,
      selectedQuotationDetail: null,
      quotationDetails: null,
      materials: null,
      selectedSupplier: null,
      showSupplierDetailsModal: false,
      showConfirmationModal: false,
      showSuccessModal: false,
      searchQuery: "",
      currentPage: 1,
      itemsPerPage: 5,
      purchasedMaterials: [],
      userInfo: null,
    };
  },
  computed: {
    filteredQuotations() {
      return this.quotations.filter(
        (quotation) =>
          quotation.id.includes(`QN-${this.searchQuery}`) ||
          this.getUserName(quotation.userID)
            .toLowerCase()
            .includes(this.searchQuery.toLowerCase())
      );
    },
    paginatedQuotations() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredQuotations.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredQuotations.length / this.itemsPerPage);
    },
  },
  async mounted() {
    await this.fetchUserData();
    await this.fetchQuotationData();
    if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    this.userInfo = storage ? storage : null;
  }
  },
  methods: {
    checkedPurchaseMaterial(isChecked, material) {
      console.log("purchasedMaterials", this.purchasedMaterials)
      if (isChecked === true){
        this.purchasedMaterials.push(material.prodtnMtrlID)
      } else {
        const newDataSet = this.purchasedMaterials
        const index  = newDataSet.indexOf(material.prodtnMtrlID);
        this.purchasedMaterials.splice(index, 1)
        console.log("index", index)
        console.log("remove purchasedMaterials", this.purchasedMaterials)
      }
    },
    openQuotationModal(quotation) {
      this.selectedQuotation = quotation;
    },
    closeQuotationModal() {
      this.selectedQuotation = null;
    },
    async openSupplierDetailsModal(supplier) {
      await this.fetchMaterialsByProductionID(
        this.selectedQuotation.productionID
      );
      this.selectedSupplier = supplier;
      this.showSupplierDetailsModal = true;
    },
    getTotalPrice(supplier) {
      const totalPrice = supplier.reduce(
        (sum, item) =>
          parseInt(sum) + parseInt(item.quantity * item.quotePrice),
        0
      );
      return totalPrice;
    },
    closeSupplierDetailsModal() {
      this.showSupplierDetailsModal = false;
      this.selectedSupplier = null;
    },
    confirmPurchaseOrder(supplier) {
      this.showConfirmationModal = true;
    },
    async generatePurchaseOrder() {
      const adminOrder = {
        userID: this.userInfo.userID,
        quoteID: this.selectedSupplier?.quotation_details[0]?.quoteID
      }

      console.log(this.selectedQuotation, adminOrder)
      const adminOrderDetails = this.purchasedMaterials.map((prodtnMtrlID) => {
      const material = this.selectedSupplier?.quotation_details.find((value) => value.prodtnMtrlID === prodtnMtrlID)
        return {
          prodtnMtrlID,
          qtyOrdered: material.quantity,
          amount: material.quantity * material.quotePrice,
          isDropped: false
        }
      })

      await apiService.post("/api/adminOrders", {...adminOrder, quotationDetails: adminOrderDetails});

      this.showConfirmationModal = false;
      this.showSuccessModal = true;
    },
    closeSuccessModal() {
      this.showSuccessModal = false;
      this.purchasedMaterials = [];
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    getUserName(userID) {
      const user = this.users?.find((us) => us.userID === userID);
      return user ? `${user.lastName}, ${user.firstName}` : "Unknown";
    },
    getSupplierName(userID) {
      const supplier = this.users?.find((value) => value.userID === userID);
      return supplier
        ? `${supplier.lastName} ${supplier.firstName}`
        : "Unknown";
    },
    getMaterialProductName(prodtnMtrlID) {
      const material = this.materials?.find(
        (val) => val.prodtnMtrlID == prodtnMtrlID
      );
      return `${material?.productName} -> ${material?.description}`;
    },
    async fetchMaterialsByProductionID(productionID) {
      const result = await apiService.get(
        `/api/materials/production/${productionID}`
      );
      this.materials = result;
    },
    async downloadQuotation(quotation) {
      await this.fetchMaterialsByProductionID(quotation.productionID);
      this.selectedQuotationDetail = quotation;
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
      console.log("selectedQuotaionDetail--", this.selectedQuotationDetail);
      await this.processPDFFile();
    },
    async processPDFFile() {
      const doc = new jsPDF();

      // Header Background
      doc.setFillColor(37, 150, 190); // Header background color
      doc.rect(0, 0, doc.internal.pageSize.getWidth(), 45, "F"); // Fill rectangle for header

      // Header Title
      doc.setFontSize(22);
      doc.setTextColor(255, 255, 255); // White text
      doc.text("Quotation", 10, 20);

      // Supplier Information
      doc.setFontSize(12);
      doc.setTextColor(255, 255, 255); // White text
      doc.text(`Quotation No: ${this.selectedQuotationDetail.quoteID}`, 10, 30);
      doc.text(
        `Supplier Name: ${this.getSupplierName(
          this.selectedQuotationDetail.userID
        )}`,
        10,
        35
      );
      doc.text(
        `Supplier ID: SUP-${this.selectedQuotationDetail.userID}`,
        10,
        40
      );

      // Draw a line under the header
      doc.setDrawColor(255, 255, 255); // Line color
      doc.setLineWidth(1.5);
      doc.line(10, 65, 200, 65); // Horizontal line

      // Table Header
      const columns = [
        { header: "Material ID", dataKey: "id" },
        { header: "Material", dataKey: "material" },
        { header: "Quantity", dataKey: "quantity" },
        { header: "Unit Price", dataKey: "quotePrice" },
        { header: "Total Price", dataKey: "totalPrice" },
      ];

      const rows = this.quotationDetails.map((item) => ({
        id: item.id,
        material: this.getMaterialProductName(item.prodtnMtrlID),
        quantity: item.quantity,
        quotePrice: item.quotePrice,
        totalPrice: item.quantity * item.quotePrice,
      }));

      doc.autoTable({
        head: [columns.map((col) => col.header)],
        body: rows.map((row) => [
          row.id,
          row.material,
          row.quantity,
          row.quotePrice,
          row.totalPrice,
        ]),
        startY: 65, // Adjusting for the header height
        margin: { horizontal: 10 },
        theme: "grid",
        styles: { cellPadding: 5, fontSize: 10 },
        headStyles: {
          fillColor: [37, 150, 190], // Same as header background
          textColor: [255, 255, 255],
          fontStyle: "bold",
        },
      });

      // Calculate total price
      const totalPrice = this.quotationDetails.reduce(
        (sum, item) =>
          parseInt(sum) + parseInt(item.quantity * item.quotePrice),
        0
      );

      // Positioning for total price on the right side
      const totalY = doc.lastAutoTable.finalY + 10; // 10 units below the table
      const totalText = `Total: ${parseInt(totalPrice.toFixed(2))}`;
      const totalX =
        doc.internal.pageSize.getWidth() - doc.getTextWidth(totalText) - 10; // 10 units from the right edge

      // Display total price
      doc.setFontSize(12);
      doc.setTextColor(0, 0, 0); // Black text
      doc.text(totalText, totalX, totalY);

      // Save the PDF
      doc.save(
        `quotation_${this.getSupplierName(
          this.selectedQuotationDetail.userID
        )}.pdf`
      );
    },
    async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.users = result.data;
    },
    async fetchQuotationData() {
      const result = await apiService.get("/api/quotationDetails/quotation");

      // Gather all prices from the quotation details
      const prices = [];

      result.data.forEach((production) => {
        production.quotations.forEach((quotation) => {
          const computedPrice = quotation.quotation_details.reduce(
            (total, detail) => {
              return total + parseFloat(detail.quotePrice);
            },
            0
          );
          prices.push(parseFloat(computedPrice));
        });
      });

      // Calculate the highest, lowest, and mid-range prices
      const highestPrice = Math.max(...prices);
      const lowestPrice = Math.min(...prices);
      // const midRangePrice = (highestPrice + lowestPrice) / 2;

      // Update quotation remarks based on total price
      const transFormData = result.data.map((production) => {
        const quotations = production.quotations.map((quotation) => {
          // Calculate total price for the quotation
          const totalPrice = quotation.quotation_details.reduce(
            (total, detail) => {
              return total + parseFloat(detail.quotePrice);
            },
            0
          );

          // Determine quotationRemarks based on totalPrice
          if (totalPrice === 0) {
            quotation.quotationRemarks = "No Quoted Price Yet";
          } else if (totalPrice >= highestPrice) {
            quotation.quotationRemarks = "Highest Price";
          } else if (totalPrice <= lowestPrice) {
            quotation.quotationRemarks = "Lowest Price";
          } else {
            quotation.quotationRemarks = "Mid Range Price";
          }
          return quotation;
        });
        return {
          ...production,
          quotations,
        };
      });
      this.quotations = transFormData.map((value, index) => {
        return {
          id: (index + 1).toString(),
          ...value,
        };
      });
    },
  },
};
</script>

<style scoped>
.container {
  font-family: "Arial", sans-serif;
  background-color: #f9fafb;
  padding: 50px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  color: #333;
  margin-bottom: 20px;
}

/* table {
  width: 100%;
  border-collapse: collapse;
} */

th,
td {
  padding: 12px 15px;
  text-align: left;
}

th {
  /* background-color: #0e8bf1; */
  color: black;
  text-transform: uppercase;
}

tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Table Row Hover Effect */
tbody tr:hover {
  background-color: #d1e7f7;
  cursor: pointer;
}

button {
  transition: all 0.3s ease-in-out;
}

/* Action Button Styles */
button i {
  font-size: 1.2rem;
}

button:hover i {
  color: #0e76a8; /* Slight hover effect for the eye icon */
}

/* Quotation View Modal Styling */
.bg-white {
  background-color: white;
  max-height: 80vh; /* 80% of the viewport height */
  overflow-y: auto; /* Scrollable content */
  padding: 24px;
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
  background-color: rgba(0, 0, 0, 0.75); /* Modal overlay */
}

/* Modal Styling */
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

button {
  padding: 8px 12px;
  border-radius: 5px;
  font-weight: bold;
}

.bg-blue-500 {
  background-color: #0e8bf1;
}

.bg-blue-500:hover {
  background-color: #1069b5; /* Darker blue for hover */
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

/* Buttons Hover Effect */
button:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

/* Add Responsive Table */
@media (max-width: 768px) {
  table {
    display: block;
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
  }

  th,
  td {
    padding: 10px;
  }
}
</style>
