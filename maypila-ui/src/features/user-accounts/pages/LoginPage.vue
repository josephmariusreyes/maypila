<template>
	<section class="
	flex
	w-full
	max-w-l
	justify-center">
		<div class="space-y-6">
			<LoginForm :errors="errors" :error-message="errorMessage" :is-loading="isLoading" @submit="onSubmit" />
		</div>
	</section>
</template>

<script setup lang="ts">

//#region > Imports
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { z } from 'zod'

import LoginForm from '../components/LoginForm.vue';
import { UserAccountsService } from '../services/user-accounts.service';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store'
import { UserRole } from '@/features/company/enums/userRoleEnums';
//#endregion

//#region > Component variables
const route = useRoute()
const router = useRouter()
const authStore = useAuthStore();

const isLoading = ref(false)
const errorMessage = ref('')
//#endregion

//#region > Form declaration
const formSchema = toTypedSchema(
	z.object({
		username: z.string().min(1, 'Username is required.'),
		password: z.string().min(1, 'Password is required.'),
	}),
)

const { handleSubmit, errors, setErrors } = useForm({
	validationSchema: formSchema,
	initialValues: {
		username: '',
		password: '',
	},
})

//#endregion

//#region > Component methods
const onSubmit = handleSubmit(async (values) => {
	isLoading.value = true
	errorMessage.value = ''
	setErrors({})

	try {

		var response = await UserAccountsService.loginUser({
			email: values.username,
			password: values.password,
		});
		var data = response.data;

		if (!data?.success) {
			errorMessage.value = data?.message!!;
			setErrors({
				username: data?.message
			});
		}

		//JephTodo: 6/25 continue tomorrow handling the redirects
		if (authStore.hasAnyRole([UserRole.CompanyAdmin])) {

		}


	} catch (error) {

		errorMessage.value = 'Unable to login. Please try again.';
		setErrors({
			username: 'Unable to login. Please try again.',
		})
	} finally {
		isLoading.value = false
	}
})
//#endregion
</script>
