import { $fetch } from 'ofetch';

const BASE_URL = process.env.API_BASE_URL || 'http://127.0.0.1:8000/api';

export class ApiService {
  private readonly baseUrl: string;

  constructor(baseUrl: string) {
    this.baseUrl = baseUrl;
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
    if (status !== 200 && status !== 500) {
      const message = data?.message || data?.error || 'An error occurred';
      console.log('data-----',)
      alert(message); // Show alert for errors only
    }
  }

  async get(endpoint: string, params?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint, params);
      const response = await $fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        credentials: 'include',
      });

      return response; // Return response directly for successful requests
    } catch (error) {
      console.error('API GET Error:', error);
      if (error.response) {
        this.handleError(error.response.status, error.response['_data']);
      }
      throw error;
    }
  }

  async post(endpoint: string, body?: Record<string, any>, authToken?: string) {
    try {
        const url = this.constructUrl(endpoint);
        const response = await $fetch(url, {
            method: 'POST',
            headers: authToken 
            ? {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${authToken}`
              }
            : {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body,
            credentials: 'include',
        });

        return response; // Return response directly for successful requests
    } catch (error) {
        console.error('API POST Error:', error);
        
        // Check if error contains response and then set it up for handling in the UI
        if (error.response) {
            // You can add your error handling logic here
            return {
                status: error.response.status,
                data: error.response['_data'],
            };
        }
        
        // If error is not a response, throw a general error
        throw new Error("An unexpected error occurred. Please try again.");
    }
}


  async put(endpoint: string, body?: Record<string, any>) {
    try {
      const url = this.constructUrl(endpoint);
      const response = await $fetch(url, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
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
      throw error;
    }
  }
}

export const apiService = new ApiService(BASE_URL);
