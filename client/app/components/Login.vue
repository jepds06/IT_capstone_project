<script setup lang="ts">
import { ref } from 'vue';
import { navigateTo } from 'nuxt/app';
import { apiService } from '~/api/apiService';
import { useAuth } from '@/composables/useAuth';

const userTypes = ref([]);
const modules = ref([]);

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
  if (!state.email) errors.push({ path: "email", message: "Email is required" });
  if (!state.password) errors.push({ path: "password", message: "Password is required" });
  return errors;
};

function getUserTypeDescription(userTypeId: number) {
  const userType = userTypes.value.find(cat => cat.userTypeID === userTypeId);
  return userType ? userType.userTypeName?.toLowerCase() : 'Unknown';
}

function getModuleName(moduleID) {
      const module = modules?.value?.find((mod) => mod.moduleID === moduleID);
      return module ? module.moduleName : "Unknown";
  }

async function onSubmit(data: any) {
  try {
    console.log("Submitted", data);
    
    // Login API call
    const result = await apiService.post("/api/login", data);

     // Fetch user types
     const userType = await apiService.get("/api/userTypes");
    userTypes.value = userType.data;
    
    // Navigate based on user type
    const userTypeDescription = getUserTypeDescription(result.data.user.userTypeID);
    
    // Set token in Vuex and localStorage
    setToken(result.data.token);
    localStorage.setItem('userInfo', JSON.stringify({...result.data.user, userTypeDescription}));

    const listModules = await apiService.get("/api/modules");

    modules.value = listModules.data;

    // User Permission API Call
    const permission = await apiService.get("/api/userPrivilage");

    const transformData = permission.data?.filter((per) => per.userID ===  result.data.user.userID).map((per) => {
      return {
        ...per,
        moduleName: getModuleName(per.moduleID)
      }
    })
    // Dispatch setPermission to Vuex store
    localStorage.setItem('userPermission', JSON.stringify(transformData));

    if (userTypeDescription === 'administrator') {
      navigateTo("/admin");
    } else if (userTypeDescription === 'customer') {
      navigateTo("/customer-product");
    } else {
      navigateTo("/pricing");
    }
  } catch (error) {
    console.error(error);
  }
}
</script>

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
        <NuxtLink to="/signup" class="text-primary font-medium">Sign up</NuxtLink>.
      </template>
      <template #password-hint>
        <NuxtLink to="/" class="text-primary font-medium">Forgot password?</NuxtLink>
      </template>
      <template #footer></template>
    </UAuthForm>
  </UCard>
</template>
