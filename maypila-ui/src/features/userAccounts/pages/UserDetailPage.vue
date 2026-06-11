<template>
	<section class="flex
	w-full
	max-w-md
	items-center
	justify-center">
		<div class="space-y-6">
			<Card class="p-6 text-center lg:text-left">
				<!-- <p class="text-sm font-medium uppercase tracking-[0.28em] text-cyan-700"></p> -->
				<h2 class="font-heading text-3xl font-semibold tracking-tight text-slate-950 mb-1">
					Hi, {{ userAccount?.firstName ?? 'User' }} {{ userAccount?.lastName ?? '' }}
				</h2>
				<p class="text-sm leading-6 text-slate-600">
					Ensure your profile is up to date. Edit your contact information, preferences, and account details
					on this page.
				</p>
			</Card>

			<UserDetailForm :user-account="userAccount" />
		</div>
	</section>
</template>

<script setup lang="ts">
//Vue
import { computed } from 'vue'

//UI components
import Card from '@/components/ui/card/Card.vue'
import UserDetailForm from '../components/UserDetailForm.vue'

//Services
import { userAccountsService } from '../services/user-accounts.service.ts'

const userAccount = computed(() => userAccountsService.GetUser(1));


</script>
