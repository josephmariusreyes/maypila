import { defineStore } from 'pinia';
import { TOKEN_STORAGE_KEY } from '@/app/constants/app.constants';
import { AUTH_RESPONSE_STORAGE_KEY } from '@/app/constants/app.constants';
import type { LoginMeta } from '@/features/user-accounts/types/user-accounts.types';

import type { PostApiLoginResponse } from '@/app/api';

export const useAuthStore = defineStore('auth', {
	state: () => ({
		authResponse: getStoredAuthResponse(),
		token: localStorage.getItem(TOKEN_STORAGE_KEY),
	}),

	getters: {
		user: (state) => state.authResponse?.data ?? null,
		roles(): string[] {
			return this.user?.roles?.map((role) => role.name).filter(isString) ?? [];
		},
		isLoggedIn(): boolean {
			return Boolean(this.token && this.user);
		},
	},

	actions: {
		setLoginResponse(response: PostApiLoginResponse) {
			this.authResponse = response

			const meta = response.meta as LoginMeta | undefined
			const tokenValue = typeof meta?.token === 'string' ? meta.token : ''

			if (tokenValue) {
				localStorage.setItem(TOKEN_STORAGE_KEY, tokenValue)
				this.token = tokenValue
			}
		},

		logout() {
			this.authResponse = null
			this.token = null
		},

		hasAnyRole(requiredRoles: string[]) {
			if (requiredRoles.length === 0) {
				return true
			}

			return this.roles.some((role) => requiredRoles.includes(role))
		},
	},
});

function getStoredAuthResponse(): PostApiLoginResponse | null {
	const storedResponse = localStorage.getItem(AUTH_RESPONSE_STORAGE_KEY)

	if (!storedResponse) {
		return null
	}

	try {
		return JSON.parse(storedResponse) as PostApiLoginResponse
	} catch {
		localStorage.removeItem(AUTH_RESPONSE_STORAGE_KEY)
		return null
	}
}

function isString(value: unknown): value is string {
	return typeof value === 'string'
}
