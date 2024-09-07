<script setup lang="ts">
definePageMeta({
  layout: 'auth'
})

useSeoMeta({
  title: 'Sign up'
})

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

const validate = (state: any) => {
  const errors = []
  if (!state.email) errors.push({ path: 'email', message: 'Email is required' })
  if (!state.password) errors.push({ path: 'password', message: 'Password is required' })
  if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password)) errors.push({ path: 'password', message: 'Password must be alphanumeric between 8-32 character length' })
  if (!/^\d{11}$/.test(state.contactNumber)) errors.push({ path: 'contactNumber', message: 'Contact number must be 11 digits' })
  return errors
}

function onSubmit(data: any) {
  console.log('Submitted', data)
}
</script>

<!-- eslint-disable vue/multiline-html-element-content-newline -->
<!-- eslint-disable vue/singleline-html-element-content-newline -->
<template>
  <UCard class="max-w pl-7 text-center bg-white/75 dark:bg-white/5 backdrop-blur">
    <UAuthForm
      :fields="fields"
      :validate="validate"
      title="Create an account"
      :ui="{ base: 'text-center', footer: 'text-center' }"
      :submit-button="{ label: 'Create account' }"
      @submit="onSubmit"
    >
      <template #description>
        Already have an account? <NuxtLink
          to="/login"
          class="text-primary font-medium"
        >Login</NuxtLink>.
      </template>

      <template >
       
      </template>
    </UAuthForm>
  </UCard>
</template>
