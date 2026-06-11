<template>
	<Card class="border-white/70 bg-white/90 shadow-xl shadow-slate-200/70 backdrop-blur">
		<CardContent class="space-y-6 p-6 sm:p-8">
			<!-- <div class="space-y-2">
				<h3 class="text-xl font-semibold tracking-tight text-slate-950">Create account</h3>
				<p class="text-sm text-slate-600">
					Start with the fields you need most. Validation and submission will be added later.
				</p>
			</div> -->

			<form class="space-y-5" @submit.prevent="handleSubmit">
				<div class="grid gap-5 sm:grid-cols-2">
					<div class="space-y-2">
						<Label for="register-first-name">First name</Label>
						<Input
							id="register-first-name"
							type="text"
							:value="form.firstName"
							@input="onInput('firstName', $event)"
						/>
					</div>
					<div class="space-y-2">
						<Label for="register-last-name">Last name</Label>
						<Input
							id="register-last-name"
							type="text"
							:value="form.lastName"
							@input="onInput('lastName', $event)"
						/>
					</div>
				</div>

				<div class="space-y-2">
					<Label for="register-mobile-number">Mobile number</Label>
					<Input
						id="register-mobile-number"
						type="text"
						inputmode="numeric"
						maxlength="10"
						:value="form.mobileNumber"
						@input="onInput('mobileNumber', $event)"
					/>
				</div>

				<div class="space-y-2">
					<Label for="register-email">Email</Label>
					<Input
						id="register-email"
						type="email"
						:value="form.email"
						@input="onInput('email', $event)"
					/>
				</div>

				<div class="space-y-2">
					<Label for="register-online-queue-session">Online Queue Session</Label>
					<select
						id="register-online-queue-session"
						class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
						:value="form.onlineQueueSession"
						@change="onSelectQueueSession"
					>
						<option disabled value="">Select queue session</option>
						<option v-for="session in onlineQueueSessionOptions" :key="session" :value="session">
							{{ session }}
						</option>
					</select>
				</div>

				<!-- <div class="grid gap-5 sm:grid-cols-2">
				</div> -->
					<div class="space-y-2">
						<Label for="register-password">Password</Label>
						<Input
							id="register-password"
							type="password"
							placeholder="Create a password"
							:value="form.password"
							@input="onInput('password', $event)"
						/>
					</div>
					<div class="space-y-2">
						<Label for="register-confirm-password">Confirm password</Label>
						<Input
							id="register-confirm-password"
							type="password"
							placeholder="Repeat your password"
							:value="form.confirmPassword"
							@input="onInput('confirmPassword', $event)"
						/>
					</div>

				<Button class="w-full gap-2 main-theme-color" size="lg" type="submit">
					Save Changes
				</Button>
			</form>
			<div class="rounded-2xl border p-4 text-sm text-cyan-900 error-messages-wrapper">
				<p class="font-medium">Validation errors</p>
				<ul v-if="errors.length" class="mt-2 list-disc space-y-1 pl-5 text-cyan-800">
					<li v-for="error in errors" :key="error">{{ error }}</li>
				</ul>
				<p v-else class="mt-1 text-cyan-800">No validation errors.</p>
			</div>
			<!-- 
			<p class="text-center text-sm text-slate-600">
				Already have an account?
				<RouterLink class="font-semibold text-cyan-700 transition hover:text-cyan-800" :to="{ name: 'auth-login' }">
					Sign in instead
				</RouterLink> 
			</p>
			-->
		</CardContent>
	</Card>
</template>

<script setup lang="ts">
import { reactive, ref, watch } from 'vue'
//import { ArrowRight } from '@lucide/vue'
//import { RouterLink } from 'vue-router'
import type { UserAccount } from '@/features/userAccounts/types/userAccount'

import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

type FormField = 'firstName' | 'lastName' | 'mobileNumber' | 'email' | 'onlineQueueSession' | 'password' | 'confirmPassword'

const props = defineProps<{
	userAccount: UserAccount | null
}>()

const onlineQueueSessionOptions = ['Morning Session', 'Afternoon Session', 'Evening Session']

const form = reactive({
	firstName: '',
	lastName: '',
	mobileNumber: '',
	email: '',
	onlineQueueSession: '',
	password: '',
	confirmPassword: '',
})

const errors = ref<string[]>([])

watch(
	() => props.userAccount,
	(value) => {
		if (!value) return

		form.firstName = value.firstName
		form.lastName = value.lastName
		form.mobileNumber = value.mobileNumber
		form.email = value.email
		form.onlineQueueSession = value.onlineQueueSession
		form.password = ''
		form.confirmPassword = ''
	},
	{ immediate: true },
)

const onInput = (field: Exclude<FormField, 'onlineQueueSession'>, event: Event) => {
	const target = event.target as HTMLInputElement
	form[field] = target.value
}

const onSelectQueueSession = (event: Event) => {
	const target = event.target as HTMLSelectElement
	form.onlineQueueSession = target.value
}

const validateForm = () => {
	const validationErrors: string[] = []

	if (!form.firstName.trim()) validationErrors.push('First Name is required.')
	if (!form.lastName.trim()) validationErrors.push('Last Name is required.')
	if (!form.mobileNumber.trim()) validationErrors.push('Mobile Number is required.')
	if (form.mobileNumber && !/^\d{10}$/.test(form.mobileNumber)) {
		validationErrors.push('Mobile Number must be exactly 10 digits.')
	}
	if (!form.email.trim()) validationErrors.push('Email is required.')
	if (form.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
		validationErrors.push('Email must be a valid email address.')
	}
	if (!form.onlineQueueSession) validationErrors.push('Online Queue Session is required.')
	if (!form.password) validationErrors.push('Password is required.')
	if (!form.confirmPassword) validationErrors.push('Confirm Password is required.')
	if (form.password && form.confirmPassword && form.password !== form.confirmPassword) {
		validationErrors.push('Password and Confirm Password must match.')
	}

	errors.value = validationErrors
	return validationErrors.length === 0
}

const handleSubmit = () => {
	if (!validateForm()) return

	window.alert(
		JSON.stringify(
			{
				firstName: form.firstName,
				lastName: form.lastName,
				mobileNumber: form.mobileNumber,
				email: form.email,
				onlineQueueSession: form.onlineQueueSession,
				password: form.password,
				confirmPassword: form.confirmPassword,
			},
			null,
			2,
		),
	)
}
</script>
