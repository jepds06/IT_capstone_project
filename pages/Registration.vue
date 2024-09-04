<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <Header title="Create Your SupplyEase Account" />
        <form @submit.prevent="handleRegister">
          <FormInput label="Username" id="username" type="text" v-model="username" />
          <FormInput label="Email" id="email" type="email" v-model="email" />
          <FormInput label="Password" id="password" type="password" v-model="password" />
          <div class="mb-4">
            <label for="role" class="block text-gray-700">Select Role</label>
            <select v-model="role" id="role" required class="w-full mt-1 p-2 border rounded">
              <option value="" disabled>Select your role</option>
              <option value="administrator">Administrator</option>
              <option value="supplier">Supplier</option>
              <option value="customer">Customer</option>
            </select>
          </div>
          <Button type="submit">Sign Up</Button>
        </form>
        <div class="text-center mt-4">
          <p>Already have an account? <router-link to="/sign-in" class="text-blue-600">Sign in here</router-link></p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Header from '@/components/Header.vue';
  import FormInput from '@/components/FormInput.vue';
  import Button from '@/components/Button.vue';
  
  export default {
    components: {
      Header,
      FormInput,
      Button,
    },
    data() {
      return {
        username: '',
        email: '',
        password: '',
        role: '',
      };
    },
    methods: {
      handleRegister() {
        
      },
    },
  };
  </script>
  