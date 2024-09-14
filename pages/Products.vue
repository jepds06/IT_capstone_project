<template>
  <div class="p-6">
    <!-- Title and Add Button -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Products</h1>
      <button @click="openModal('add')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add Product
      </button>
    </div>

    <!-- Add/Edit Product Modal -->
    <div v-if="isModalVisible" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close Button -->
        <button @click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
          <i class="fas fa-times"></i>
        </button>
        <h2 class="text-lg font-semibold mb-4">{{ formMode === 'add' ? 'Add Product' : 'Edit Product' }}</h2>
        <form @submit.prevent="saveProduct">
          <div class="mb-4">
            <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
            <input v-model="form.id" type="text" id="id" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" :readonly="formMode === 'edit'"/>
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700">Product Category</label>
            <select v-model="form.prodCat" id="prodCat" class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.description }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input v-model="form.name" type="text" id="name" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700">Specs</label>
            <textarea v-model="form.specs" id="specs" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"></textarea>
          </div>
          <div class="mb-4">
            <label for="unitPrice" class="block text-sm font-medium text-gray-700">Unit Price</label>
            <input v-model="form.unitPrice" type="number" id="unitPrice" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
          </div>
          <div class="flex justify-end">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
              Save
            </button>
            <button @click="closeModal" class="ml-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Product Info Modal -->
    <div v-if="isProductInfoVisible" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative">
        <!-- Close Button -->
        <button @click="closeProductInfo" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
          <i class="fas fa-times"></i>
        </button>
        <h2 class="text-lg font-semibold mb-4">Product Materials</h2>
        <div class="mb-4">
          <table class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2 border-b text-center">Material Id</th>
                <th class="p-2 border-b text-center">Name</th>
                <th class="p-2 border-b text-center">Specs</th>
                <th class="p-2 border-b text-center">Qty.</th>
                <th class="p-2 border-b text-center">Status</th>
                <th class="p-2 border-b text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="material in selectedProductMaterials" :key="material.id">
                <td class="p-2 border-b text-center">{{ material.id }}</td>
                <td class="p-2 border-b text-center">{{ material.name }}</td>
                <td class="p-2 border-b text-center">{{ material.specs }}</td>
                <td class="p-2 border-b text-center">{{ material.qty }}</td>
                <td class="p-2 border-b text-center">
                  <i :class="material.status === 'active' ? 'fas fa-check text-green-500' : 'fas fa-times text-red-500'"></i>
                </td>
                <td class="p-2 border-b text-center flex justify-center space-x-2">
                  <!-- Placeholder for actions, e.g., edit or delete material -->
                  <button @click="editMaterial(material)" class="text-yellow-500 hover:underline">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button @click="removeMaterial(material)" class="text-red-500 hover:underline">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <button @click="openMaterialModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Add Material
        </button>
      </div>
    </div>

    <!-- Add/Edit Material Modal -->
    <div v-if="isMaterialModalVisible" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close Button -->
        <button @click="closeMaterialModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
          <i class="fas fa-times"></i>
        </button>
        <h2 class="text-lg font-semibold mb-4">{{ materialMode === 'add' ? 'Add Material' : 'Edit Material' }}</h2>
        <form @submit.prevent="saveMaterial">
          <div class="mb-4">
            <label for="materialId" class="block text-sm font-medium text-gray-700">Material Id</label>
            <input v-model="materialForm.id" type="text" id="materialId" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" :readonly="materialMode === 'edit'"/>
          </div>
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input v-model="materialForm.name" type="text" id="name" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700">Specs</label>
            <textarea v-model="materialForm.specs" id="specs" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"></textarea>
          </div>
          <div class="mb-4">
            <label for="qty" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input v-model="materialForm.qty" type="number" id="qty" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
          </div>
          <div class="flex justify-end">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
              Save
            </button>
            <button @click="closeMaterialModal" class="ml-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Products Table -->
    <table class="min-w-full border border-gray-300 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2 border-b text-center">Id</th>
          <th class="p-2 border-b text-center">Name</th>
          <th class="p-2 border-b text-center">Specs</th>
          <th class="p-2 border-b text-center">Unit Price</th>
          <th class="p-2 border-b text-center">Category</th>
          <th class="p-2 border-b text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td class="p-2 border-b text-center">{{ product.id }}</td>
          <td class="p-2 border-b text-center">{{ product.name }}</td>
          <td class="p-2 border-b text-center">{{ product.specs }}</td>
          <td class="p-2 border-b text-center">{{ product.unitPrice | currency }}</td>
          <td class="p-2 border-b text-center">{{ getCategoryDescription(product.prodCat) }}</td>
          <td class="p-2 border-b text-center flex justify-center space-x-2">
            <button @click="viewProduct(product)" class="text-blue-500 hover:underline">
              <i class="fas fa-eye"></i>
            </button>
            <button @click="openModal('edit', product)" class="text-yellow-500 hover:underline">
              <i class="fas fa-edit"></i>
            </button>
            <button @click="showMaterials(product)" class="text-green-500 hover:underline">
              <i class="fas fa-cogs"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const products = ref([]);
const categories = ref([
  // Example categories, replace with real data from your Product Categories
  { id: '1', description: 'Chair' },
  { id: '2', description: 'Table' }
]);

const isModalVisible = ref(false);
const formMode = ref('add'); // 'add' or 'edit'
const form = ref({
  id: '',
  prodCat: '',
  name: '',
  specs: '',
  unitPrice: ''
});

const isProductInfoVisible = ref(false);
const selectedProductMaterials = ref([]);
const selectedProduct = ref(null);

const isMaterialModalVisible = ref(false);
const materialMode = ref('add'); // 'add' or 'edit'
const materialForm = ref({
  id: '',
  name: '',
  specs: '',
  qty: ''
});

function openModal(mode = 'add', product = null) {
  formMode.value = mode;
  if (mode === 'edit' && product) {
    form.value = { ...product };
  } else {
    form.value = { id: '', prodCat: '', name: '', specs: '', unitPrice: '' };
  }
  isModalVisible.value = true;
}

function closeModal() {
  isModalVisible.value = false;
}

function saveProduct() {
  if (formMode.value === 'add') {
    products.value.push({ ...form.value });
  } else if (formMode.value === 'edit') {
    const index = products.value.findIndex(prod => prod.id === form.value.id);
    if (index !== -1) {
      products.value[index] = { ...form.value };
    }
  }
  closeModal();
}

function viewProduct(product) {
  alert(`Viewing product: ${product.name}`);
}

function showMaterials(product) {
  selectedProduct.value = product;
  // Simulating fetching materials for the selected product
  selectedProductMaterials.value = [
    { id: '1', name: 'Wood', specs: 'Oak', qty: 10, status: 'active' },
    { id: '2', name: 'Metal', specs: 'Aluminum', qty: 5, status: 'inactive' }
  ];
  isProductInfoVisible.value = true;
}

function closeProductInfo() {
  isProductInfoVisible.value = false;
}

function openMaterialModal() {
  materialMode.value = 'add';
  materialForm.value = { id: '', name: '', specs: '', qty: '' };
  isMaterialModalVisible.value = true;
}

function closeMaterialModal() {
  isMaterialModalVisible.value = false;
}

function saveMaterial() {
  if (materialMode.value === 'add') {
    selectedProductMaterials.value.push({ ...materialForm.value, status: 'inactive' });
  } else if (materialMode.value === 'edit') {
    const index = selectedProductMaterials.value.findIndex(mat => mat.id === materialForm.value.id);
    if (index !== -1) {
      selectedProductMaterials.value[index] = { ...materialForm.value };
    }
  }
  closeMaterialModal();
}

function editMaterial(material) {
  materialMode.value = 'edit';
  materialForm.value = { ...material };
  isMaterialModalVisible.value = true;
}

function removeMaterial(material) {
  selectedProductMaterials.value = selectedProductMaterials.value.filter(mat => mat.id !== material.id);
}

function getCategoryDescription(categoryId) {
  const category = categories.value.find(cat => cat.id === categoryId);
  return category ? category.description : 'Unknown';
}
</script>

<style scoped>
/* Add any additional styling here */
</style>
