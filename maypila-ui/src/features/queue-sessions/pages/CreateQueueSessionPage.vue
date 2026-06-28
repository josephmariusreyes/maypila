<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { z } from 'zod';

import Card from '@/components/ui/card/Card.vue';
import { queueSessionService } from '@/features/queue-sessions/services/queue-session.service';
import type { CreateQueueSessionFormValues } from '@/features/queue-sessions/types/queue-session.types';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store';
import CreateQueueSessionForm from '../components/CreateQueueSessionForm.vue';

const authStore = useAuthStore();
const createQueueSessionResponse = ref<unknown>(null);
const isResponseDialogOpen = ref(false);

const formSchema = toTypedSchema(
	z.object({
		queueSessionName: z
			.string()
			.min(1, 'Queue session name is required'),
		queueDescription: z
			.string()
			.min(1, 'Description is required')
			.max(100, 'Description must be at most 100 characters.'),
	}),
)

const { handleSubmit, errors, setErrors, isSubmitting } = useForm<CreateQueueSessionFormValues>({
	validationSchema: formSchema,
	initialValues: {
		queueSessionName: '',
		queueDescription: ''
	},
})

const onSubmit = handleSubmit(async (data) => {
	const companyId = authStore.user?.companies?.[0]?.id ?? authStore.user?.queue_session?.company_id;

	if (!companyId) {
		setErrors({
			queueSessionName: 'Unable to create queue session because the current user is missing company details.',
		});
		return;
	}

	try {
		const response = await queueSessionService.createQueueSession({
			name: data.queueSessionName,
			description: data.queueDescription,
			companyId,
		});

		if (response.error) {
			setErrors({
				queueSessionName: getErrorMessage(response.error, 'Unable to create queue session.'),
			});
			return;
		}

		createQueueSessionResponse.value = response.data ?? response;
		isResponseDialogOpen.value = true;
	} catch (error) {
		setErrors({
			queueSessionName: getErrorMessage(error, 'Unable to create queue session.'),
		});
	}
})

function getErrorMessage(error: unknown, fallbackMessage: string) {
	if (error && typeof error === 'object' && 'message' in error && typeof error.message === 'string') {
		return error.message;
	}

	return fallbackMessage;
}
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
					Create Queue Session
				</strong>
				<p class="text-sm leading-6 text-slate-600">
					Set up a queue in seconds. Choose a name, customize your settings, and start managing customer flow instantly.
				</p>
			</Card>
			<CreateQueueSessionForm
				v-model:response-dialog-open="isResponseDialogOpen"
				:errors="errors"
				:is-submitting="isSubmitting"
				:submit-response="createQueueSessionResponse"
				:on-submit="onSubmit"
			/>
		</div>
	</section>
</template>
