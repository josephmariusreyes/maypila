<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import AddCustomerToQueueForm from '../components/AddCustomerToQueueForm.vue';
</script>

<template>
	<section class="flex
	w-full
	max-w-md
	justify-center">
		<div class="min-w-120 max-w-130">
			<Card class="p-6 mb-6">
				<strong class="text-left text-1xl">
					Add Customer To:
				</strong>
				<strong class="text-left font-main-theme-color text-2xl">
					 {QueueName}
				</strong>
				<p class="text-sm leading-6 text-slate-600">
					{Description about the queue session goes here}
				</p>
			</Card>
			<AddCustomerToQueueForm />
		</div>
	</section>
</template>
