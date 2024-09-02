<template>
  <form @submit.prevent="submitForm">
    <div class="form-group">
      <label for="name">Item Name:</label>
      <input type="text" v-model="form.name" id="name" required />
    </div>
    <div class="form-group">
      <label for="quantity">Quantity:</label>
      <input type="number" v-model="form.quantity" id="quantity" required />
    </div>
    <!-- Add more fields as needed -->
    <button type="submit">Submit</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
  name: '',
  quantity: 0,
  // Add more fields as needed
});

const submitForm = () => {
  // Handle form submission
  console.log('Form submitted:', form.value);
  // You can emit an event or call an API here
};
</script>

<style scoped>
.form-group {
  margin-bottom: 15px;
}
label {
  display: block;
  margin-bottom: 5px;
}
input {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
}
button {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
