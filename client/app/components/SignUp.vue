<script setup lang="ts">
import { useNuxtApp } from "#app";
import { ref, defineProps } from "vue";
import { apiService } from "../api/apiService";
import { adminFields, customerFields, supplierFields, validateAdministrator, validateCustomer, validateSupplier } from "../constant/signup";

definePageMeta({
  layout: "auth",
});

useSeoMeta({
  title: "Sign up",
});

const emit = defineEmits<{
  (event: "close-modal"): void;
}>();

const close = () => {
  emit("close-modal");
};

const userType = ref<number>(null);

async function onSubmit(data: any) {
  console.log("Submitted", data);
  try {
    const payload = { ...data, accTypeID: userType.value };
    // Call the get method from ApiService
    const result = await apiService.post("/api/account/register", payload); // Replace '/endpoint' with your actual API endpoint
    alert("Sign up successfully!");
    close();
  } catch (error) {
    console.error("Error fetching data:", error);
  }
}

// Define a reactive data property
const acountType = ref(null);

// Define an async function to fetch data
const fetchData = async () => {
  try {
    // Call the get method from ApiService
    const { data } = await apiService.get("/api/accountTypes"); // Replace '/endpoint' with your actual API endpoint
    acountType.value = data.map((type) => {
      return {
        value: type.accTypeID,
        label: type.accountTypeName,
      };
    });
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

// Optionally, you can call fetchData on component mount
fetchData();
</script>

<!-- eslint-disable vue/multiline-html-element-content-newline -->
<!-- eslint-disable vue/singleline-html-element-content-newline -->
<template>
  <UCard class="max-w pl-7 bg-white/75 dark:bg-white/5 backdrop-blur">
    <div v-if="!userType">
      <div class="flex items-center justify-between p-0 m-0">
        <h3
          class="text-base font-semibold leading-6 text-gray-900 dark:text-white"
        ></h3>
        <UButton
          color="gray"
          variant="ghost"
          icon="i-heroicons-x-mark-20-solid"
          class="-my-1"
          @click="close"
        />
      </div>
      <p class="p-1 m-1">Select account user type to sign up:</p>
      <USelectMenu
        clear-search-on-close
        placeholder="Select user type"
        searchable
        :options="acountType"
        @change="(e) => (userType = e.value)"
      />
    </div>
    
  <div style="display: flex; justify-content: flex-end; padding: 10px;">
    <div v-if="userType">
      <UButton
        :padded="false"
        color="gray"
        variant="link"
        icon="material-symbols:arrow-back"
        @click="userType = null"
      />
      <UButton
        color="gray"
        variant="ghost"
        icon="i-heroicons-x-mark-20-solid"
        @click="close"
        :ui="{inline: 'justifiy-end'}"
      />
    </div>
  </div>

    <div v-if="userType === 1">
      <UAuthForm
        :fields="adminFields"
        :validate="validateAdministrator"
        title="Create an account"
        :ui="{ base: 'text-center', footer: 'text-center' }"
        :submit-button="{ label: 'Create account' }"
        @submit="onSubmit"
      >
        <template #description>
          Already have an account?
          <NuxtLink to="/login" class="text-primary font-medium">Login</NuxtLink
          >.
        </template>
      </UAuthForm>
    </div>
    
    <div v-if="userType === 2">
      <UAuthForm
        :fields="customerFields"
        :validate="validateCustomer"
        title="Create an account"
        :ui="{ base: 'text-center', footer: 'text-center' }"
        :submit-button="{ label: 'Create account' }"
        @submit="onSubmit"
      >
        <template #description>
          Already have an account?
          <NuxtLink to="/login" class="text-primary font-medium">Login</NuxtLink
          >.
        </template>

        <template> </template>
      </UAuthForm>
    </div>

    <div v-if="userType === 3">
      <UAuthForm
        :fields="supplierFields"
        :validate="validateSupplier"
        title="Create an account"
        :ui="{ base: 'text-center', footer: 'text-center' }"
        :submit-button="{ label: 'Create account' }"
        @submit="onSubmit"
      >
        <template #description>
          Already have an account?
          <NuxtLink to="/login" class="text-primary font-medium">Login</NuxtLink
          >.
        </template>

        <template> </template>
      </UAuthForm>
    </div>
  </UCard>
</template>
