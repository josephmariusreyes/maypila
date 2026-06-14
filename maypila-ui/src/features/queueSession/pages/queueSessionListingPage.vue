<template>
	<section class="flex w-full max-w-4xl items-center justify-center">
		<div class="w-full space-y-4">
			<!-- Header -->
			<Card class="p-6">
				<div
					class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between"
				>
					<div>
						<h2 class="mb-1 font-heading text-3xl font-semibold tracking-tight text-slate-950">
							Queue Session Listing
						</h2>

						<p class="text-sm leading-6 text-slate-600">
							Displays all online queue sessions, including their status and details for management purposes.
						</p>
					</div>
				</div>

			</Card>

			<!-- User Table -->
			<Card class="p-6 overflow-hidden">
				<div class="mb-2 flex w-full gap-2 lg:w-auto">
					<Input
						placeholder="Search user..."
						class="lg:w-72"
					/>

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
						<TableRow
							v-for="userAccount in displayedUsers"
							:key="userAccount.id"
						>
							<TableCell class="font-medium">
								{{ userAccount.firstName }}
								{{ userAccount.lastName }}
							</TableCell>

							<TableCell>
								{{ userAccount.email }}
							</TableCell>

							<TableCell>
								{userRole}
							</TableCell>

							<TableCell>
								{{ userAccount.onlineQueueSession }}
							</TableCell>

							<TableCell class="text-right">
								<Button
									size="sm"
									class="main-theme-color"
									@click="viewDetails"
								>
									View Details
								</Button>
							</TableCell>
						</TableRow>
					</TableBody>
				</Table>
				<!-- Pagination -->
				<!-- Jeph.Todo: This pagination can be moved to a common component -->
				<div class="flex justify-end mt-4">
					<div class="flex items-center gap-2">
						<Button variant="outline" size="sm">
							Previous
						</Button>

						<Button size="sm" class="main-theme-color">
							1
						</Button>

						<Button variant="outline" size="sm">
							2
						</Button>

						<Button variant="outline" size="sm">
							3
						</Button>

						<Button variant="outline" size="sm">
							Next
						</Button>
					</div>
				</div>
			</Card>
		</div>
	</section>
</template>

<script setup lang="ts">
// Vue
import { computed } from 'vue'
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

const userAccounts = computed(() =>
	queueSessionService.GetAllUsers()
)

// Display only first 5 users
const displayedUsers = computed(() =>
	userAccounts.value.slice(0, 5)
)

const viewDetails = () => {
	router.push({ name: 'user-details' })
}
</script>