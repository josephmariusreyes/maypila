import type { RouteRecordRaw } from 'vue-router'
import appMainLayout from '@/components/layouts/AppMainLayout.vue'
import CreateUserPage from '@/features/userAccounts/pages/CreateUserPage.vue'
import LoginPage from '@/features/userAccounts/pages/LoginPage.vue'
import UserDetails from '@/features/userAccounts/pages/UserDetails.vue'
import UserListing from '@/features/userAccounts/pages/UserListing.vue'

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
			component: appMainLayout,
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
					component: UserDetails,
				},
				{
					path: 'user-listing',
					name: 'user-listing',
					component: UserListing,
				},
				{
					path: 'create-users',
					name: 'create-users',
					component: CreateUserPage,
				},
			],
		},
	],
}
