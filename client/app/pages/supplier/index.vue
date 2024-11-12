<template>
  <div>
    <!-- Main Tabs Navigation -->
    <ul class="flex border-b">
      <!-- Quotations Tab -->
      <li
        :class="{
          'border-blue-500 text-blue-500': activeMainTab === 'quotations',
          'border-transparent': activeMainTab !== 'quotations',
        }"
        class="cursor-pointer p-4 border-b-2"
        @click="setActiveMainTab('quotations')"
      >
        Quotations
      </li>

      <!-- Purchase Order Tab -->
      <li
        :class="{
          'border-blue-500 text-blue-500': activeMainTab === 'purchaseOrder',
          'border-transparent': activeMainTab !== 'purchaseOrder',
        }"
        class="cursor-pointer p-4 border-b-2"
        @click="setActiveMainTab('purchaseOrder')"
      >
        Purchase Order
      </li>
    </ul>

    <!-- Quotations Tab Content -->
    <div v-if="activeMainTab === 'quotations'">
      <ul class="flex border-b mt-4">
        <!-- Quotation Request Sub-Tab -->
        <li
          :class="{
            'border-blue-500 text-blue-500':
              activeSubTab === 'quotationRequest',
            'border-transparent': activeSubTab !== 'quotationRequest',
          }"
          class="cursor-pointer p-4 border-b-2"
          @click="setActiveSubTab('quotationRequest')"
        >
          Quotation Request
        </li>

        <!-- Cancelled Quotations Sub-Tab -->
        <li
          :class="{
            'border-blue-500 text-blue-500':
              activeSubTab === 'cancelledQuotations',
            'border-transparent': activeSubTab !== 'cancelledQuotations',
          }"
          class="cursor-pointer p-4 border-b-2"
          @click="setActiveSubTab('cancelledQuotations')"
        >
          Completed Quotations
        </li>
      </ul>

      <!-- Quotation Request Content -->
      <div v-if="activeSubTab === 'quotationRequest'" class="mt-4">
        <!-- Quotation Request Table and Pagination -->
        <SupplierQuotation />
      </div>

      <!-- Completed Quotations Content -->
      <div v-if="activeSubTab === 'cancelledQuotations'" class="mt-4">
        <SupplierQuotation :is-completed="true" />
      </div>
    </div>

    <!-- Purchase Order Tab Content -->
    <div v-if="activeMainTab === 'purchaseOrder'" class="mt-4">
      <SupplierPurchaseOrder />
    </div>

  </div>
</template>

<script setup>
import { ref } from "vue";

// State variables
const activeMainTab = ref("quotations"); // Active main tab
const activeSubTab = ref("quotationRequest"); // Active sub tab for quotations

// Methods for switching tabs
const setActiveMainTab = (tab) => {
  activeMainTab.value = tab;
};

const setActiveSubTab = (tab) => {
  activeSubTab.value = tab;
};

</script>

