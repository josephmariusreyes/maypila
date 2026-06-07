import type { RouteRecordRaw } from 'vue-router'
import appMainLayout from '@/components/layouts/appMainLayout.vue'
import loginLayout from '@/components/layouts/loginLayout.vue'
import CreateUserPage from '@/features/usersAccounts/pages/CreateUserPage.vue'
import LoginPage from '@/features/usersAccounts/pages/LoginPage.vue'
import UserDetails from '@/features/usersAccounts/pages/UserDetails.vue'
import UserListing from '@/features/usersAccounts/pages/UserListing.vue'

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
			component: loginLayout,
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
