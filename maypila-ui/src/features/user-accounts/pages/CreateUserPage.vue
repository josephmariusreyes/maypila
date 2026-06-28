<script setup lang="ts">

//#region > Imports
import { toTypedSchema } from '@vee-validate/zod';
import { computed, ref } from 'vue';
import { useForm } from 'vee-validate';
import { z } from 'zod';

import Card from '@/components/ui/card/Card.vue';
import { UserRole } from '@/features/company/enums/userRoleEnums';
import { UserAccountsService } from '@/features/user-accounts/services/user-accounts.service';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store';
import type { CreateUserFormValues } from '@/features/user-accounts/types/user-accounts.types';
import CreateUserForm from '../components/CreateUserForm.vue';
import {
	Dialog,
	DialogContent,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';

//#endregion

//#region > Veevalidate forms
const formSchema = toTypedSchema(
	z
		.object({
			firstName: z.string().min(1, 'First Name is required.'),
			lastName: z.string().min(1, 'Last Name is required.'),
			mobileNumber: z
				.string()
				.min(1, 'Mobile Number is required.')
				.regex(/^09\d{9}$/, 'Mobile Number must start with 09 and be exactly 11 digits.'),
			email: z
				.string()
				.min(1, 'Email is required.')
				.email('Email must be a valid email address.'),
			role: z.enum([
				//UserRole.CompanyAdmin,
				UserRole.QueAdmin,
				UserRole.QueEncoder,
			]),
			password: z.string().min(8, 'Password must be at least 8 characters.'),
			confirmPassword: z.string().min(1, 'Confirm Password is required.'),
		})
		.refine((data) => data.password === data.confirmPassword, {
			message: 'Password and Confirm Password must match.',
			path: ['confirmPassword'],
		}),
);

const { handleSubmit, errors, setErrors, isSubmitting } = useForm<CreateUserFormValues>({
	validationSchema: formSchema,
	initialValues: {
		firstName: '',
		lastName: '',
		mobileNumber: '',
		email: '',
		role: UserRole.QueEncoder,
		password: '',
		confirmPassword: '',
	},
});
//#endregion

//#region > Component variables
const authStore = useAuthStore();
const createUserResponse = ref<unknown>(null);

const isResponseDialogOpen = ref(false);
const responseDialogMsg = ref('');

//Error dialog
const isErrorDialogOpen = ref(false);
const errorDialogMsg = ref('');

const roleOptions = [
	{
		label: 'Queue Admin',
		value: UserRole.QueAdmin,
	},
	{
		label: 'Queue Encoder',
		value: UserRole.QueEncoder,
	},
];
//#endregion

//#region > Event handlers
const onSubmit = handleSubmit(async (data) => {
	const companyId = authStore.user?.companies?.[0]?.id ?? authStore.user?.queue_session?.company_id;

	if (!companyId) {
		setErrors({
			firstName: 'Unable to create user because the current user is missing company details.',
		});
		return;
	}

	try {
		const response = await UserAccountsService.createUserAccount({
			name: `${data.firstName} ${data.lastName}`.trim(),
			email: data.email,
			password: data.password,
			mobileNumber: data.mobileNumber,
			companyId,
			role: data.role,
		});

		if (response.error) {

			isErrorDialogOpen.value = true;
			errorDialogMsg.value = getErrorMessage(response.error, 'Unable to create user account.');

			return;
		}

		createUserResponse.value = response.data ?? response;
		isResponseDialogOpen.value = true;
	} catch (error) {
		isErrorDialogOpen.value = true;
		errorDialogMsg.value = getErrorMessage(error, 'Unable to create user account.');
	}
})

const onOk = () => {

};
//#endregion

//jeph.Todo: this to helper
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
	items-center
	justify-center">
		<div class="space-y-6">
			<Card class="p-6 text-center lg:text-left">
				<!-- <p class="text-sm font-medium uppercase tracking-[0.28em] text-cyan-700"></p> -->
				<strong class="text-left font-main-theme-color text-2xl">
					Create User Account
				</strong>
				<p class="text-sm leading-6 text-slate-600">
					Set up a new staff account with permissions to manage customer status and add guests to the live
					queue.
				</p>
			</Card>

			<CreateUserForm :errors="errors" :role-options="roleOptions" :is-submitting="isSubmitting"
				:on-submit="onSubmit" />
		</div>
	</section>
	<!-- Enhance implementation of this later, make a helper for this -->
	<Dialog v-model:open="isResponseDialogOpen">
		<DialogContent class="sm:max-w-lg">
			<DialogHeader>
				<DialogTitle>Create User Response</DialogTitle>
			</DialogHeader>
			<pre
				class="max-h-96 overflow-auto rounded-md bg-slate-950 p-4 text-sm text-slate-50">{{ responseDialogMsg }}</pre>
		</DialogContent>
	</Dialog>

	<Dialog v-model:open="isErrorDialogOpen">
		<DialogContent class="sm:max-w-lg">
			<pre
				class="max-h-96 overflow-auto rounded-md bg-slate-950 p-4 text-sm text-slate-50">{{ errorDialogMsg }}</pre>
			<Button @click="">
				Ok
			</Button>
		</DialogContent>
	</Dialog>

</template>
