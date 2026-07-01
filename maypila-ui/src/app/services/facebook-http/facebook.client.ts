const FACEBOOK_GRAPH_API_URL = 'https://graph.facebook.com';

type FacebookRequestOptions = {
  accessToken: string;
  params?: Record<string, string>;
};

// Single Facebook client configuration.
// If you need another third-party API later, copy this file and change:
// 1. The base URL
// 2. The default headers
// 3. How authentication is attached
export const facebookClient = {
  async get<TResponse>(endpoint: string, options: FacebookRequestOptions): Promise<TResponse> {
    const url = new URL(endpoint, FACEBOOK_GRAPH_API_URL);

    // Keep query params here so service methods stay small and easy to read.
    Object.entries(options.params ?? {}).forEach(([key, value]) => {
      url.searchParams.set(key, value);
    });

    const response = await fetch(url, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${options.accessToken}`,
        Accept: 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`Facebook request failed with status ${response.status}`);
    }

    return response.json() as Promise<TResponse>;
  },
};
