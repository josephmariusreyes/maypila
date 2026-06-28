import type { RouteRecordRaw } from 'vue-router'
import appMainLayout from '@/components/layouts/AppMainLayout.vue'
import CreateUserPage from '@/features/user-accounts/pages/CreateUserPage.vue'
import LoginPage from '@/features/user-accounts/pages/LoginPage.vue'
import UserDetailPage from '../pages/UserDetailPage.vue'
import UserListingPage from '../pages/UserListingPage.vue'
import PublicLayout from '@/components/layouts/PublicLayout.vue';
import { UserRole } from '@/features/company/enums/userRoleEnums.ts'

export const userAccountsRoutes: RouteRecordRaw = {
	path: '/user-accounts',
	children: [
		//public routes
		{
			path: '',
			redirect: {
				name: 'login',
			},
		},
		{
			path: '',
			component: PublicLayout,
			meta: {
				guestOnly: true
			},
			children: [
				{
					path: 'login',
					name: 'login',
					component: LoginPage,
				},
			],
		},
		//logged in routes
		{
			path: '',
			component: appMainLayout,
			meta: {
				requiresAuth: true,
			},
			children: [
				{
					path: 'user-details',
					name: 'user-details',
					meta: {
						requiredRoles: [UserRole.CompanyAdmin, UserRole.QueAdmin, UserRole.QueEncoder],
					},
					component: UserDetailPage,
				},
				{
					path: 'user-listing',
					name: 'user-listing',
					meta: {
						requiredRoles: [UserRole.CompanyAdmin],
					},
					component: UserListingPage,
				},
				{
					path: 'create-users',
					name: 'create-users',
					meta: {
						requiredRoles: [UserRole.CompanyAdmin],
					},
					component: CreateUserPage,
				},
			],
		},
	],
}
