<template>
	<section
	class="flex
	w-full
	max-w-md
	items-center
	justify-center"
	>
		<div class="space-y-6">
			<Card class="p-6 text-center lg:text-left">
				<!-- <p class="text-sm font-medium uppercase tracking-[0.28em] text-cyan-700"></p> -->
				<h2 class="font-heading text-3xl font-semibold tracking-tight text-slate-950 mb-1">
					Create User Account
				</h2>
				<p class="text-sm leading-6 text-slate-600">
					Set up a new staff account with permissions to manage customer status and add guests to the live queue.
				</p> 
			</Card>

			<CreateUserForm />
		</div>
	</section>
</template>

<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CreateUserForm from '../components/CreateUserForm.vue';
</script>
