import type { UserAccount } from '@/features/user-accounts/types/user-accounts.types';
import type { LoginUserRequest } from '@/features/user-accounts/types/user-accounts.types';
import { client, postApiLogin } from '@/app/api';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store'
import type { LoginMeta } from '@/features/user-accounts/types/user-accounts.types';

import { TOKEN_STORAGE_KEY } from '@/app/constants/app.constants';
import { AUTH_RESPONSE_STORAGE_KEY } from '@/app/constants/app.constants';
import { TOKEN_NAME_STORAGE_KEY } from '@/app/constants/app.constants';

//JephNote: This is temporary code will remove this later on once API is integrated
const createStaticUsers = (): UserAccount[] => [
	{
		id: 1,
		firstName: 'Juan',
		lastName: 'Dela Cruz',
		mobileNumber: '0912345678',
		email: 'juan.delacruz@example.com',
		onlineQueueSession: 'Morning Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 2,
		firstName: 'Maria',
		lastName: 'Santos',
		mobileNumber: '0912345679',
		email: 'maria.santos@example.com',
		onlineQueueSession: 'Afternoon Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 3,
		firstName: 'Jose',
		lastName: 'Reyes',
		mobileNumber: '0912345680',
		email: 'jose.reyes@example.com',
		onlineQueueSession: 'Evening Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 4,
		firstName: 'Ana',
		lastName: 'Garcia',
		mobileNumber: '0912345681',
		email: 'ana.garcia@example.com',
		onlineQueueSession: 'Morning Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 5,
		firstName: 'Luis',
		lastName: 'Torres',
		mobileNumber: '0912345682',
		email: 'luis.torres@example.com',
		onlineQueueSession: 'Afternoon Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 6,
		firstName: 'Carla',
		lastName: 'Flores',
		mobileNumber: '0912345683',
		email: 'carla.flores@example.com',
		onlineQueueSession: 'Evening Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 7,
		firstName: 'Miguel',
		lastName: 'Navarro',
		mobileNumber: '0912345684',
		email: 'miguel.navarro@example.com',
		onlineQueueSession: 'Morning Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 8,
		firstName: 'Liza',
		lastName: 'Mendoza',
		mobileNumber: '0912345685',
		email: 'liza.mendoza@example.com',
		onlineQueueSession: 'Afternoon Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 9,
		firstName: 'Paolo',
		lastName: 'Castillo',
		mobileNumber: '0912345686',
		email: 'paolo.castillo@example.com',
		onlineQueueSession: 'Evening Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
	{
		id: 10,
		firstName: 'Nina',
		lastName: 'Aquino',
		mobileNumber: '0912345687',
		email: 'nina.aquino@example.com',
		onlineQueueSession: 'Morning Session',
		password: 'Password123',
		confirmPassword: 'Password123',
		active: true,
	},
]

//Local types

export const UserAccountsService = {

	getUser(id: number): UserAccount | null {
		const users = createStaticUsers()
		return users.find((user) => user.id === id) ?? null
	},

	getAllUsers(): UserAccount[] {
		return createStaticUsers()
	},

	updateUser(user: UserAccount): UserAccount {
		window.alert(`UpdateUser payload: ${JSON.stringify(user, null, 2)}`)
		return user
	},

	deleteUser(id: number): UserAccount | null {
		const users = createStaticUsers()
		const user = users.find((item) => item.id === id)

		if (!user) {
			window.alert(`DeleteUser: user with id ${id} not found.`)
			return null
		}

		const updatedUser = {
			...user,
			active: false,
		}

		window.alert(`DeleteUser result: ${JSON.stringify(updatedUser, null, 2)}`)
		return updatedUser
	},

	async loginUser(request: LoginUserRequest) {
		const authStore = useAuthStore()

		const response = await postApiLogin({
			client,
			body: {
				email: request.email,
				password: request.password,
			},
		})
		const resData = response.data;

		if (resData?.success) {
			authStore.setLoginResponse(resData);

			const meta = resData.meta as LoginMeta | undefined;
			const tokenValue = typeof meta?.token === 'string' ? meta.token : '';
			const tokenName = typeof meta?.token_name === 'string' ? meta.token_name : '';
			localStorage.setItem(AUTH_RESPONSE_STORAGE_KEY, JSON.stringify(resData));

			if (tokenValue) {
				localStorage.setItem(TOKEN_STORAGE_KEY, tokenValue)
			}

			if (tokenName) {
				localStorage.setItem(TOKEN_NAME_STORAGE_KEY, tokenName)
			}
		}

		return response;
	},

	logout() {
		const authStore = useAuthStore()
		authStore.logout();

		localStorage.removeItem(AUTH_RESPONSE_STORAGE_KEY)
		localStorage.removeItem(TOKEN_STORAGE_KEY)
		localStorage.removeItem(TOKEN_NAME_STORAGE_KEY)
	}
}

//JephNote: Commenting these code that is generated by codex i dont like this

// type ApiValidationErrors = Record<string, string | string[]>

// export class LoginError extends Error {
// 	errors: Record<string, string>

// 	constructor(message: string, errors: Record<string, string> = {}) {
// 		super(message)
// 		this.name = 'LoginError'
// 		this.errors = errors
// 	}
// }

// function createLoginError(error: unknown) {
// 	const fallbackMessage = 'Login failed.'
// 	if (!isObject(error)) {
// 		return new LoginError(fallbackMessage, { username: fallbackMessage })
// 	}

// 	const message = typeof error.message === 'string' ? error.message : fallbackMessage
// 	const apiErrors = isObject(error.errors) ? normalizeApiErrors(error.errors as ApiValidationErrors) : {}
// 	return new LoginError(message, Object.keys(apiErrors).length > 0 ? apiErrors : { username: message })
// }

// function normalizeApiErrors(errors: ApiValidationErrors) {
// 	return Object.entries(errors).reduce<Record<string, string>>((result, [field, message]) => {
// 		const formField = field === 'email' ? 'username' : field
// 		result[formField] = Array.isArray(message) ? message[0] : message
// 		return result
// 	}, {})
// }

// function isObject(value: unknown): value is Record<string, unknown> {
// 	return typeof value === 'object' && value !== null
// }
