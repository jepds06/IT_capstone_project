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

const state = reactive({
  email: undefined,
  password: undefined
})

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

async function onSubmit(form: any) {
    errorMessage.value = ""; // Reset error message before submission

    try {
        console.log("Submitted", form.data);
        
        // Login API call
        const result = await apiService.post("/api/login", form.data);

        setToken(result.data.token);
        // Check if the result is an error response
        console.log(result.status)
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
            navigateTo("/supplier");
        }
    } catch (error) {
      console.log('Error:', error);
        console.error(error); // Log the error for debugging
        errorMessage.value =  error?.['_data']?.message || "An unexpected error occurred. Please try again."; // Fallback error message
    }
}
</script>

<template>
  <UCard class="max-w  pb-8 backdrop-blur ">

      <div class="text-2xl font-bold text-center">
        <UIcon name="uim:padlock" />
        
      </div>
      <UForm :validate="validate" :state="state" class="space-y-4 " @submit="onSubmit">
        <h1 class="text-2xl font-bold text-center mb-6">Welcome back 
        </h1>
        <UFormGroup label="Email" name="email"  class="">
          <UInput v-model="state.email" placeholder="you@example.com" icon="i-heroicons-envelope"/>
        </UFormGroup>
        
        <UFormGroup label="Password" name="password">
          <UInput v-model="state.password" type="password"  icon="uim:padlock" />
        </UFormGroup>
        
        <UButton type="submit" label="Sign In" trailing icon="material-symbols:arrow-right-alt" block />
        <p v-if="errorMessage" class="text-red-500 text-center">{{ errorMessage }}</p> <!-- Display error message here -->
      </UForm>
      <!-- <template #footer> -->
        <!-- </template> -->
      <!-- </UAuthForm> -->
  </UCard>
</template>
