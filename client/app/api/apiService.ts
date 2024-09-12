// services/apiService.ts

import { $fetch } from 'ofetch';

const BASE_URL = process.env.API_BASE_URL || 'http://127.0.0.1:8000/api'; // Base URL including /api

export class ApiService {
  private readonly baseUrl: string;

  constructor(baseUrl: string) {
    this.baseUrl = baseUrl;
  }

  private constructUrl(endpoint: string, params?: Record<string, any>): string {
    // Ensure the endpoint does not start with a slash if baseUrl ends with /api
    const normalizedBaseUrl = this.baseUrl.endsWith('/') ? this.baseUrl.slice(0, -1) : this.baseUrl;
    const normalizedEndpoint = endpoint.startsWith('/') ? endpoint.slice(1) : endpoint;
    const url = new URL(normalizedEndpoint, normalizedBaseUrl);

    if (params) {
      Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
    }

    return url.toString();
  }

  async get(endpoint: string, params?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint, params);
      return await $fetch(url, { method: 'GET' });
    } catch (error) {
      console.error('API GET Error:', error);
      throw error;
    }
  }

  async post(endpoint: string, body?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint);
      return await $fetch(url, {
        method: 'POST',
        body,
      });
    } catch (error) {
      console.error('API POST Error:', error);
      throw error;
    }
  }

  // Add more methods if needed (put, delete, etc.)
}

export const apiService = new ApiService(BASE_URL);
