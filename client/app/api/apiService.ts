import { $fetch } from 'ofetch';

const BASE_URL = process.env.API_BASE_URL || 'http://127.0.0.1:8000/api';

export class ApiService {
  private readonly baseUrl: string;

  constructor(baseUrl: string) {
    this.baseUrl = baseUrl;
  }

  // Helper to get the auth token from localStorage
  private getAuthToken(): string | null {
    return localStorage.getItem('authToken');
  }

  private constructUrl(endpoint: string, params?: Record<string, any>): string {
    const normalizedBaseUrl = this.baseUrl.endsWith('/') ? this.baseUrl.slice(0, -1) : this.baseUrl;
    const normalizedEndpoint = endpoint.startsWith('/') ? endpoint.slice(1) : endpoint;
    const url = new URL(normalizedEndpoint, normalizedBaseUrl);

    if (params) {
      Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
    }

    return url.toString();
  }

  private handleError(status: number, data?: any) {
    if (status !== 200 && status !== 500 && status !== 401) {
      const message = data?.message || data?.error || 'An error occurred';
      alert(message); // Show alert for errors only
    }
  }

  async get(endpoint: string, params?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint, params);
      const authToken = this.getAuthToken();  // Retrieve the auth token from localStorage
      const response = await $fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {}),
        },
        credentials: 'include',
      });

      return response; // Return response directly for successful requests
    } catch (error) {
      console.error('API GET Error:', error);
      if (error.response) {
        this.handleError(error.response.status, error.response['_data']);
      }
       throw error.response;
    }
  }



  async post(endpoint: string, body?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint);
      const authToken = this.getAuthToken();  // Retrieve the auth token from localStorage
      const response = await $fetch(url, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {}),
        },
        body,
        credentials: 'include',
      });

      return response; // Return response directly for successful requests
    } catch (error) {
      console.error('API POST Error:', error);
      if (error.response) {
        this.handleError(error.response.status, error.response['_data']);
      }
      throw error.response;
    }
  }

  async put(endpoint: string, body?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint);
      const authToken = this.getAuthToken();  // Retrieve the auth token from localStorage
      const response = await $fetch(url, {
        method: 'PUT',
        headers: {
          'Accept': 'application/json',
          ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {}),
        },
        body,
        credentials: 'include',
      });

      return response; // Return response directly for successful requests
    } catch (error) {
      console.error('API PUT Error:', error);
      if (error.response) {
        this.handleError(error.response.status, error.response['_data']);
      }
      throw error.response;
    }
  }



  async delete(endpoint: string) {
    try {
      const url = this.constructUrl(endpoint);
      const authToken = this.getAuthToken();  // Retrieve the auth token from localStorage
      const response = await $fetch(url, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {}),
        },
        credentials: 'include',
      });

      return response; // Return response directly for successful requests
    } catch (error) {
      console.error('API DELETE Error:', error);
      if (error.response) {
        this.handleError(error.response.status, error.response['_data']);
      }
      throw error.response;
    }
  }
}

export const apiService = new ApiService(BASE_URL);
