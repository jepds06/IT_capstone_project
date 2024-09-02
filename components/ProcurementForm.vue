<template>
  <div class="procurement-form">
    <form @submit.prevent="submitForm">
      <input v-model="item.name" placeholder="Item Name" />
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const item = ref({ name: '' });

const submitForm = () => {
  // Handle form submission
};
</script>

<style scoped>
.procurement-form form {
  display: flex;
  flex-direction: column;
}
.procurement-form input {
  margin-bottom: 10px;
}
</style>
