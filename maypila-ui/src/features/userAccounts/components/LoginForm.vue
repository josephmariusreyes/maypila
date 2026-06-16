<template>
	<Card>
		<!--
			space-y-6: adds vertical spacing between each direct child inside the card content.
			p-6: applies consistent padding on all sides of the card content.
			sm:p-8: increases that padding on small screens and up for a roomier layout.
		-->
		<CardContent class="p-6 sm:p-8 min-w-120 max-w-130">
			<div class="mb-6 flex justify-center">
				<img src="/app-logo.png" alt="Maypila logo" class="w-[65px]" />
			</div>
			<strong class="text-left font-main-theme-color text-2xl">
				AddToQueue
			</strong>
			<p class="text-sm text-slate-600">
				Customer online queue management system.
			</p>

			<form class="space-y-5 mt-6" @submit.prevent="onSubmit">
				<div class="space-y-2">
					<Label for="login-username">Username</Label>
					<Input id="login-username" v-model="username" placeholder="Enter your username" />
				</div>

				<div class="space-y-2">
					<div class="flex items-center justify-between gap-3">
						<Label for="login-password">Password</Label>
						<button type="button"
							class="text-sm font-medium text-cyan-700 transition hover:cursor-pointer hover:text-cyan-800">
							Forgot password?
						</button>
					</div>
					<Input id="login-password" v-model="password" type="password" placeholder="Enter your password" />
				</div>

				<p v-if="errorMessage" class="text-sm text-destructive">{{ errorMessage }}</p>

				<Button class="w-full gap-2 hover:cursor-pointer main-theme-color" size="lg" type="submit"
					:disabled="isLoading">
					{{ isLoading ? 'Signing in...' : 'Login' }}
					<ArrowRight class="h-4 w-4" />
				</Button>
			</form>

			<div class="rounded-2xl mt-6 border border-cyan-100 bg-cyan-50/80 p-4 text-sm text-cyan-900">
				<p class="font-medium mb-2">Try <strong>AddToQueue</strong> for free! No payment details required before signing up.</p>
				<button type="button"
					class="text-sm font-medium text-cyan-700 transition hover:cursor-pointer hover:text-cyan-800">
					Create new account.
				</button>
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

<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const username = ref('')
const password = ref('')
const isLoading = ref(false)
const errorMessage = ref('')

function resolvePostLoginRedirect(rawRedirect: unknown) {
	if (typeof rawRedirect !== 'string') {
		return { name: 'customer-listing' }
	}

	if (!rawRedirect.startsWith('/') || rawRedirect.startsWith('//')) {
		return { name: 'customer-listing' }
	}

	const resolved = router.resolve(rawRedirect)
	const isKnownRoute = resolved.matched.length > 0
	const isProtectedRoute = resolved.matched.some((record) => record.meta.requiresAuth)

	if (!isKnownRoute || !isProtectedRoute) {
		return { name: 'customer-listing' }
	}

	return resolved.fullPath
}

async function onSubmit() {



	const redirectPath = resolvePostLoginRedirect(route.query.redirect)
	await router.push(redirectPath)
}

</script>
