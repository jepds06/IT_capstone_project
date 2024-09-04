<template>
    <NuxtLink to="/dashboard">
        CLICK ME
    </NuxtLink>
    <button class="bg-blue-500 ml-10 rounded-xl shadow-lg" @click="navigate">CLICKME 2</button>
    <NuxtLink to="/inventory">
    </NuxtLink>
    <NuxtLink to="/orders">
    </NuxtLink>
    <NuxtLink to="/quotations"> 
    </NuxtLink> 
    <NuxtLink to="/SignIn"> 
    </NuxtLink> 
    <NuxtLink to="/Registration"> 
    </NuxtLink> 

</template>

 <script setup>
import { useRouter } from 'vue-router'

const route = useRouter();

route.push('/dashboard');

</script>

<style></style>

