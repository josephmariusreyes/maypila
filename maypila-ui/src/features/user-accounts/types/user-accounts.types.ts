
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