<template>
	<div class="space-y-6">
		<Card class="p-6 text-center lg:text-left">
			<!-- <p class="text-sm font-medium uppercase tracking-[0.28em] text-cyan-700"></p> -->
			<h2 class="font-heading text-3xl font-semibold tracking-tight text-slate-950 mb-1">
				Login
			</h2>
			<p class="text-sm leading-6 text-slate-600">
				Access your dashboard to manage the live queue and update customer status.
			</p> 
		</Card>

		<LoginForm />
	</div>
</template>

<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import LoginForm from '../components/LoginForm.vue';
</script>
