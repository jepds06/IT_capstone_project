<template>
  <form @submit.prevent="submitForm">
    <div class="form-group">
      <label for="customerName">Customer Name:</label>
      <input type="text" v-model="form.customerName" id="customerName" required />
    </div>
    <div class="form-group">
      <label for="totalAmount">Total Amount:</label>
      <input type="number" v-model="form.totalAmount" id="totalAmount" required />
    </div>
    <!-- Add more fields as needed -->
    <button type="submit">Submit Order</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
  customerName: '',
  totalAmount: 0.0,
  // Add more fields as needed
});

const submitForm = () => {
  // Handle form submission
  console.log('Order submitted:', form.value);
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
