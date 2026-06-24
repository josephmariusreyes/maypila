<template>
	<section class="flex
	w-full
	max-w-md
	items-center
	justify-center">
		<div class="w-full max-w-[550px] space-y-6">
			<Card class="p-6">
				<Card class="p-6 text-center tracking-tight">
					<h2 class="mb-1 font-heading text-4xl font-semibold  text-slate-950">
						Your Queue Number
					</h2>

					<Card class="mt-3 inline-flex p-3 text-4xl font-bold bg-green-600 border-2 border-black text-white">
						56
					</Card>
				</Card>

				<Card class="mt-6 p-6 text-center tracking-tight">
					<h2 class="mb-4 font-heading text-2xl font-semibold  text-slate-950">
						Currently Serving
					</h2>

					<div class="grid grid-cols-5 gap-4">
						<div v-for="queueNumber in currentlyServing" :key="queueNumber">
							<Card class="flex  justify-center p-3 text-2xl font-bold bg-amber-300 border-2 border-black text-black">
								{{ queueNumber }}
							</Card>
						</div>
					</div>
				</Card>

				<div class="mt-6">
					<p class="text-sm font-medium text-slate-700">
						Estimated waiting time:
						<span class="font-semibold text-slate-950">
							15 - 20 minutes
						</span>
					</p>

					<p class="mt-2 text-sm leading-relaxed text-slate-600">
						Please keep this page open while waiting. We will send you a
						notification when your queue number is about to be called and when
						you may proceed to the assigned counter.
					</p>
				</div>
			</Card>
		</div>
	</section>
</template>

<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue'

const currentlyServing = [21, 22, 23, 24, 25, 26, 27, 28, 29, 30]
</script>