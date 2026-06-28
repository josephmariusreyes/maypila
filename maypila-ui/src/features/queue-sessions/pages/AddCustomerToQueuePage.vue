<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { computed, ref } from 'vue';
import { z } from 'zod';

import Card from '@/components/ui/card/Card.vue';
import {
	Dialog,
	DialogContent,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store';
import { queueSessionService } from '@/features/queue-sessions/services/queue-session.service';
import type { AddCustomerToQueueFormValues } from '@/features/queue-sessions/types/queue-session.types';
import AddCustomerToQueueForm from '../components/AddCustomerToQueueForm.vue';

const authStore = useAuthStore();
const addCustomerResponse = ref<unknown>(null);
const isResponseDialogOpen = ref(false);
const formattedSubmitResponse = computed(() => JSON.stringify(addCustomerResponse.value, null, 2));

const formSchema = toTypedSchema(
	z.object({
		firstName: z
			.string()
			.min(1, 'Firstname is required'),
		lastName: z
			.string()
			.min(1, 'Lastname is required'),
		phoneNumber: z
			.string()
			.min(10, 'Please enter a valid 10 digit number')
	}),
)

const { handleSubmit, errors, setErrors, isSubmitting } = useForm<AddCustomerToQueueFormValues>({
	validationSchema: formSchema,
	initialValues: {
		firstName: '',
		lastName: '',
		phoneNumber: ''
	},
})

const onSubmit = handleSubmit(async () => {
	const userId = authStore.user?.id;
	const queueSessionId = authStore.user?.queue_session_id;
	const companyId = authStore.user?.companies?.[0]?.id ?? authStore.user?.queue_session?.company_id;

	if (!userId || !queueSessionId || !companyId) {
		setErrors({
			firstName: 'Unable to add customer because the current user is missing queue session details.',
		});
		return;
	}

	try {
		const response = await queueSessionService.addCustomerToQueue({
			userId,
			queueSessionId,
			companyId,
		});

		if (response.error) {
			setErrors({
				firstName: getErrorMessage(response.error),
			});
			return;
		}

		addCustomerResponse.value = response.data ?? response;
		isResponseDialogOpen.value = true;
	} catch (error) {
		setErrors({
			firstName: error instanceof Error ? error.message : 'Unable to add customer to queue.',
		});
	}
})

function getErrorMessage(error: unknown) {
	if (error && typeof error === 'object' && 'message' in error && typeof error.message === 'string') {
		return error.message;
	}

	return 'Unable to add customer to queue.';
}
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
			<AddCustomerToQueueForm :errors="errors" :is-submitting="isSubmitting" :on-submit="onSubmit" />
		</div>
	</section>

	<Dialog v-model:open="isResponseDialogOpen">
		<DialogContent class="sm:max-w-lg">
			<DialogHeader>
				<DialogTitle>Add Customer Response</DialogTitle>
			</DialogHeader>
			<pre
				class="max-h-96 overflow-auto rounded-md bg-slate-950 p-4 text-sm text-slate-50">{{ formattedSubmitResponse }}</pre>
		</DialogContent>
	</Dialog>
</template>
