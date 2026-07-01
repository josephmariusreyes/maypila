<script setup lang="ts">

//#region > Imports
import { toTypedSchema } from '@vee-validate/zod';
import { onMounted, ref } from 'vue';
import { useForm } from 'vee-validate';
import { z } from 'zod';

import AppAlertDialog from '@/components/shared/AppAlertDialog.vue';
import Card from '@/components/ui/card/Card.vue';
import { UserRole } from '@/features/company/enums/userRoleEnums';
import { UserAccountsService } from '@/features/user-accounts/services/user-accounts.service';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store';
import type { CreateUserFormValues } from '@/features/user-accounts/types/user-accounts.types';
import CreateUserForm from '../components/CreateUserForm.vue';
import { userCreationFailed } from '@/app/constants/app.generic-error-messages.ts';

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
const appAlertDialog = ref<InstanceType<typeof AppAlertDialog> | null>(null);

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

// onMounted(() => {

// 	appAlertDialog.value?.showAlertDialog({
// 		title: 'User Successfully Created!',
// 		description: `test`,
// 		continueText: 'Ok',
// 		callback: () => {
// 			window.location.href = '/user-accounts/user-listing';
// 		},
// 	});
// });

//#region > Event handlers
const onSubmit = handleSubmit(async (data) => {

	const companyId = authStore.user?.companies?.[0]?.id ?? authStore.user?.queue_session?.company_id;

	if (!companyId) {
		appAlertDialog.value?.showAlertDialog({
			title: 'Validation Error.',
			description: `Company ID is missing, App will do a force logout.`,
			callback: () => {
				UserAccountsService.logout();
			},
		});
		return;
	}

	const fullName = `${data.firstName} ${data.lastName}`.trim();
	try {
		const response = await UserAccountsService.createUserAccount({
			name: fullName,
			email: data.email,
			password: data.password,
			mobileNumber: data.mobileNumber,
			companyId,
			role: data.role,
		});

		if (response.error) {
			throw new Error(getErrorMessage(response.error, userCreationFailed));
		}

		appAlertDialog.value?.showAlertDialog({
			title: 'User Successfully Created.',
			description: `User "${fullName}" successfully created, page will redirect to user listing.`,
			callback: () => {
				window.location.href = '/user-accounts/user-listing';
			},
		});
	} catch (error) {
		appAlertDialog.value?.showAlertDialog({
			title: 'User Creation Failed',
			description: `Our system ran into an issue during the creation of account "${fullName}", Kindly refresh page and reinput user information.`,
		});
	}
});
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
	<AppAlertDialog ref="appAlertDialog" />
</template>
