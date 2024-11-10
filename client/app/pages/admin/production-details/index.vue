<template>
    <div class="p-6">
      <!-- Page Title -->
      <h2 class="text-2xl font-bold mb-4">Production Details</h2>
  
      <!-- Modal for Generating Materials -->
      <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/5">
          <h3 class="text-lg font-semibold mb-2">Generated Materials</h3>
          <div v-if="generatedMaterials.length > 0">
            <!-- <ul>
              <li v-for="(material, index) in generatedMaterials" :key="index">
                {{ material }}
              </li>
            </ul> -->
            <div class="mb-4">
              <table class="min-w-full border border-gray-300 rounded-lg" :key="generatedMaterials.length">
                <thead class="bg-gray-100">
                  <tr class="p-2 border-b text-black text-center">
                    <th>ID</th>
                    <th>Material</th>
                    <th>Status</th>
                    <th>Qty.</th>
                  </tr>
                </thead>
                <tbody v-if="generatedMaterials.length > 0">
                  <tr v-for="material in generatedMaterials" :key="material.prodtnMtrlID" class="p-2 border-b text-black text-center">
                    <td>{{ material.id }}</td>
                    <td>{{ material.productMatsID }}</td>
                    <!-- <td>{{ material.prodtnDetailID }}</td> -->
                    <td class="px-6 py-4 border-b">
                      <span v-if="material.status === 'Completed'" class="text-green-600">✔️ {{material.status}}</span>
                      <span v-else-if="material.status === 'Pending'" class="text-yellow-600">⚠️ {{material.status}}</span>
                      <span v-else class="text-red-600">❌ {{material.status}}</span>
                    </td>
                    <td>{{ material.qtyNeeded }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-else>
            <p>No materials generated.</p>
          </div>
          <div class="flex justify-end">
            <button @click="showModal = false" class="bg-gray-300 text-black px-4 py-2 rounded">Close</button>
          </div>
        </div>
      </div>
  
      <!-- Search Bar -->
      <div class="flex justify-between mb-4">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search..."
          class="w-1/3 p-2 border rounded-lg"
        />
      </div>
  
      <!-- Buttons for Generating Materials -->
      <!-- <div class="flex justify-between mb-4">
        <button @click="generateAllMaterials" class="bg-blue-500 text-white px-4 py-2 rounded">Generate for All Productions</button>
        <button @click="generateSelectedMaterials" class="bg-green-500 text-white px-4 py-2 rounded" :disabled="!anySelected">Generate for Selected Productions</button>
      </div> -->
  
      <!-- Production Details Table -->
      <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <!-- <th class="px-6 py-2 text-left border-b">Select</th> -->
            <th class="px-6 py-2 text-left border-b">Product Details No</th>
            <th class="px-6 py-2 text-left border-b">Production ID</th>
            <th class="px-6 py-2 text-left border-b">Product</th>
            <th class="px-6 py-2 text-left border-b">Quantity</th>
            <th class="px-6 py-2 text-left border-b">Status</th>
            <th class="px-6 py-2 text-left border-b">Remarks</th>
            <th class="px-6 py-2 text-left border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="detail in filteredDetails" :key="detail.prodtnDetailID" class="hover:bg-gray-50">
            <!-- <td class="px-6 py-4 border-b">
              <input type="checkbox" v-model="selectedItems" :value="detail.productionId" />
            </td> -->
            <td class="px-6 py-4 border-b">{{ detail.prodtnDetailID  }}</td>
            <td class="px-6 py-4 border-b">{{ detail.productionID  }}</td>
            <td class="px-6 py-4 border-b">{{ getProductName(detail.productID) }}</td>
            <td class="px-6 py-4 border-b">{{ detail.quantity }}</td>
            <td class="px-6 py-4 border-b">
              <span v-if="detail.status === 'Completed'" class="text-green-600">✔️{{detail.status}}</span>
              <span v-else-if="detail.status === 'Pending'" class="text-yellow-600">⚠️ {{detail.status}}</span>
              <span v-else class="text-red-600">❌ {{detail.status}}</span>
            </td>
            <td class="px-6 py-4 border-b">{{ detail.remarks }}</td>
            <td class="px-6 py-4 border-b">
              <button @click="generateMaterials(detail.productionID, detail.productID)" class="text-blue-500">Generate</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Pagination -->
      <div class="mt-4 flex justify-between">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Previous
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Next
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { apiService } from '~/api/apiService';
  import auth from '../../../../middleware/auth'
  // This page requires authentication
  definePageMeta({
    middleware: [auth],
  });
  
  import { ref, computed } from 'vue';
  
  // Sample data (replace with actual data)
  const productionDetails = ref([
    // { prodtnDetailID: 1, productionID: 101, productID: 1,  quantity: 50, status: 'Complete', remarks: 'All good' },
    // { prodtnDetailID: 2, productionID: 102, productID: 2, quantity: 30, status: 'Pending', remarks: 'Awaiting approval' },
    // Add more sample details here...
  ]);
  
  const searchQuery = ref('');
  const currentPage = ref(1);
  const itemsPerPage = 10;
  const showModal = ref(false);
  const generatedMaterials = ref([]);
  const selectedItems = ref([]); // To store selected production IDs
  const products = ref([]);
  
  // Check if any item is selected
  const anySelected = computed(() => selectedItems.value.length > 0);
  
  // Filtered production details based on search
  const filteredDetails = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
  
    if (!searchQuery.value) {
      return productionDetails.value.slice(start, end);
    }
  
    return productionDetails.value.filter(
      (detail) =>
        detail.productDetailsNo.toString().includes(searchQuery.value) ||
        detail.productionId.toString().includes(searchQuery.value) ||
        detail.remarks.toLowerCase().includes(searchQuery.value.toLowerCase())
    ).slice(start, end);
  });
  
  // Function to generate materials for a specific production ID
  const generateMaterials = async (productionID, productID) => {
  const result = await apiService.get(`/api/productionDetails/production/${productionID}`)
  const material = await apiService.get(`/api/productMaterials/materials/${productID}`)
  
  const materialData = material['product_materials']?.map((value, index)=>{
        return {
          id: index + 1,
          materialID: value.materialID,
          description: value.material.description,
          specification: value.material.specification,
          quantity: value.quantity
        }
      })
  console.log('material', material)
    generatedMaterials.value = result?.production_details?.filter((prod) => prod.productID === productID)[0]?.production_materials?.map((val, index) =>{
      const filterData = materialData[index]
      return {
        ...val,
        productMatsID: filterData?.description ?? '',
        id: index + 1
      }
    }) ?? [];
    showModal.value = true;
  };
  
  // Function to generate materials for all production IDs
  const generateAllMaterials = () => {
    generatedMaterials.value = productionDetails.value.map(
      (detail) => `Materials for Production ID ${detail.productionId}`
    );
    showModal.value = true;
  };
  
  // Function to generate materials for selected production IDs
  const generateSelectedMaterials = () => {
    generatedMaterials.value = selectedItems.value.map(
      (productionId) => `Materials for Production ID ${productionId}`
    );
    showModal.value = true;
  };
  
  // Pagination methods
  const totalPages = computed(() => Math.ceil(filteredDetails.value.length / itemsPerPage));
  const nextPage = () => {
    if (currentPage.value < totalPages.value) {
      currentPage.value++;
    }
  };
  const prevPage = () => {
    if (currentPage.value > 1) {
      currentPage.value--;
    }
  };
  
  const getProductName = (productID) => {
    const product = products.value?.find((prod) => prod.productID === productID);
    return product?.productName ?? 'Unknown';
  }
  
  const fetchProductsData = async() => {
    const result = await apiService.get("/api/products")
    products.value = result.data
  }
  
  const fetchProductionDetailsData = async() => {
    const result = await apiService.get("/api/productionDetails")
    productionDetails.value = result?.data
  }
  
  onMounted(() => {
    fetchProductsData();
    fetchProductionDetailsData();
  })
  </script>
  
  <style scoped>
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000; 
  }
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    width: 300px; 
  }
  </style>