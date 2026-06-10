import type { RouteRecordRaw } from 'vue-router'
import appMainLayout from '@/components/layouts/AppMainLayout.vue';
import CreateCompanyPage from '@/features/company/pages/createCompanyPage.vue';
import { UserRole } from '@/features/company/enums/userRoleEnums';

export const companyRoutes: RouteRecordRaw = {
    path:'/company',
    component:appMainLayout,
    meta:{
		requiresAuth: true,
    },
    children:[
        {
            path:'',
            redirect:{
                name:'create-company'
            }
        },
        {
            path:'create-company',
            name:'create-company',
			meta: {
                requiredRoles: [UserRole.SuperAdmin],
			},
            component:CreateCompanyPage
        }
    ]
}