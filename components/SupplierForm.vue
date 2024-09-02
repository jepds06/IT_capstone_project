<template>
  <form @submit.prevent="submitForm">
    <div class="form-group">
      <label for="name">Supplier Name:</label>
      <input type="text" v-model="form.name" id="name" required />
    </div>
    <div class="form-group">
      <label for="contact">Contact:</label>
      <input type="email" v-model="form.contact" id="contact" required />
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" v-model="form.address" id="address" />
    </div>
    <!-- Add more fields as needed -->
    <button type="submit">Submit Supplier</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
  name: '',
  contact: '',
  address: '',
  // Add more fields as needed
});

const submitForm = () => {
  // Handle form submission
  console.log('Supplier form submitted:', form.value);
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
