import type { RouteLocationNormalized } from 'vue-router'
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store'

export function canAccessRoute(to: RouteLocationNormalized) {
	const authStore = useAuthStore()
	const guestOnly = to.matched.some((routeRecord) => routeRecord.meta.guestOnly)

	if (guestOnly) {
		if (authStore.isLoggedIn) {
			alert('You are logged in.')
		}

		return true
	}

	const requiresAuth = to.matched.some((routeRecord) => routeRecord.meta.requiresAuth)

	if (requiresAuth && !authStore.isLoggedIn) {
		return {
			name: 'login',
			query: {
				redirect: to.fullPath,
			},
		}
	}

	const requiredRoles = to.matched.flatMap((routeRecord) => {
		const roles = routeRecord.meta.requiredRoles
		return Array.isArray(roles) ? roles.map(String) : []
	})

	if (requiredRoles.length > 0 && !authStore.hasAnyRole(requiredRoles)) {
		alert('You do not have permission to access this page.')
		return false
	}

	return true
}
