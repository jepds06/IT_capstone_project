<template>
  <div class="customer-form">
    <form @submit.prevent="submitForm">
      <input v-model="customer.name" placeholder="Name" />
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const customer = ref({ name: '' });

const submitForm = () => {
  // Handle form submission
  console.log('Submitted customer:', customer.value);
};
</script>

<style scoped>
.customer-form form {
  display: flex;
  flex-direction: column;
}
.customer-form input {
  margin-bottom: 10px;
}
</style>
