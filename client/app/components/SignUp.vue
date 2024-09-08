<script setup lang="ts">
definePageMeta({
  layout: "auth",
});

useSeoMeta({
  title: "Sign up",
});

const userType = ref<string>(null);
const customerFields = [
  {
    name: "cstrFirstName",
    type: "text",
    label: "First Name",
    placeholder: "Enter your first name",
    attributes: "required",
  },
  {
    name: "cstrLastName",
    type: "text",
    label: "Last Name",
    placeholder: "Enter your last name",
  },
  {
    name: "contactNum",
    type: "tel",
    label: "Contact Number",
    placeholder: "Ex: 09xxxxxxxxx",
    attributes: 'required pattern="[0-9]{11}" maxlength="11"',
  },
  {
    name: "cstrAddress",
    type: "text",
    label: "Address",
    placeholder: "Enter your address",
  },
  {
    name: "customerType",
    type: "select",
    label: "Customer Type",
    placeholder: "Enter your customer type",
    options: [
      { value: "Industry", label: "Industry" },
      { value: "Individual", label: "Individual" },
    ],
  },
  {
    name: "prefContactMethod",
    type: "select",
    label: "Preferred Contact Method",
    placeholder: "Enter your Preferred Contact Method",
    options: [
      { value: "email", label: "Email" },
      { value: "phone", label: "Contact Number" },
    ],
  },
  {
    name: "username",
    type: "text",
    label: "Username",
    placeholder: "Enter your username",
  },
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
    attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
    helpText: "Password must be alphanumeric between 8-32 character length",
  },
];

const supplierFields = [
  {
    name: "supplierName",
    type: "text",
    label: "Name",
    placeholder: "Enter your name",
    attributes: "required",
  },
  {
    name: "contactNumber",
    type: "tel",
    label: "Contact Number",
    placeholder: "Ex: 09xxxxxxxxx",
    attributes: 'required pattern="[0-9]{11}" maxlength="11"',
  },
  {
    name: "supplierAddress",
    type: "text",
    label: "Address",
    placeholder: "Enter your address",
  },
  {
    name: "supplierType",
    type: "select",
    label: "Supplier Type",
    placeholder: "Enter your supplier type",
    options: [
      { value: "Industry", label: "Industry" },
      { value: "Individual", label: "Individual" },
    ],
  },
  {
    name: "username",
    type: "text",
    label: "Username",
    placeholder: "Enter your username",
  },
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
    attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
    helpText: "Password must be alphanumeric between 8-32 character length",
  },
];

const adminFields = [{
  name: 'firstName',
  type: 'text',
  label: 'First Name',
  placeholder: 'Enter your first name',
  attributes: 'required'
}, 
{
  name: 'lastName',
  type: 'text',
  label: 'Last Name',
  placeholder: 'Enter your last name'
},
{
  name: 'contactNumber',
  type: 'tel',
  label: 'Contact Number',
  placeholder: 'Ex: 09xxxxxxxxx',
  attributes: 'required pattern="[0-9]{11}" maxlength="11"'
},
{
  name: 'address',
  type: 'text',
  label: 'Address',
  placeholder: 'Enter your address'
},
{
  name: 'username',
  type: 'text',
  label: 'Username',
  placeholder: 'Enter your username'
},
{
  name: 'email',
  type: 'email',
  label: 'Email',
  placeholder: 'Enter your email'
}, {
  name: 'password',
  label: 'Password',
  type: 'password',
  placeholder: 'Enter your password',
  attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
  helpText: 'Password must be alphanumeric between 8-32 character length'
}]


const validateCustomer = (state: any) => {
  const errors = [];
  if (!state.email)
    errors.push({ path: "email", message: "Email is required" });
  if (!state.password)
    errors.push({ path: "password", message: "Password is required" });
  if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password))
    errors.push({
      path: "password",
      message: "Password must be alphanumeric between 8-32 character length",
    });
  if (!/^\d{11}$/.test(state.contactNumber))
    errors.push({
      path: "contactNumber",
      message: "Contact number must be 11 digits",
    });
  return errors;
};

function onSubmitCustomer(data: any) {
  console.log("Submitted", data);
}


const validateSupplier= (state: any) => {
  const errors = [];
  if (!state.email)
    errors.push({ path: "email", message: "Email is required" });
  if (!state.password)
    errors.push({ path: "password", message: "Password is required" });
  if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password))
    errors.push({
      path: "password",
      message: "Password must be alphanumeric between 8-32 character length",
    });
  if (!/^\d{11}$/.test(state.contactNumber))
    errors.push({
      path: "contactNumber",
      message: "Contact number must be 11 digits",
    });
  return errors;
};

function onSubmitSupplier(data: any) {
  console.log("Submitted", data);
}

const validateAdministrator = (state: any) => {
  const errors = [];
  if (!state.email)
    errors.push({ path: "email", message: "Email is required" });
  if (!state.password)
    errors.push({ path: "password", message: "Password is required" });
  if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password))
    errors.push({
      path: "password",
      message: "Password must be alphanumeric between 8-32 character length",
    });
  if (!/^\d{11}$/.test(state.contactNumber))
    errors.push({
      path: "contactNumber",
      message: "Contact number must be 11 digits",
    });
  return errors;
};

const fields = [{
  name: 'firstName',
  type: 'text',
  label: 'First Name',
  placeholder: 'Enter your first name',
  attributes: 'required'
}, 
{
  name: 'lastName',
  type: 'text',
  label: 'Last Name',
  placeholder: 'Enter your last name'
},
{
  name: 'contactNumber',
  type: 'tel',
  label: 'Contact Number',
  placeholder: 'Ex: 09xxxxxxxxx',
  attributes: 'required pattern="[0-9]{11}" maxlength="11"'
},
{
  name: 'address',
  type: 'text',
  label: 'Address',
  placeholder: 'Enter your address'
},
{
  name: 'PrefContactMethod',
  type: 'select',
  label: 'Preferred Contact Method',
  placeholder: 'Enter your Preferred Contact Method',
  options: [
    { value: 'email', label: 'Email' },
    { value: 'phone', label: 'Contact Number' },
  ]
},
{
  name: 'email',
  type: 'email',
  label: 'Email',
  placeholder: 'Enter your email'
}, {
  name: 'password',
  label: 'Password',
  type: 'password',
  placeholder: 'Enter your password',
  attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
  helpText: 'Password must be alphanumeric between 8-32 character length'
}]

function onSubmitAdministrator(data: any) {
  console.log("Submitted", data);
}
</script>

<!-- eslint-disable vue/multiline-html-element-content-newline -->
<!-- eslint-disable vue/singleline-html-element-content-newline -->
<template>
  <UCard
    class="max-w pl-7 bg-white/75 dark:bg-white/5 backdrop-blur"
  >
    <div v-if="!userType">
      <p class="p-1 m-1">Select account user type to sign up:</p>
      <USelectMenu
        clear-search-on-close
        placeholder="Select user type"
        searchable
        :options="['Administrator', 'Supplier', 'Customer']"
        v-model="userType"
      />
    </div>
    <div v-if="userType">
      <UButton
      :padded="false"
      color="gray"
      variant="link"
      icon="material-symbols:arrow-back"
      @click="userType = null"
    />
    </div>
    <div v-if="userType?.toString() === 'Customer'">
      <UAuthForm
        :fields="customerFields"
        :validate="validateCustomer"
        title="Create an account"
        :ui="{ base: 'text-center', footer: 'text-center' }"
        :submit-button="{ label: 'Create account' }"
        @submit="onSubmitCustomer"
      >
        <template #description>
          Already have an account?
          <NuxtLink to="/login" class="text-primary font-medium">Login</NuxtLink
          >.
        </template>

        <template> </template>
      </UAuthForm>
    </div>

    <div v-if="userType?.toString() === 'Supplier'">
      <UAuthForm
        :fields="supplierFields"
        :validate="validateSupplier"
        title="Create an account"
        :ui="{ base: 'text-center', footer: 'text-center' }"
        :submit-button="{ label: 'Create account' }"
        @submit="onSubmitSupplier"
      >
        <template #description>
          Already have an account?
          <NuxtLink to="/login" class="text-primary font-medium">Login</NuxtLink
          >.
        </template>

        <template> </template>
      </UAuthForm>
    </div>

    <div v-if="userType?.toString() === 'Administrator'">
      <UAuthForm
        :fields="adminFields"
        :validate="validateAdministrator"
        title="Create an account"
        :ui="{ base: 'text-center', footer: 'text-center' }"
        :submit-button="{ label: 'Create account' }"
        @submit="onSubmitAdministrator"
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
