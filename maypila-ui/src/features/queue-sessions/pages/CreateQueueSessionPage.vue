<script setup lang="ts">

//#region > Imports
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { z } from 'zod';
import AppAlertDialog from '@/components/shared/AppAlertDialog.vue';

import Card from '@/components/ui/card/Card.vue';
import { queueSessionService } from '@/features/queue-sessions/services/queue-session.service';
import type { CreateQueueSessionFormValues } from '@/features/queue-sessions/types/queue-session.types';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store';
import CreateQueueSessionForm from '../components/CreateQueueSessionForm.vue';
import { getErrorMessage } from '@/lib/utils.ts';
import { queueCreationFaiiled } from '@/app/constants/app.generic-error-messages.ts';
//#endregion

//#region > Veevalidate forms
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
//#endregion

//#region > Const component variables

const authStore = useAuthStore();
const appAlertDialog = ref<InstanceType<typeof AppAlertDialog> | null>(null);

//#endregion

//#region > Event handlers

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
			throw new Error(queueCreationFaiiled);
		}

	} catch (error) {
		appAlertDialog.value?.showAlertDialog({
			title: 'Queue Session Creation Failed.',
			description: `${getErrorMessage(error)}`,
		});
	}
});

const onAddQueueUser = async (event: MouseEvent) => {

};

const onRemoveQueueUser = async (event: MouseEvent) => {

};

const onShowAddQueueUser = async () => {

}

//#endregion
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
					Set up a queue in seconds. Choose a name, customize your settings, and start managing customer flow
					instantly.
				</p>
			</Card>
			<CreateQueueSessionForm :errors="errors" :is-submitting="isSubmitting" :on-submit="onSubmit"
				:on-show-add-queue-user="onShowAddQueueUser" />
		</div>
	</section>
</template>
