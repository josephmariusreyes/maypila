import { client, postApiCompanies } from '@/app/api';
import type { createCompanyRequest } from '@/features/company/types/company.types';

export const companyService = {
    async createCompany(request: createCompanyRequest) {
        return postApiCompanies({
            client,
            body: request,
        })
    },
}
