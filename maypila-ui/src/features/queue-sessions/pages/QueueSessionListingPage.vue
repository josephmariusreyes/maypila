<script setup lang="ts">
// Vue
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

// UI Components
import Card from '@/components/ui/card/Card.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
	Table,
	TableBody,
	TableCell,
	TableHead,
	TableHeader,
	TableRow,
} from '@/components/ui/table'

// Services
import { queueSessionService } from '../services/queue-session.service'

// Logic
const router = useRouter()
const queueSessionList = ref<Awaited<ReturnType<typeof queueSessionService.getAllqueueSessions>> | null>(null)
const currentPage = ref(1)
const perPage = ref(5)
const hasNextPage = ref(false)
const isLoading = ref(false)

const loadQueueSessions = async () => {
	isLoading.value = true

	try {
		const result = await queueSessionService.getAllqueueSessions({
			companyId: 1, // replace with your actual company ID
			page: currentPage.value,
			perPage: perPage.value,
		})

		queueSessionList.value = result;

		// If API returns fewer records than requested,
		// we've reached the last page.
		hasNextPage.value = result.length === perPage.value
	} finally {
		isLoading.value = false
	}
}

const nextPage = async () => {
	if (!hasNextPage.value) {
		return
	}

	currentPage.value++
	await loadQueueSessions()
}

const previousPage = async () => {
	if (currentPage.value <= 1) {
		return
	}

	currentPage.value--
	await loadQueueSessions()
}

const viewDetails = () => {
	router.push({ name: 'user-details' })
}

onMounted(async () => {
	//queueSessionList.value = await queueSessionService.getAllqueueSessions()

	await loadQueueSessions();
})

// Display only first 5 users

</script>

<template>
	<section class="flex w-full max-w-4xl items-center justify-center">
		<div class="w-full space-y-4">
			<!-- Header -->
			<Card class="p-6">
				<div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
					<div>
						<h2 class="mb-1 font-heading text-3xl font-semibold tracking-tight text-slate-950">
							Queue Session Listing
						</h2>

						<p class="text-sm leading-6 text-slate-600">
							Displays all online queue sessions, including their status and details for management
							purposes.
						</p>
					</div>
				</div>

			</Card>

			<!-- User Table -->
			<Card class="p-6 overflow-hidden">
				<div class="mb-2 flex w-full gap-2 lg:w-auto">
					<Input placeholder="Search user..." class="lg:w-72" />

					<Button class="main-theme-color">
						Search
					</Button>
				</div>
				<Table>
					<TableHeader>
						<TableRow>
							<TableHead>Name</TableHead>
							<TableHead>Email</TableHead>
							<TableHead>Role</TableHead>
							<TableHead>Queue Session</TableHead>
							<TableHead class="text-right">
								Actions
							</TableHead>
						</TableRow>
					</TableHeader>

					<TableBody>
						<TableRow v-for="queueSesion in queueSessionList" :key="queueSesion.id">
							<TableCell class="font-medium">
								test
							</TableCell>

							<TableCell>
								test1
							</TableCell>

							<TableCell>
								test2
							</TableCell>

							<TableCell>
								test3
							</TableCell>

							<TableCell class="text-right">
								<Button size="sm" class="main-theme-color" @click="viewDetails">
									View Details
								</Button>
							</TableCell>
						</TableRow>
					</TableBody>
				</Table>
				<!-- Pagination -->
				<div class="mt-4 flex items-center justify-between">
					<div class="text-sm text-slate-600">
						Page {{ currentPage }}
					</div>

					<div class="flex items-center gap-2">
						<Button variant="outline" size="sm" :disabled="currentPage === 1 || isLoading"
							@click="previousPage">
							Previous
						</Button>

						<Button size="sm" class="main-theme-color" :disabled="isLoading">
							{{ currentPage }}
						</Button>

						<Button variant="outline" size="sm" :disabled="!hasNextPage || isLoading" @click="nextPage">
							Next
						</Button>
					</div>
				</div>
			</Card>
		</div>
	</section>
</template>
