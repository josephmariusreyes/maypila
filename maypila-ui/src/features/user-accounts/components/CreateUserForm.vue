<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod'
import { ArrowRight } from '@lucide/vue'
import { useForm, Field as VeeField } from 'vee-validate'
import { z } from 'zod'
//import { RouterLink } from 'vue-router'

import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import {
	Field,
	FieldLabel,
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import type { UserAccount } from '@/features/user-accounts/types/user-accounts.types'

const props = defineProps<{
	userAccount: UserAccount | null
}>()

const onlineQueueSessionOptions = ['Morning Session', 'Afternoon Session', 'Evening Session']

const formSchema = toTypedSchema(
	z
		.object({
			firstName: z.string().min(1, 'First Name is required.'),
			lastName: z.string().min(1, 'Last Name is required.'),
			mobileNumber: z
				.string()
				.min(1, 'Mobile Number is required.')
				.regex(/^\d{10}$/, 'Mobile Number must be exactly 10 digits.'),
			email: z
				.string()
				.min(1, 'Email is required.')
				.email('Email must be a valid email address.'),
			onlineQueueSession: z.string().min(1, 'Online Queue Session is required.'),
			password: z.string().min(1, 'Password is required.'),
			confirmPassword: z.string().min(1, 'Confirm Password is required.'),
		})
		.refine((data) => data.password === data.confirmPassword, {
			message: 'Password and Confirm Password must match.',
			path: ['confirmPassword'],
		}),
)

const { handleSubmit, errors } = useForm({
	validationSchema: formSchema,
	initialValues: {
		firstName: '',
		lastName: '',
		mobileNumber: '',
		email: '',
		onlineQueueSession: '',
		password: '',
		confirmPassword: '',
	},
})

const onSubmit = handleSubmit((data) => {
	window.alert(
		JSON.stringify(
			data,
			null,
			2,
		),
	)
})
</script>

<template>
	<Card class="border-white/70 bg-white/90 shadow-xl shadow-slate-200/70 backdrop-blur">
		<CardContent class="p-6 sm:p-8">
			<!-- <div class="space-y-2">
				<h3 class="text-xl font-semibold tracking-tight text-slate-950">Create account</h3>
				<p class="text-sm text-slate-600">
					Start with the fields you need most. Validation and submission will be added later.
				</p>
			</div> -->

			<form class="space-y-5" @submit="onSubmit">
				<div class="grid gap-5 sm:grid-cols-2">
					<VeeField v-slot="{ field, errors }" name="firstName">
						<Field :data-invalid="!!errors.length">
							<FieldLabel for="register-first-name">First name</FieldLabel>
							<Input id="register-first-name" type="text" v-bind="field" autocomplete="off"
								:aria-invalid="!!errors.length" />
							<!-- <FieldError v-if="errors.length">
									{{ errors[0] }}
								</FieldError> -->
						</Field>
					</VeeField>

					<VeeField v-slot="{ field, errors }" name="lastName">
						<Field :data-invalid="!!errors.length">
							<FieldLabel for="register-last-name">Last name</FieldLabel>
							<Input id="register-last-name" type="text" v-bind="field" autocomplete="off"
								:aria-invalid="!!errors.length" />
							<!-- <FieldError v-if="errors.length">
									{{ errors[0] }}
								</FieldError> -->
						</Field>
					</VeeField>
				</div>

				<VeeField v-slot="{ field, errors }" name="mobileNumber">
					<Field :data-invalid="!!errors.length">
						<FieldLabel for="register-mobile-number">Mobile number</FieldLabel>
						<Input id="register-mobile-number" type="text" inputmode="numeric" maxlength="10" v-bind="field"
							autocomplete="off" :aria-invalid="!!errors.length" />
						<!-- <FieldError v-if="errors.length">
								{{ errors[0] }}
							</FieldError> -->
					</Field>
				</VeeField>

				<VeeField v-slot="{ field, errors }" name="email">
					<Field :data-invalid="!!errors.length">
						<FieldLabel for="register-email">Email</FieldLabel>
						<Input id="register-email" type="email" v-bind="field" autocomplete="off"
							:aria-invalid="!!errors.length" />
						<!-- <FieldError v-if="errors.length">
								{{ errors[0] }}
							</FieldError> -->
					</Field>
				</VeeField>

				<VeeField v-slot="{ field, errors }" name="onlineQueueSession">
					<Field :data-invalid="!!errors.length">
						<FieldLabel for="register-online-queue-session">Online Queue Session</FieldLabel>
						<select id="register-online-queue-session"
							class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
							v-bind="field" :aria-invalid="!!errors.length">
							<option disabled value="">Select queue session</option>
							<option v-for="session in onlineQueueSessionOptions" :key="session" :value="session">
								{{ session }}
							</option>
						</select>
						<!-- <FieldError v-if="errors.length">
								{{ errors[0] }}
							</FieldError> -->
					</Field>
				</VeeField>

				<VeeField v-slot="{ field, errors }" name="password">
					<Field :data-invalid="!!errors.length">
						<FieldLabel for="register-password">Password</FieldLabel>
						<Input id="register-password" type="password" placeholder="Create a password" v-bind="field"
							autocomplete="new-password" :aria-invalid="!!errors.length" />
						<!-- <FieldError v-if="errors.length">
								{{ errors[0] }}
							</FieldError> -->
					</Field>
				</VeeField>

				<VeeField v-slot="{ field, errors }" name="confirmPassword">
					<Field :data-invalid="!!errors.length">
						<FieldLabel for="register-confirm-password">Confirm password</FieldLabel>
						<Input id="register-confirm-password" type="password" placeholder="Repeat your password"
							v-bind="field" autocomplete="new-password" :aria-invalid="!!errors.length" />
						<!-- <FieldError v-if="errors.length">
								{{ errors[0] }}
							</FieldError> -->
					</Field>
				</VeeField>

				<Button class="w-full gap-2 main-theme-color" size="lg" type="submit">
					Create User
					<ArrowRight class="h-4 w-4" />
				</Button>
			</form>
			<div v-if="Object.keys(errors).length > 0"
				class="mt-6 rounded-2xl border border-red-100 bg-red-50/80 p-4 text-sm text-red-900">
				<p class="font-medium">Validation Errors</p>
				<ul class="mt-2 list-disc space-y-1 pl-5">
					<li v-for="(message, field) in errors" :key="field">
						{{ message }}
					</li>
				</ul>
			</div>
		</CardContent>
	</Card>
</template>
