
import type { PostApiUsersData } from '@/app/api'
import type { UserRole } from '@/features/company/enums/userRoleEnums'

//JephNote: this is temporary
export type UserAccount = {
	id: number
	firstName: string
	lastName: string
	mobileNumber: string
	email: string
	onlineQueueSession: string
	password: string
	confirmPassword: string
	active: boolean
}

export type LoginMeta = {
	token_name?: unknown
	token?: unknown
}

//loginUser method types
export type LoginUserRequest = {
	email: string,
	password: string
}

export type createUserAccountRequest = PostApiUsersData['body']

export type CreateUserFormValues = {
	firstName: string
	lastName: string
	mobileNumber: string
	email: string
	role: createUserAccountRequest['role']
	password: string
	confirmPassword: string
}

export type RoleOption = {
	label: string
	value: UserRole
}