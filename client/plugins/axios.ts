import axios from 'axios';
import type { NuxtApp } from '#app';

export default defineNuxtPlugin((nuxtApp: NuxtApp) => {
  const axiosInstance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api', // Your Laravel API base URL
  });

  nuxtApp.provide('axios', axiosInstance);

  console.log('axiosRegister');
  
});