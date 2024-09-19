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
        <h2 class="text-lg text-black font-semibold mb-4">{{ formMode === 'add' ? 'Add Product' : 'Edit Product' }}</h2>
        <form @submit.prevent="saveProduct">
          <div class="mb-4" v-if="formMode === 'edit'">
            <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
            <input v-model="form.productID" type="text" id="id" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" :readonly="formMode === 'edit'"/>
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700">Product Category</label>
            <select v-model="form.prodCatID" id="prodCat" class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
              <option v-for="category in categories" :key="category.prodCatID" :value="category.prodCatID">
                {{ category.description }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input v-model="form.productName" type="text" id="name" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700">Specifications</label>
            <textarea v-model="form.specifications" id="specs" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"></textarea>
          </div>
          <div class="mb-4">
            <label for="unitPrice" class="block text-sm font-medium text-gray-700">Unit Price</label>
            <input @change="(e) => e.target.value ? parseFloat(e.target.value) : null" v-model="form.unitPrice" id="unitPrice" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
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
        <h2 class="text-lg text-black font-semibold mb-4">Product Materials</h2>
        <!-- Product Info View Table (Read-Only) -->
        <table class="min-w-full border border-gray-300 rounded-lg mb-4">
          <thead class="bg-gray-200">
            <tr>
              <th class="p-2 border-b text-center">Product ID</th>
              <th class="p-2 border-b text-center">Name</th>
              <th class="p-2 border-b text-center">Specification</th>
              <th class="p-2 border-b text-center">Unit Price</th>
              <th class="p-2 border-b text-center">Category</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="p-2 border-b text-center">{{ selectedProduct?.productID }}</td>
              <td class="p-2 border-b text-center">{{ selectedProduct?.productName }}</td>
              <td class="p-2 border-b text-center">{{ selectedProduct?.specifications }}</td>
              <td class="p-2 border-b text-center">{{ selectedProduct?.unitPrice }}</td>
              <td class="p-2 border-b text-center">{{ getCategoryDescription(selectedProduct?.prodCatID) }}</td>
            </tr>
          </tbody>
        </table>
        <div class="mb-4">
          <table class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2 border-b text-black text-center">Material Id</th>
                <th class="p-2 border-b text-black text-center">Name</th>
                <th class="p-2 border-b text-black text-center">Specs</th>
                <th class="p-2 border-b text-black text-center">Qty.</th>
                <th class="p-2 border-b text-black text-center">Actions</th>
              </tr>
            </thead>
            <tbody v-if="selectedProductMaterials.length > 0">
              <tr v-for="material in selectedProductMaterials" :key="material.materialID">
                <td class="p-2 border-b text-black text-center">{{ material.materialID }}</td>
                <td class="p-2 border-b text-black text-center">{{ material.description }}</td>
                <td class="p-2 border-b text-black text-center">{{ material.specification }}</td>
                <td class="p-2 border-b text-black text-center">{{ material.quantity }}</td>
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
          <div class="mb-4" v-if="materialMode === 'edit'">
            <label for="materialId" class="block text-sm font-medium text-gray-700">Product Material Id</label>
            <input v-model="materialForm.productMatsID" type="text" id="productMatsID" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" :readonly="materialMode === 'edit'"/>
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700">Material</label>
            <select v-model="materialForm.materialID" id="prodCat" class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
              <option v-for="material in materials" :key="material.materialID" :value="material.materialID">
                {{ material.description }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input v-model="materialForm.quantity" type="text" id="quantity" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
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

    <!-- Products Table with Pagination -->
    <table class="min-w-full border border-gray-300 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2 border-b text-black text-center">Product ID</th>
          <th class="p-2 border-b text-black text-center">Name</th>
          <th class="p-2 border-b text-black text-center">Specification</th>
          <th class="p-2 border-b text-black text-center">Unit Price</th>
          <th class="p-2 border-b text-black text-center">Category</th>
          <th class="p-2 border-b text-black text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in paginatedProducts" :key="product.productID" @click="viewProduct(product)" class="cursor-pointer hover:bg-gray-100">
          <td class="p-2 border-b text-black text-center">{{ product.productID }}</td>
          <td class="p-2 border-b text-black text-center">{{ product.productName }}</td>
          <td class="p-2 border-b text-black text-center">{{ product.specifications }}</td>
          <td class="p-2 border-b text-black text-center">{{ product.unitPrice }}</td>
          <td class="p-2 border-b text-black text-center">{{ getCategoryDescription(product.prodCatID) }}</td>
          <td class="p-2 border-b text-center flex justify-center space-x-2">
            <button @click.stop="openModal('edit', product)" class="text-yellow-500 hover:underline">
              <i class="fas fa-edit"></i>
            </button>
            <button @click.stop="deleteProduct(product)" class="text-red-500 hover:underline">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="mt-4 flex justify-between items-center">
      <button @click="previousPage" :disabled="currentPage === 1" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
        Next
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isModalVisible: false,
      isProductInfoVisible: false,
      isMaterialModalVisible: false,
      formMode: 'add',
      materialMode: 'add',
      currentPage: 1,
      itemsPerPage: 10,
      form: {
        productID: '',
        prodCatID: '',
        productName: '',
        specifications: '',
        unitPrice: '',
      },
      materialForm: {
        productMatsID: '',
        materialID: '',
        quantity: '',
      },
      categories: [], // Categories for product selection
      materials: [], // Materials for selection in the Add/Edit Material Modal
      products: [], // Full list of products
      selectedProduct: null,
      selectedProductMaterials: [], // Materials related to the selected product
    };
  },
  computed: {
    paginatedProducts() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.products.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.products.length / this.itemsPerPage);
    },
  },
  methods: {
    openModal(mode, product = null) {
      this.formMode = mode;
      this.form = product ? { ...product } : {
        productID: '',
        prodCatID: '',
        productName: '',
        specifications: '',
        unitPrice: '',
      };
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    saveProduct() {
      if (this.formMode === 'add') {
        this.products.push({ ...this.form });
      } else {
        const index = this.products.findIndex(p => p.productID === this.form.productID);
        if (index !== -1) {
          this.products[index] = { ...this.form };
        }
      }
      this.closeModal();
    },
    deleteProduct(product) {
      const index = this.products.indexOf(product);
      if (index !== -1) {
        this.products.splice(index, 1);
      }
    },
    viewProduct(product) {
      this.selectedProduct = product;
      this.selectedProductMaterials = []; // Fetch materials related to the selected product
      this.isProductInfoVisible = true;
    },
    closeProductInfo() {
      this.isProductInfoVisible = false;
    },
    openMaterialModal() {
      this.materialMode = 'add';
      this.materialForm = {
        productMatsID: '',
        materialID: '',
        quantity: '',
      };
      this.isMaterialModalVisible = true;
    },
    closeMaterialModal() {
      this.isMaterialModalVisible = false;
    },
    saveMaterial() {
      if (this.materialMode === 'add') {
        // Add new material to the selected product
        this.selectedProductMaterials.push({ ...this.materialForm });
      } else {
        // Update existing material
        const index = this.selectedProductMaterials.findIndex(m => m.productMatsID === this.materialForm.productMatsID);
        if (index !== -1) {
          this.selectedProductMaterials[index] = { ...this.materialForm };
        }
      }
      this.closeMaterialModal();
    },
    editMaterial(material) {
      this.materialMode = 'edit';
      this.materialForm = { ...material };
      this.isMaterialModalVisible = true;
    },
    removeMaterial(material) {
      const index = this.selectedProductMaterials.indexOf(material);
      if (index !== -1) {
        this.selectedProductMaterials.splice(index, 1);
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    getCategoryDescription(catID) {
      const category = this.categories.find(c => c.prodCatID === catID);
      return category ? category.description : '';
    },
  },
  mounted() {
    // Initialize your products and categories here
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
