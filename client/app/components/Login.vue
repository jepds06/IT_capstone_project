<script setup lang="ts">
import { apiService } from "~/api/apiService";
import { useAuth } from '@/composables/useAuth';

const route = useRoute();

const userTypes = ref([]);

const { setToken, logout } = useAuth();

definePageMeta({
  layout: "auth",
});

useSeoMeta({
  title: "Login",
});

const fields = [
  {
    name: "email",
    type: "email",
    label: "Email",
    placeholder: "Enter your email",
  },
  {
    name: "password",
    label: "Password",
    type: "password",
    placeholder: "Enter your password",
  },
];

const validate = (state: any) => {
  const errors = [];
  if (!state.email)
    errors.push({ path: "email", message: "Email is required" });
  if (!state.password)
    errors.push({ path: "password", message: "Password is required" });
  return errors;
};

function getUserTypeDescription(userTypeId) {
    const userType = userTypes.value.find(cat => cat.userTypeID === userTypeId);
    return userType ? userType.userTypeName?.toLowerCase() : 'Unknown';
  }

  
async function onSubmit(data: any) {
  try {
    console.log("Submitted", data);
    // return variable with accountype that user signing in API Call
    const result = await apiService.post("/api/login", data);
    setToken(result.data.token);
    localStorage.setItem('userInfo', JSON.stringify(result.data.user));
    const userType = await apiService.get("/api/userTypes");
    userTypes.value = userType.data
    
    if (getUserTypeDescription(result.data.user.userTypeID) === 'administrator') {
      navigateTo("/admin");
    } else if (getUserTypeDescription(result.data.user.userTypeID) === 'customer') {
      navigateTo("/customer-product");
    } else {
      navigateTo("/pricing")
    }
  } catch (error) {
    console.error(error);
  }
}
</script>

<!-- eslint-disable vue/multiline-html-element-content-newline -->
<!-- eslint-disable vue/singleline-html-element-content-newline -->
<template>
  <UCard class="max-w pl-7 bg-white/75 dark:bg-white/5 backdrop-blur">
    <UAuthForm
      :fields="fields"
      :validate="validate"
      title="Welcome back"
      icon="i-heroicons-lock-closed"
      :ui="{
        base: 'text-center',
        footer: 'text-center',
        default: { submitButton: { label: 'Sign in' } },
      }"
      :submit-button="{ trailingIcon: 'i-heroicons-arrow-right-20-solid' }"
      @submit="onSubmit"
    >
      <template #description>
        Don't have an account?
        <NuxtLink to="/signup" class="text-primary font-medium"
          >Sign up</NuxtLink
        >.
      </template>

      <template #password-hint>
        <NuxtLink to="/" class="text-primary font-medium"
          >Forgot password?</NuxtLink
        >
      </template>

      <template #footer> </template>
    </UAuthForm>
  </UCard>
</template>
