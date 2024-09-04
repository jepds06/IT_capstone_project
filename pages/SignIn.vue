<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <Header title="Sign In to SupplyEase" />
        <form @submit.prevent="handleSignIn">
          <FormInput label="Email" id="email" type="email" v-model="email" />
          <FormInput label="Password" id="password" type="password" v-model="password" />
          <Button type="submit">Sign In</Button>
        </form>
        <div class="text-center mt-4">
          <router-link to="/forgot-password" class="text-blue-600">Forgot your password?</router-link>
        </div>
        <div class="text-center mt-4">
          <p>Don't have an account? <router-link to="/register" class="text-blue-600">Sign up here</router-link></p>
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
        email: '',
        password: '',
      };
    },
    methods: {
      handleSignIn() {
        
      },
    },
  };
  </script>
  