<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900">
      <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Sign In</h2>
        <form @submit.prevent="handleSubmit">
          <FormInput id="email" type="email" label="Email" v-model="email" />
          <FormInput id="password" type="password" label="Password" v-model="password" />
          <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
        </form>
        <p class="mt-4 text-gray-700 dark:text-gray-300">
          Don't have an account? <router-link to="/register" class="text-blue-500">Register</router-link>
        </p>
      </div>
    </div>
  </template>
  
  <script>
  import FormInput from '@/components/FormInput.vue';
  
  export default {
    components: {
      FormInput
    },
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      handleSubmit() {
        console.log('Logged in with', this.email, this.password);
      }
    }
  };
  </script>
  