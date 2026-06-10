import type { RouteRecordRaw } from 'vue-router'
import appMainLayout from '@/components/layouts/AppMainLayout.vue'
import DashboardPage from '@/features/dashboard/pages/dashboardPage.vue'

export const dashboardRoutes: RouteRecordRaw = {
	path: '/dashboard',
	component: appMainLayout,
	meta: {
		requiresAuth: true,
	},
	children: [
		{
			path: '',
			name: 'dashboard',
			component: DashboardPage,
		},
	],
}
