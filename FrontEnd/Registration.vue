<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 shadow-md rounded-lg">
      <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Register</h2>
      <form @submit.prevent="handleSubmit">
        <FormInput id="name" label="Username" v-model="name" />
        <FormInput id="email" type="email" label="Email" v-model="email" />
        <FormInput id="password" type="password" label="Password" v-model="password" />
        <FormInput id="confirmPassword" type="password" label="Confirm Password" v-model="confirmPassword" />
        <FormSelect id="role" label="Select Role" v-model="role" />
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Register</button>
      </form>
      <p class="mt-4 text-gray-700 dark:text-gray-300">
        Already have an account? <router-link to="/login" class="text-blue-500">Sign In</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import FormInput from '@/components/FormInput.vue';
import FormSelect from '@/components/FormSelect.vue';

export default {
  components: {
    FormInput,
    FormSelect
  },
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      role: ''
    };
  },
  methods: {
    handleSubmit() {
      console.log('Registered with', this.name, this.email, this.password, this.role);
    }
  }
};
</script>
