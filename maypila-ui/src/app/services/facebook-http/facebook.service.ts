import { facebookClient } from './facebook.client';

type FacebookProfileResponse = {
  id: string;
  name?: string;
};

// Service methods should represent the Facebook endpoints your app uses.
// Add more methods here, while keeping base URL/auth/header logic in facebook.client.ts.
export const facebookService = {
  async getProfile(accessToken: string): Promise<FacebookProfileResponse> {
    return facebookClient.get<FacebookProfileResponse>('/me', {
      accessToken,
      params: {
        fields: 'id,name',
      },
    });
  },
};
