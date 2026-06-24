import { companyRoutes } from '@/features/company/routes/company.routes'
import { dashboardRoutes } from '@/features/dashboard/routes/dashboard.routes'
import { queueSessionRoutes } from '@/features/queue-sessions/routes/queue-session.routes'
import { userAccountsRoutes } from '@/features/user-accounts/routes/user-accounts.routes'
import { createRouter, createWebHistory } from 'vue-router'
import { canAccessRoute } from '@/app/guards/app.guard'

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
router.beforeEach((to) => canAccessRoute(to))

export default router
