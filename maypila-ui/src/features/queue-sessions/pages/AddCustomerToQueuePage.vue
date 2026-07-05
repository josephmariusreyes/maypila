<script setup lang="ts">

//#region > Imports
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { onMounted, ref } from 'vue';
import { z } from 'zod';

import AppAlertDialog from '@/components/shared/AppAlertDialog.vue';
import Card from '@/components/ui/card/Card.vue';

import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store';
import { queueSessionService } from '@/features/queue-sessions/services/queue-session.service';
import type { AddCustomerToQueueFormValues } from '@/features/queue-sessions/types/queue-session.types';
import AddCustomerToQueueForm from '../components/AddCustomerToQueueForm.vue';
import { getErrorMessage } from '@/lib/utils.ts';
import { UserAccountsService } from '@/features/user-accounts/services/user-accounts.service.ts';

const authStore = useAuthStore();
const appAlertDialog = ref<InstanceType<typeof AppAlertDialog> | null>(null);
//#endregion

//#region > Veevalidate forms
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
//#endregion

//#region > Const component variables
const queue_session_name = ref('');

const onSubmit = handleSubmit(async () => {
	const userId = authStore.user?.id;
	const queueSessionId = authStore.user?.queue_session_id;
	const companyId = authStore.user?.companies?.[0]?.id ?? authStore.user?.queue_session?.company_id;

	if (!userId || !queueSessionId || !companyId) {
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

	} catch (error) {
		appAlertDialog.value?.showAlertDialog({
			title: `Adding Customer To "${queue_session_name}" Failed`,
			description: `Our system ran into an issue while adding customer to queue "${queue_session_name}", Kindly refresh page and reinput user information.`,
		});
	}
})
//#endregion

//#region > Functions
//#endregion

//#region > on mounted life cycle
onMounted(() => {
	const queue_session_id = authStore.user?.queue_session_id;

	if (queue_session_id) {
		queue_session_name.value = authStore.user.queue_session?.name ?? '';
	} else {
		appAlertDialog.value?.showAlertDialog({
			title: 'Your account is not part of any online queue session.',
			description: `Kindly reach to application administrator to associate a queue session for your account your account will be logged out temporarily.`,
			callback: () => {
				UserAccountsService.logout();
			}
		});
	}
});
//#endregion

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


	<AppAlertDialog ref="appAlertDialog" />
</template>
