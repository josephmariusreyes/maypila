<template>
	<section class="flex
	w-full
	max-w-md
	items-center
	justify-center">
		<div class="space-y-6">
			<Card class="p-6 text-center lg:text-left">
				<!-- <p class="text-sm font-medium uppercase tracking-[0.28em] text-cyan-700"></p> -->
				<strong class="text-left font-main-theme-color text-2xl">
					Hi, {{ userAccount?.firstName ?? 'User' }} {{ userAccount?.lastName ?? '' }}
				</strong>
				<p class="text-sm leading-6 text-slate-600">
					Ensure your profile is up to date. Edit your contact information, preferences, and account details
					on this page.
				</p>
			</Card>

			<!-- <CreateUserForm :userAccount="null" /> -->
		</div>
	</section>
</template>

<script setup lang="ts">
//Vue
import { computed } from 'vue'

//UI components
import Card from '@/components/ui/card/Card.vue'
// import CreateUserForm from '../components/CreateUserForm.vue';

//Services
import { UserAccountsService } from '../services/user-accounts.service.ts'

const userAccount = computed(() => UserAccountsService.getUser(1));


</script>
