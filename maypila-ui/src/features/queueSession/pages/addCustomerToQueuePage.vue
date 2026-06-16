<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import AddCustomerToQueueForm from '../components/AddCustomerToQueueForm.vue';
</script>

<template>
	<section class="flex
	w-full
	max-w-md
	justify-center">
		<div>
			<Card class="p-6 mb-6">
				<strong class="text-left font-main-theme-color text-2xl">
					Add Customer To, {QueueName}
				</strong>
				<p class="text-sm leading-6 text-slate-600">
					Input customer Firstname, Lastname and Cellphone number to add then in queue.
				</p>
			</Card>
			<AddCustomerToQueueForm />
		</div>
	</section>
</template>
