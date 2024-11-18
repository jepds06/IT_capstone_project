<template>
  <div class="m-8">
    <!-- Page Title -->
    <h2 class="text-2xl font-extrabold text-left mb-14">Manage Payment</h2>

    <!-- Form Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
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
        <label class="block font-semibold text-lg mb-2">Customer</label>
        <USelectMenu v-model="selectedCustomer" :options="customer" searchable
        searchable-placeholder="Search a customer..."/>
      </div>

      <!-- Date Input -->
      <div class="col-span-1">
        <!-- <label class="block font-semibold text-lg mb-2">Actions</label>
        <div class="flex"> -->
          <!-- <input type="date" class="w-full p-2 border rounded text-base" /> -->
          <!-- <UPopover :popper="{ placement: 'bottom-start' }">
          <UButton icon="i-heroicons-calendar-days-20-solid" :label="formattedDate" />
      
          <template #panel="{ close }">
            <DatePicker v-model="selectedDate" is-required @close="close" />
          </template>
        </UPopover> -->
          <!-- <UButton
            class="ml-2"
            title="Filter"
            label="Filter  "
            color="blue"
            @click="applyFilter"
          />
          <UButton
            class="ml-2"
            title="Clear"
            label="Clear"
            color="gray"
            @click="clearFilter"
          /> -->
        <!-- </div> -->
      </div>
    </div>

    <!-- Bills Section with two tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <!-- Unpaid Bills Section -->
      <div class="bg-white shadow-md rounded p-4 h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <span class="font-semibold whitespace-nowrap">Unpaid Bills</span>
        </div>

        <table class="w-full bg-white shadow-md rounded mb-4">
          <thead>
            <tr class="bg-gray-200 text-sm text-center">
              <!-- <th class="p-2">ID</th> -->
              <th class="p-2">Invoice No</th>
              <th class="p-2">Invoice Date</th>
              <th class="p-2">Balance</th>
              <th class="p-2">Amount Paid</th>
              <th class="p-2">Amount To Pay</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="bill in unpaidBills"
              :key="bill.id"
              @click="selectBill(bill)"
              class="cursor-pointer hover:bg-gray-100"
            >
              <!-- <td class="p-2">{{ bill.id }}</td> -->
              <td class="p-2">{{ bill.cstrPayID }}</td>
              <td class="p-2">{{ bill.salesDate }}</td>
              <td class="p-2">
                {{
                  new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                  }).format(bill.balance)
                }}
              </td>
              <td class="p-2">
                {{
                  new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                  }).format(bill.amountPaid)
                }}
              </td>
              <td class="p-2">
                {{
                  new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                  }).format(bill.amountToPay)
                }}
              </td>
            </tr>
          </tbody>
        </table>
        <p class="font-bold text-right">
          Total Balance:
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(totalUnpaidBillsAmount)
          }}
        </p>
      </div>

      <!-- Selected Bills Section -->
      <div class="bg-white shadow-md rounded p-4 h-96 overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <div class="col-span-1 items-center">
            <span class="font-semibold whitespace-nowrap">Selected Bills</span>
          </div>

          <!-- <select
              v-model="paymentType"
              @change="handlePaymentTypeChange"
              class="w-full p-2 border rounded text-base"
            >
              <option>Select Payment Type</option>
              <option>All</option>
              <option>Cash</option>
              <option>Cheque</option>
            </select> -->
          <div class="col-span-1">
            <USelectMenu
              v-model="selectedPaymentType"
              :options="paymentTypes"
              placeholder="Select payment type"
            />
          </div>
        </div>
        <table class="w-full bg-white shadow-md rounded mb-4">
          <thead>
            <tr class="bg-gray-200 text-sm text-center">
              <th class="p-2"></th>
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
              </td>
              <td class="p-2">{{ bill.cstrPayID }}</td>
              <td class="p-2">{{ bill.salesDate }}</td>
              <!-- <td class="p-2">{{  new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(bill.balance) }}</td> -->
              <td class="p-2 flex items-center">
                <input
                  id="amountToPay"
                  v-model.number="bill.amount"
                  type="number"
                  step="0.01"
                  placeholder="Enter amount to pay"
                  required
                  class="w-full p-2 border rounded"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <p class="font-bold text-right">
          Total Bills Amount:
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(totalBillsAmount)
          }}
        </p>
        <div class="flex justify-end">
          <UButton
            :loading="isLoadingPay"
            label="Pay"
            icon="material-symbols:payments-outline"
            @click="saveCustomer"
            color="green"
            :disabled="
              !selectedPaymentType ||
              selectedBills?.filter((value) => value.selected).length === 0
            "
          />
        </div>
      </div>
    </div>

    <div
      v-if="statusMessage"
      class="mt-4 p-2 bg-green-100 text-green-700 rounded-md"
    >
     <pre>{{ statusMessage }}</pre> 
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
import { format } from "date-fns";
import { apiService } from "~/api/apiService";

export default {
  data() {
    return {
      statusMessage: "",
      selectedDate: new Date(),
      productions: [],
      selectedProduction: null,
      customer: [],
      selectedCustomer: null,
      paymentTypes: [],
      selectedPaymentType: null,
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
      isLoadingPay: false,
    };
  },
  watch:{
    async selectedCustomer(oldVal, newVal){
      console.log(oldVal, newVal)
      if(oldVal?.id !== newVal?.id){
        await this.fetchCustomerPaymentsData()
      }
    }
  },
  computed: {
    formattedDate() {
      return format(this.selectedDate, "d MMM, yyyy");
    },
    totalBillsAmount() {
      return this.selectedBills.reduce((sum, bill) => sum + bill.balance, 0);
    },
    totalUnpaidBillsAmount() {
      return this.unpaidBills.reduce((sum, bill) => sum + bill.balance, 0);
    },
    totalChequeAmount() {
      return this.cheques.reduce((sum, cheque) => sum + cheque.amount, 0);
    },
  },
  methods: {
    setTemporaryMessage(messageType, message) {
      if (messageType === "status") {
        this.statusMessage = message;
      } else if (messageType === "modal") {
        this.modalMessage = message;
      }
      setTimeout(() => {
        if (messageType === "status") {
          this.statusMessage = "";
        } else if (messageType === "modal") {
          this.modalMessage = "";
        }
      }, 5000);
    },
    handlePaymentTypeChange() {
      // Logic for handling payment type change
    },
    findInvoice() {
      // Logic for finding an invoice
    },
    selectBill(bill) {
      const isExist = this.selectedBills
        ?.map((value) => value.id)
        .find((val) => val === bill.id);
      if (!isExist) this.selectedBills.push(bill);
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
    async saveCustomer() {
      // Logic for saving supplier
      this.isLoadingPay = true;
      const data = this.selectedBills.filter((val) => val.selected);
      // console.log(this.selectedBills);
      let message = "";

      const dataToSave = this.selectedBills.map((value) => {
              if (value.amount > value.balance) {
            message =
              message +
              `Payment for invoice no: ${value.cstrPayID} is greater than the balance amount.\n`;
            return;
          }
          message =
            message + `Payment for invoice no: ${value.cstrPayID} is successful.\n`;
        return {
          ...value,
          paymentStatus: parseFloat(value.amountToPay) > parseFloat(value.amount)
                ? "pending"
                : "completed",
          paymentDate: format(new Date(), "yyyy-MM-dd"),
          payMethodID: this.selectedPaymentType.id,
          amountPaid: value.amount
        }
      });
      await Promise.all(dataToSave?.map(async (value) => {
          value ? await apiService.post("/api/customerPayments", value) : "";
        }))
      await this.fetchCustomerPaymentsData();
      this.isLoadingPay = false;
      this.setTemporaryMessage("status",message);
    },
   async fetchCustomerPaymentsData(){
    const result = await apiService.get("/api/sales");
          this.unpaidBills = result.data?.filter(
              (value) => value.userID === this.selectedCustomer.id
            )
            .map((value, index) => {
             const totalAmountPaid = value.customer_payment?.reduce(
                (sum, item) => parseFloat(sum) + parseFloat(item.amountPaid),
                0
              )
              console.log('totalAmountPaid', totalAmountPaid)
              return {
                amountToPay: value.customer_payment[0]?.amountToPay,
                cstrPayID: value.customer_payment[0]?.cstrPayID,
                amountPaid: totalAmountPaid,
                balance: parseFloat(value.customer_payment[0]?.amountToPay) - parseFloat(totalAmountPaid),
                salesDate: value.salesDate,
                salesID: value.salesID,
                paymentStatus: value.customer_payment[0]?.paymentStatus,
                dueDate: value.customer_payment[0]?.dueDate,
                id: index + 1,
              };
            })
            ?.filter((value) => value.balance !== 0);

            console.log("unpaidBills", this.unpaidBills)
   },
    async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.customer = result.data
        ?.filter((user) => user.userTypeID === 2)
        ?.map((user) => {
          return {
            id: user.userID,
            label: `${user.lastName} ${user.firstName}`,
          };
        });
    },
    async fetchPaymentMethod() {
      const result = await apiService.get("/api/paymentMethods");

      this.paymentTypes = result.data?.map((payment) => {
        return {
          id: payment.payMethodID,
          label: payment.payMethodName,
        };
      });
    },
    async fetchPaymentByProductionNo(productionID) {
      return await apiService.get(
        `/api/adminOrders/production/${productionID}`
      );
    },
  },
  async mounted() {
    // await this.fetchProductions();
    await this.fetchUserData();
    await this.fetchPaymentMethod();
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
