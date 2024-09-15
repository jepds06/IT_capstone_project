<script setup lang="ts">
import { apiService } from "~/api/apiService";

const route = useRoute();

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

function onSubmit(data: any) {
  console.log("Submitted", data);
  // return variable with accountype that user signing in API Call
  // const result = apiService.post('')
  const result = { accountType: 3 };

  if (result.accountType === 1) {
    navigateTo("/admin");
  } else if (result.accountType === 2) {
    navigateTo("/customer-product");
  } else {
    navigateTo("/pricing")
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
