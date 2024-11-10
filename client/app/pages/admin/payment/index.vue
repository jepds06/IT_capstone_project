<template>
  <div class="container mx-auto  bg-gray-100 min-h-screen">
    <!-- Page Title -->
    <h2 class="text-2xl font-black text-left mb-14">Bills Payment</h2>

    <!-- Form Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="col-span-1">
        <!-- <div class="flex justify-between items-center mb-4">
          <div>
            <button @click="editSupplier" class="mr-2 text-blue-600 hover:text-blue-800">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button @click="saveSupplier" class="text-green-600 hover:text-green-800">
              <i class="fas fa-save"></i> Save
            </button>
          </div>
        </div> -->
        <label class="block font-semibold text-lg mb-2">Production No</label>
        <USelectMenu v-model="selectedProduction" :options="productions" />
      </div>
      <!-- Supplier Section -->
      <div class="col-span-1">
        <!-- <div class="flex justify-between items-center mb-4">
          <div>
            <button @click="editSupplier" class="mr-2 text-blue-600 hover:text-blue-800">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button @click="saveSupplier" class="text-green-600 hover:text-green-800">
              <i class="fas fa-save"></i> Save
            </button>
          </div>
        </div> -->
        <label class="block font-semibold text-lg mb-2">Supplier</label>
        <USelectMenu v-model="selectedSupplier" :options="supplier" />
      </div>

      <!-- Payment Type and Cash Voucher No. -->
      <div class="col-span-1">
        <!-- Payment Type Dropdown -->
        <div class="">
          <label class="block font-semibold text-lg mb-2">Payment Type</label>
          <select
            v-model="paymentType"
            @change="handlePaymentTypeChange"
            class="w-full p-2 border rounded text-base"
          >
            <option>Select Payment Type</option>
            <option>All</option>
            <option>Cash</option>
            <option>Cheque</option>
          </select>
        </div>
        <!-- Cash Voucher No. (Visible when Cash is selected) -->
        <!-- <div v-if="paymentType === 'Cash'" class="flex-1">
            <label class="block font-semibold mb-2">Cash Voucher No.</label>
            <input type="text" class="w-full p-2 border rounded" placeholder="Enter Cash Voucher No" />
          </div> -->
      </div>

      <!-- Date Input -->
      <div class="col-span-1">
        
        <label class="block font-semibold text-lg mb-2">Date</label>
        <div class="flex">
        <!-- <input type="date" class="w-full p-2 border rounded text-base" /> -->
        <UPopover :popper="{ placement: 'bottom-start' }">
          <UButton icon="i-heroicons-calendar-days-20-solid" :label="formattedDate" />
      
          <template #panel="{ close }">
            <DatePicker v-model="selectedDate" is-required @close="close" />
          </template>
        </UPopover>
        <UButton class="ml-2" title="Clear" label="Clear" color="gray" @click="clearFilter" />
      </div>
      </div>
    </div>

    <!-- Bills Section with two tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <!-- Unpaid Bills Section -->
      <div class="bg-white shadow-md rounded p-4 h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <span class="font-semibold whitespace-nowrap">Unpaid Bills</span>
          <div>
            <label class="font-semibold mr-2">Invoice:</label>
            <input
              type="text"
              placeholder="Enter Invoice No"
              class="p-2 border rounded max-w-44 h-9 text-sm mr-2"
            />
            <button
              @click="findInvoice"
              class="px-3 py-1 bg-blue-500 text-white rounded mr-2"
            >
              Find
            </button>
          </div>
        </div>

        <table class="w-full bg-white shadow-md rounded mb-4">
          <thead>
            <tr class="bg-gray-200 text-sm text-left">
              <th class="p-2">ID</th>
              <th class="p-2">Invoice No</th>
              <th class="p-2">Invoice Date</th>
              <th class="p-2">Balance</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="bill in unpaidBills"
              :key="bill.id"
              @click="selectBill(bill)"
              class="cursor-pointer hover:bg-gray-100"
            >
              <td class="p-2">{{ bill.id }}</td>
              <td class="p-2">{{ bill.invoiceNo }}</td>
              <td class="p-2">{{ bill.invoiceDate }}</td>
              <td class="p-2">{{ bill.balance }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Selected Bills Section -->
      <div class="bg-white shadow-md rounded p-4 h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <span class="font-semibold whitespace-nowrap">Selected Bills</span>
          <div class="p-2 max-w-44 h-9 text-sm mr-2"></div>
        </div>
        <table class="w-full bg-white shadow-md rounded mb-4">
          <thead>
            <tr class="bg-gray-200 text-sm text-left">
              <th class="p-2">ID</th>
              <th class="p-2">Invoice No</th>
              <th class="p-2">Invoice Date</th>
              <th class="p-2">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="bill in selectedBills"
              :key="bill.id"
              class="hover:bg-gray-100"
            >
              <td class="p-2 flex items-center">
                <input type="checkbox" v-model="bill.selected" class="mr-2" />
                {{ bill.id }}
              </td>
              <td class="p-2">{{ bill.invoiceNo }}</td>
              <td class="p-2">{{ bill.invoiceDate }}</td>
              <td class="p-2">{{ bill.balance }}</td>
            </tr>
          </tbody>
        </table>
        <p class="font-bold text-right">
          Total Bills Amount: {{ totalBillsAmount }}
        </p>
      </div>
    </div>

    <!-- Cheques Section -->
    <div class="bg-white shadow-md rounded p-4">
      <h3 class="text-lg font-semibold">Cheques</h3>

      <!-- Add Cheque Button on the Left -->
      <div class="flex justify-between mb-4">
        <div class="flex-1"></div>
        <button
          @click="addCheque"
          class="bg-blue-500 text-white text-base px-2 py-2 rounded hover:bg-blue-600"
        >
          Add Cheque
        </button>
      </div>

      <table class="w-full bg-white shadow-md rounded mb-4">
        <thead>
          <tr class="bg-gray-200 text-sm text-left">
            <!-- <th class="p-2">Voucher No</th> -->
            <th class="p-2">Payee</th>
            <th class="p-2">Bank Name</th>
            <th class="p-2">Check No</th>
            <th class="p-2">Due Date</th>
            <th class="p-2">Amount</th>
            <th class="p-2 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="cheque in cheques"
            :key="cheque.id"
            class="hover:bg-gray-100"
          >
            <!-- <td class="p-2">{{ cheque.voucherNo }}</td> -->
            <td class="p-2">{{ cheque.payee }}</td>
            <td class="p-2">{{ cheque.bankName }}</td>
            <td class="p-2">{{ cheque.checkNo }}</td>
            <td class="p-2">{{ cheque.dueDate }}</td>
            <td class="p-2">{{ cheque.amount }}</td>
            <td class="p-2 text-center">
              <button
                @click="removeCheque(cheque)"
                class="bg-red-500 text-white px-2 py-1 rounded"
              >
                Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="font-bold text-md text-right">
        Total Cheque Amount: {{ totalChequeAmount }}
      </p>
    </div>

    <!-- Prepared By -->
    <div class="mt-10">
      <label class="font-semibold mb-2 block text-bold">Prepared By:</label>
      <span class="ml-10 p-2 font-extrabold">
        QWERTY12345
        <!-- Replace this with the actual name or a variable if needed -->
      </span>
    </div>

    <!-- Modal for Adding Cheque -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
    >
      <div class="bg-white p-6 rounded shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Add Cheque</h3>
        <!-- <div class="mb-4">
          <label class="block mb-1">Voucher No</label>
          <input
            type="text"
            v-model="newCheque.voucherNo"
            class="w-full p-2 border rounded"
            readonly
          />
        </div> -->
        <div class="mb-4">
          <label class="block mb-1">Payee</label>
          <input
            type="text"
            v-model="newCheque.payee"
            class="w-full p-2 border rounded"
          />
        </div>
        <div class="mb-4">
          <label class="block mb-1">Bank Name</label>
          <select
            v-model="newCheque.bankName"
            class="w-full p-2 border rounded"
          >
            <option value="">Select Bank</option>
            <option>Bank A</option>
            <option>Bank B</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block mb-1">Check No</label>
          <input
            type="text"
            v-model="newCheque.checkNo"
            class="w-full p-2 border rounded"
          />
        </div>
        <div class="mb-4">
          <label class="block mb-1">Due Date</label>
          <input
            type="date"
            v-model="newCheque.dueDate"
            class="w-full p-2 border rounded"
          />
        </div>
        <div class="mb-4">
          <label class="block mb-1">Amount</label>
          <input
            type="number"
            v-model="newCheque.amount"
            class="w-full p-2 border rounded"
          />
        </div>
        <div class="flex justify-end">
          <button
            @click="addNewCheque"
            class="bg-green-500 text-white px-4 py-2 rounded"
          >
            Add
          </button>
          <button
            @click="isModalOpen = false"
            class="bg-red-500 text-white px-4 py-2 rounded ml-2"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { format } from 'date-fns';
import { apiService } from '~/api/apiService';

export default {
  data() {
    return {
      selectedDate: new Date(),
      productions: [],
      selectedProduction: null,
      supplier: [],
      selectedSupplier: null,
      paymentType: "",
      selectedBills: [],
      unpaidBills: [],
      cheques: [],
      newCheque: {
        // voucherNo: "",
        payee: "",
        bankName: "",
        checkNo: "",
        dueDate: "",
        amount: 0,
      },
      isModalOpen: false,
    };
  },
  computed: {
    formattedDate() {
      return format(this.selectedDate, 'd MMM, yyyy');
    },
    totalBillsAmount() {
      return this.selectedBills.reduce((sum, bill) => sum + bill.balance, 0);
    },
    totalChequeAmount() {
      return this.cheques.reduce((sum, cheque) => sum + cheque.amount, 0);
    },
  },
  methods: {
    handlePaymentTypeChange() {
      // Logic for handling payment type change
    },
    findInvoice() {
      // Logic for finding an invoice
    },
    selectBill(bill) {
      // Logic for selecting a bill
    },
    addCheque() {
      this.isModalOpen = true;
    },
    submitCheque() {
      // Logic for submitting cheque
      this.isModalOpen = false;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    removeCheque(cheque) {
      // Logic for removing a cheque
    },
    editSupplier() {
    // Logic for editing supplier
    },
    saveSupplier() {
      // Logic for saving supplier
    },

    clearFilter() {
      this.selectedDate = new Date()
      this.selectedSupplier = null
      this.selectedProduction = null
    },
    async fetchProductions(){
      const result = await apiService.get("/api/productions");

      this.productions = result.data?.filter((prod) => prod.status === "In Progress").map((prod) => {
        return {
          id: prod.productionID,
          label: `${prod.productionID} - ${prod.remarks}`
        }
      })
    },
   async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.supplier = result.data?.filter((user) => user.userTypeID === 3)?.map((user) =>{
        return {
          id: user.userID,
          label: `${user.userID} - ${user.lastName} ${user.firstName}`
        }
      });
    },
  },
  async mounted() {
    await this.fetchProductions();
    await this.fetchUserData();
  //   if (process.client) {
  //   const storage = JSON.parse(localStorage.getItem("userInfo"));
  //   this.userInfo = storage ? storage : null;
  // }
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
  /* background-color:cadetblue; */
  color: black;
  text-transform: uppercase;
}

/* tr:hover {
    background-color: #e3f2fd;
  } */

button {
  cursor: pointer;
}

button:hover {
  opacity: 0.9;
}

input[type="text"],
input[type="date"],
select {
  width: 100%;
}
</style>
