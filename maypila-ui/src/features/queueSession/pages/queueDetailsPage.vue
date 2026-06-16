<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CreateQueueSessionForm from '../components/CreateQueueSessionForm.vue';
</script>

<template>
	<section class="flex
	w-full
	max-w-md
	justify-center">
		<div>
			<Card class="p-6 mb-6">
				<!-- <p class="text-sm font-medium uppercase tracking-[0.28em] text-cyan-700"></p> -->
				<strong class="text-left font-main-theme-color text-2xl">
					Queue Details
				</strong>
				<p class="text-sm leading-6 text-slate-600">
					You may update queue session name and description on this page.
				</p>
			</Card>
			<CreateQueueSessionForm/>
		</div>
	</section>
</template>
