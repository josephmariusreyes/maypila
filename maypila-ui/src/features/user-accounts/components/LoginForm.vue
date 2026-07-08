<script setup lang="ts">
import { ArrowRight } from '@lucide/vue'
import { Field as VeeField } from 'vee-validate'

import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import {
	Field,
	FieldLabel,
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'

defineProps<{
	errors: Record<string, string | undefined>
	errorMessage: string
	isLoading: boolean
}>()

const emit = defineEmits<{
	submit: [event: Event]
}>()

</script>

<template>
	<Card>
		<!--
			space-y-6: adds vertical spacing between each direct child inside the card content.
			p-6: applies consistent padding on all sides of the card content.
			sm:p-8: increases that padding on small screens and up for a roomier layout.
		-->
		<CardContent class="p-6 sm:p-8 min-w-120 max-w-130">
			<div class="mb-1 flex justify-center">
				<img src="/app-logo.png" alt="Maypila logo" class="w-[40px] mr-2" />
				<strong class="text-left font-main-theme-color text-2xl">
					AddToQueue
				</strong>
			</div>
			<p class="text-sm text-slate-600 text-center">
				Customer online queue management system.
			</p>

			<form class="space-y-5 mt-6" @submit="emit('submit', $event)">
				<VeeField v-slot="{ field, errors }" name="username">
					<Field :data-invalid="!!errors.length">
						<FieldLabel for="login-username">Username</FieldLabel>
						<Input id="login-username" v-bind="field" placeholder="Enter your username"
							autocomplete="username" :aria-invalid="!!errors.length" />
					</Field>
				</VeeField>

				<VeeField v-slot="{ field, errors }" name="password">
					<Field :data-invalid="!!errors.length">
						<div class="flex items-center justify-between gap-3">
							<FieldLabel for="login-password">Password</FieldLabel>
							<button type="button"
								class="text-sm font-medium text-cyan-700 transition hover:cursor-pointer hover:text-cyan-800">
								Forgot password?
							</button>
						</div>
						<Input id="login-password" v-bind="field" type="password" placeholder="Enter your password"
							autocomplete="current-password" :aria-invalid="!!errors.length" />
					</Field>
				</VeeField>

				<p v-if="errorMessage" class="text-sm text-destructive">{{ errorMessage }}</p>

				<Button class="w-full gap-2 hover:cursor-pointer main-theme-color" size="lg" type="submit"
					:disabled="isLoading">
					{{ isLoading ? 'Signing in...' : 'Login' }}
					<ArrowRight class="h-4 w-4" />
				</Button>
			</form>

			<div class="rounded-2xl mt-6 border border-cyan-100 bg-cyan-50/80 p-4 text-sm text-cyan-900">
				<p class="font-medium mb-2">Try <strong>AddToQueue</strong> for free! No payment details required before
					signing up.</p>
				<button type="button"
					class="text-sm font-medium text-cyan-700 transition hover:cursor-pointer hover:text-cyan-800">
					Create new account.
				</button>
			</div>

			<div v-if="Object.keys(errors).length > 0"
				class="mt-6 rounded-2xl border border-red-100 bg-red-50/80 p-4 text-sm text-red-900">
				<p class="font-medium">Validation Errors</p>
				<ul class="mt-2 list-disc space-y-1 pl-5">
					<li v-for="(message, field) in errors" :key="field">
						{{ message }}
					</li>
				</ul>
			</div>

			<!-- 
			<p class="text-center text-sm text-slate-600">
				New here?
				<RouterLink class="font-semibold text-cyan-700 transition hover:text-cyan-800" :to="{ name: 'auth-register' }">
					Create an account
				</RouterLink> 
			</p>
			-->
		</CardContent>
	</Card>
</template>
