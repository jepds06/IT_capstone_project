<script setup lang="ts">
import { ref } from 'vue';
import { navigateTo } from 'nuxt/app';
import { apiService } from '~/api/apiService';
import { useAuth } from '@/composables/useAuth';

const userTypes = ref([]);
const modules = ref([]);
const errorMessage = ref(""); // To hold error messages

const { setToken } = useAuth();

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

  // Check if email is provided
  if (!state.email) {
    errors.push({ path: "email", message: "Email is required" });
  } else if (!/\S+@\S+\.\S+/.test(state.email)) {
    // Validate email format
    errors.push({ path: "email", message: "Please enter a valid email address" });
  }

  // Check if password is provided
  if (!state.password) {
    errors.push({ path: "password", message: "Password is required" });
  } else if (state.password.length < 6) {
    // Validate password length
    errors.push({ path: "password", message: "Password must be at least 6 characters long" });
  }

  return errors;
};

function getUserTypeDescription(userTypeId: number) {
  const userType = userTypes.value.find(cat => cat.userTypeID === userTypeId);
  return userType ? userType.userTypeName : 'Unknown';
}

function getModuleName(moduleID) {
  const module = modules?.value?.find((mod) => mod.moduleID === moduleID);
  return module ? module.moduleName : "Unknown";
}

async function onSubmit(data: any) {
    errorMessage.value = ""; // Reset error message before submission

    try {
        console.log("Submitted", data);
        
        // Login API call
        const result = await apiService.post("/api/login", data);

        setToken(result.data.token);
        // Check if the result is an error response
        if (result.status && result.data) {
            errorMessage.value = result.data.message || "An unexpected error occurred.";
            return; // Exit the function after setting the error message
        }

        // Proceed with user type fetching and navigation if successful
        const userType = await apiService.get("/api/userTypes");
        userTypes.value = userType.data;
        
        const userTypeDescription = getUserTypeDescription(result.data.user.userTypeID);
        
        localStorage.setItem('userInfo', JSON.stringify({...result.data.user, userTypeDescription}));

        const listModules = await apiService.get("/api/modules");
        modules.value = listModules.data;

        const permission = await apiService.get("/api/userPrivilage");
        const transformData = permission.data?.filter((per) => per.userID ===  result.data.user.userID).map((per) => {
            return {
                ...per,
                moduleName: getModuleName(per.moduleID)
            }
        });

        localStorage.setItem('userPermission', JSON.stringify(transformData));

        if (userTypeDescription === 'Administrator') {
            navigateTo("/admin");
        } else if (userTypeDescription === 'Customer') {
            navigateTo("/customer-product");
        } else {
            navigateTo("/supplier/quotations");
        }
    } catch (error) {
        console.error(error); // Log the error for debugging
        errorMessage.value = "An unexpected error occurred. Please try again."; // Fallback error message
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
      <template #footer>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p> <!-- Display error message here -->
      </template>
    </UAuthForm>
  </UCard>
</template>
