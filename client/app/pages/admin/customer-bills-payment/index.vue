<template>
  <div class="m-8 space-y-6">
    <!-- Title -->
    <h1 class="text-2xl font-extrabold">Bills Payment</h1>

    <!-- Overview Cards -->
    <div class="grid grid-cols-5 gap-4">
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Total Sales</h2>
        <p class="text-2xl mt-2 text-center">
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(totalSales)
          }}
        </p>
      </div>
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Completed Orders</h2>
        <p class="text-2xl mt-2 text-center">{{completedOrders}}</p>
      </div>
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Pick up</h2>
        <p class="text-2xl mt-2 text-center">{{pickupOrders}}</p>
      </div>
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Out for delivery</h2>
        <p class="text-2xl mt-2 text-center">{{outForDeliveries}}</p>
      </div>
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Pending</h2>
        <p class="text-2xl mt-2 text-center">{{pendingDeliveries}}</p>
      </div>
    </div>

    <!-- Filter Options -->
    <div class="flex gap-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by Order ID or Customer Name"
        class="px-4 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <!-- <input
        type="date"
        v-model="startDate"
        class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <input
        type="date"
        v-model="endDate"
        class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      /> -->
      <!-- <button
        @click="applyFilters"
        class="px-6 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700"
      >
        Generate Report
      </button> -->
    </div>

    <!-- Export Options -->
    <div class="flex justify-end mb-4">
      <button
        @click="exportPDF(filteredReports)"
        class="px-4 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 mr-2"
      >
        Export to PDF
      </button>
      <button
        @click="exportCSV(filteredReports)"
        class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700"
      >
        Export to CSV
      </button>
    </div>

    <!-- Report Table -->
    <div class="overflow-x-auto">
      <table
        class="min-w-full bg-white border border-gray-300 rounded-lg shadow overflow-hidden"
      >
        <thead class="bg-gray-500 text-white uppercase tracking-wide text-sm">
          <tr>
            <th class="py-3 px-4 text-left">Order ID</th>
            <th class="py-3 px-4 text-left">Customer Name</th>
            <th class="py-3 px-4 text-left">Balance</th>
            <th class="py-3 px-4 text-left">Amount Paid</th>
            <th class="py-3 px-4 text-left">Total Amount</th>
            <th class="py-3 px-4 text-left">Order Date</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="report in filteredReports"
            :key="report.salesID"
            class="border-b hover:bg-gray-100"
          >
            <td class="px-6 py-3">{{ report.salesID }}</td>
            <td class="px-6 py-3">{{ getUserName(report.userID) }}</td>
            <td class="px-6 py-3">
              {{
                new Intl.NumberFormat("en-PH", {
                  style: "currency",
                  currency: "PHP",
                }).format(report.balance)
              }}
            </td>
            <td class="px-6 py-3">
              {{
                new Intl.NumberFormat("en-PH", {
                  style: "currency",
                  currency: "PHP",
                }).format(report.amountPaid)
              }}
            </td>
            <td class="px-6 py-3">
              {{
                new Intl.NumberFormat("en-PH", {
                  style: "currency",
                  currency: "PHP",
                }).format(report.totalAmount)
              }}
            </td>
            <td class="px-6 py-3">{{ report.salesDate }}</td>
            <td class="px-6 py-3">
              <i
                :class="getStatusIcon(report.sales_deliveries.deliveryStatus)"
                :title="report.sales_deliveries.deliveryStatus"
              ></i>
            </td>
            <td class="px-6 py-3 flex gap-2">
                <!-- <button @click="viewReport(report.salesID)" class="text-blue-500 hover:text-blue-700">
                  <i class="fa-solid fa-eye"></i>
                </button> -->
                
                <UButton
            class="mr-2"
            icon="lets-icons:view-alt-duotone"
            @click="viewReport(report.salesID)"
            rounded="false"
            title="View report"
            color="white"
            square
          />
          <UButton
            class="mr-2"
            icon="prime:receipt"
            @click="exportInvoicePDF(report)"
            rounded="false"
            title="View report"
            color="white"
            square
          />
              </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <span class="text-sm text-gray-500">
        Showing {{ start + 1 }} to {{ end }} of {{ reports.length }} reports
      </span>
      <div class="flex gap-4">
        <button
          :disabled="page === 1"
          @click="page--"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
        >
          Previous
        </button>
        <button
          :disabled="page * itemsPerPage >= reports.length"
          @click="page++"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>

    <!-- View Modal -->
    <div v-if="isViewModalOpen" class="modal-overlay">
      <div class="modal-content">
        <h2 class="text-lg font-semibold">Payment Details</h2>
        <p>Order ID: {{ modalData.salesID }}</p>
        <p>Customer Name: {{ getUserName(modalData.userID) }}</p>

        <div class="p-4 max-h-96 overflow-y-auto">
          <!-- Payment History -->
          <h3 class="text-md font-semibold mb-2">Payment History</h3>
          <div class="overflow-x-auto">
            <table class="w-full table-auto modal-table">
              <thead>
                <tr>
                  <th class="py-2 px-4 text-left">Date</th>
                  <th class="py-2 px-4 text-left">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="payment in modalData?.customer_payment" :key="payment.cstrPayID">
                  <td class="py-2 px-4">{{ payment.paymentDate }}</td>
                  <td class="py-2 px-4">₱{{ payment.amountPaid }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Current Payment -->
          <h3 class="text-md font-semibold mt-4 mb-2">Current Payment</h3>
          <p class="mb-4">₱{{ modalData?.customer_payment[modalData?.customer_payment?.length - 1].amountPaid ?? 0 }}</p>
          <!-- Balance -->
          <h3 class="text-md font-semibold mt-4 mb-2">Balance</h3>
          <p class="mb-4">₱{{ modalData?.balance }}</p>
          <!-- Total Amount -->
          <h3 class="text-md font-semibold mt-4 mb-2">Total Amount</h3>
          <p>₱{{ modalData?.totalAmount }}</p>
        </div>
        <button
          @click="closeModal"
          class="mt-4 bg-blue-600 text-white px-4 py-2 rounded"
        >
          Close
        </button>
      </div>
    </div>

    <!-- Edit Modal -->
    <div v-if="isEditModalOpen" class="modal-overlay">
      <div class="modal-content">
        <h2 class="text-lg font-semibold">Edit Report</h2>
        <label>
          Total Amount:
          <input
            v-model="modalData.totalAmount"
            class="mt-2 p-2 border rounded"
            type="text"
          />
        </label>
        <button
          @click="saveChanges"
          class="mt-4 bg-green-600 text-white px-4 py-2 rounded"
        >
          Save
        </button>
        <button
          @click="closeModal"
          class="mt-4 bg-gray-600 text-white px-4 py-2 rounded"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import auth from "~/middleware/auth";
// This page requires authentication

useSeoMeta({
  title: 'Customer Bills Payment',
  description: 'Admin Dashboard'
})

definePageMeta({
  middleware: [auth],
});
import { ref, computed } from "vue";
import { jsPDF } from "jspdf"; // Import jsPDF for PDF generationpnpm install jspdf
import { apiService } from "~/api/apiService";
import { format } from 'date-fns';
import "jspdf-autotable";

const reports = ref([
  // { orderID: 101, customerName: "Maria Santos", totalAmount: "₱15,000", orderDate: "2024-11-01", status: "Completed" },
  // Additional report data
]);

const users = ref([]);

const exportPDF = (data) => {

const pdf = new jsPDF();

// Title and Date
const today = new Date().toLocaleDateString("en-CA");
pdf.setFontSize(18);
pdf.text("Sales Report", 105, 20, { align: "center" });
pdf.setFontSize(12);
pdf.text(`Date: ${today}`, 105, 28, { align: "center" });

// Define columns and map data
const columns = [
  { header: "Sales ID", dataKey: "salesID" },
  { header: "CustomerName", dataKey: "userID" },
  { header: "Sales Date", dataKey: "salesDate" },
  { header: "Total Amount", dataKey: "totalAmount" },
  { header: "Balance", dataKey: "balance" },
  { header: "Amount Paid", dataKey: "amountPaid" },
];

const body = data.map((sale) => ({
  salesID: sale.salesID,
  userID: getUserName(sale.userID),
  salesDate: sale.salesDate,
  totalAmount: sale.totalAmount,
  balance: sale.balance,
  amountPaid: sale.amountPaid,
}));

// Add AutoTable
pdf.autoTable({
  columns,
  body,
  startY: 35,
  theme: "grid",
  styles: {
    fontSize: 10,
    cellPadding: 4,
  },
  headStyles: {
    fillColor: [37, 150, 190],
    textColor: [255, 255, 255],
  },
  alternateRowStyles: {
    fillColor: [240, 240, 240],
  },
});

// Save the PDF
pdf.save(`Sales_Report_${today}.pdf`);
};

const exportInvoicePDF = (data) => {

const pdf = new jsPDF();

// Title and Date
const today = new Date().toLocaleDateString("en-CA");
pdf.setFontSize(18);
pdf.text("Sales Report", 105, 20, { align: "center" });
pdf.setFontSize(12);
pdf.text(`Date: ${today}`, 105, 28, { align: "center" });


  // Header Background
  pdf.setFillColor(37, 150, 190); // Header background color
      pdf.rect(0, 0, pdf.internal.pageSize.getWidth(), 45, "F"); // Fill rectangle for header

      // Header Title
      pdf.setFontSize(22);
      pdf.setTextColor(255, 255, 255); // White text
      pdf.text(`Sales: IN-00${data.salesID} `, 10, 20);

      // Supplier Information
      pdf.setFontSize(12);
      pdf.setTextColor(255, 255, 255); // White text
      pdf.text(`Customer Name: ${getUserName(data.userID)}`, 10, 30);
      pdf.text(
        `Address: ${data.sales_deliveries.deliveryAddress}`,
        10,
        35
      );
      // pdf.text(
      //   `Supplier ID: SUP-${this.selectedQuotationDetail.userID}`,
      //   10,
      //   40
      // );

// Define columns and map data
const columns = [
  { header: "Sales Product ID", dataKey: "slsPrdOrdID" },
  { header: "Product", dataKey: "productName" },
  { header: "Amount", dataKey: "amount" },
  { header: "Qty Ordered", dataKey: "qtyOrdered" },
  { header: "Total Amount", dataKey: "totalAmount" },
];

const body = data.sales_orders.map((sale) => ({
  slsPrdOrdID: sale.slsPrdOrdID,
  productName: sale.product.productName,
  amount: sale.product.unitPrice,
  qtyOrdered: sale.qtyOrdered,
  totalAmount: sale.amount,
}));

// Add AutoTable
pdf.autoTable({
  columns,
  body,
  startY: 65,
  theme: "grid",
  styles: {
    fontSize: 10,
    cellPadding: 4,
  },
  headStyles: {
    fillColor: [37, 150, 190],
    textColor: [255, 255, 255],
  },
  alternateRowStyles: {
    fillColor: [240, 240, 240],
  },
});

const totalPrice = data.sales_orders.reduce(
        (sum, item) =>
          parseFloat(sum) + parseFloat(item.amount),
        0
      );

      // Positioning for total price on the right side
      const totalY = pdf.lastAutoTable.finalY + 10; // 10 units below the table
      const totalText = `Total: ${parseInt(totalPrice.toFixed(2))}`;
      const totalX =
        pdf.internal.pageSize.getWidth() - pdf.getTextWidth(totalText) - 10; // 10 units from the right edge

      // Display total price
      pdf.setFontSize(12);
      pdf.setTextColor(0, 0, 0); // Black text
      pdf.text(totalText, totalX, totalY);

// Save the PDF
pdf.save(`SaleIN-00${data.salesID}_Report_${today}.pdf`);
};

const exportCSV = (data) => {
  const headers = [
    "Order ID",
    "Customer Name",
    "Total Amount",
    "Balance",
    "Amount Paid",
  ];
  const csvContent = [
    headers.join(","), // CSV headers
    ...reports.value
      .map((sale) =>
        [
             sale.salesID,
            getUserName(sale.userID),
            sale.salesDate,
           sale.totalAmount,
            sale.balance,
             sale.amountPaid,
        ].join(",")
      ),
  ].join("\n");

  const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
  const url = URL.createObjectURL(blob);
  const link = document.createElement("a");
  link.setAttribute("href", url);
  link.setAttribute("download", "Report.csv");
  link.style.visibility = "hidden";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const searchQuery = ref("");
const startDate = ref("");
const endDate = ref("");
const page = ref(1);
const itemsPerPage = 5;

const isViewModalOpen = ref(false);
const isEditModalOpen = ref(false);
const modalData = ref({});

const filteredReports = computed(() => {
  return reports.value
    .filter(
      (report) =>{
        return report.salesID.toString().includes(searchQuery.value) ||
        getUserName(report.userID)
          .toLowerCase()
          .includes(searchQuery.value.toLowerCase())
      }
        
    )
    .slice(start.value, end.value);
});

const totalSales = computed(() => {
  return reports.value.reduce(
    (sum, item) => parseFloat(sum) + parseFloat(item.totalAmount),
    0
  );
});

const pickupOrders = computed(() => {
  return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'To be pickup')?.length;
});
const completedOrders = computed(() => {
  return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'Completed')?.length;
});

const outForDeliveries = computed(() => {
  return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'Out for delivery')?.length;
});

const pendingDeliveries = computed(() => {
  return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'Pending')?.length;
});

const start = computed(() => (page.value - 1) * itemsPerPage);
const end = computed(() =>
  Math.min(page.value * itemsPerPage, reports.value.length)
);

const getStatusIcon = (status) => {
  return {
    ["Completed"]: "fa-solid fa-check-circle text-green-500",
    ["To be pickup"]: "fa-solid fa-hourglass-half text-blue-500",
    ["Out for delivery"]: "fa-solid fa-hourglass-half text-yellow-500",
    ["Pending"]: "fa-solid fa-times-circle text-red-500",
  }[status];
};

const viewReport = (salesID) => {
  const report = reports.value.find((r) => r.salesID === salesID);
  modalData.value = { ...report };
  isViewModalOpen.value = true;
};

const editReport = (salesID) => {
  const report = reports.value.find((r) => r.salesID === salesID);
  modalData.value = { ...report };
  isEditModalOpen.value = true;
};

const closeModal = () => {
  isViewModalOpen.value = false;
  isEditModalOpen.value = false;
};

const saveChanges = () => {
  console.log("Saving changes:", modalData.value);
  closeModal();
};

const getUserName = (userID) => {
  const user = users.value?.find((us) => us.userID === userID);
  return user ? `${user.lastName}, ${user.firstName}` : "Unknown";
};

const fetchUsersData = async () => {
  const result = await apiService.get("/api/users");
  users.value = result.data;
};
const fetchSalesData = async () => {
  const result = await apiService.get("/api/sales");

  reports.value = result.data?.map((value) => {
    const totalAmount = value.sales_orders?.reduce(
      (sum, item) => parseFloat(sum) + parseFloat(item.amount),
      0
    );
    const totalAmountPaid = value.customer_payment?.reduce(
                (sum, item) => parseFloat(sum) + parseFloat(item.amountPaid),
                0
              )
    return {
      ...value,
      totalAmount,
      balance: totalAmount - totalAmountPaid,
      amountPaid: totalAmountPaid
    };
  });

  console.log(reports.value)
};

onMounted(async () => {
  await fetchUsersData();
  await fetchSalesData();
});
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 0.5rem;
  width: 400px;
}

.modal-table th,
.modal-table td {
  border: 1px solid #ddd;
}
.modal-table th {
  background-color: #6b7280;
  color: white;
}
.modal-table tr:nth-child(even) {
  background-color: #f9fafb;
}
</style>
