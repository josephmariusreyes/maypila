import { companyRoutes } from '@/features/company/routes/company.routes'
import { dashboardRoutes } from '@/features/dashboard/routes/dashboard.routes'
import { queueSessionRoutes } from '@/features/queueSession/routes/queue-session.routes'
import { userAccountsRoutes } from '@/features/usersAccounts/routes/user-accounts.routes'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
	history: createWebHistory(),
	routes: [
		{
			path: '/',
			redirect: '/user-accounts/login',
		},
		userAccountsRoutes,
		companyRoutes,
		queueSessionRoutes,
		dashboardRoutes,
	],
})

export default router
