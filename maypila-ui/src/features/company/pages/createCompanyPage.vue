<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { z } from 'zod';

import Card from '@/components/ui/card/Card.vue';
import { companyService } from '@/features/company/services/company.service';
import CreateCompanyForm from '../component/CreateCompanyForm.vue';

type CreateCompanyFormValues = {
    companyName: string
    companyDescription: string
    companyEmail: string
}

const createCompanyResponse = ref<unknown>(null);
const isResponseDialogOpen = ref(false);

const formSchema = toTypedSchema(
    z.object({
        companyName: z.string().min(1, 'Company name is required'),
        companyDescription: z.string().min(1, 'Company description is required'),
        companyEmail: z
            .string()
            .min(1, 'Company email is required')
            .email('Please enter a valid email address'),
    }),
)

const { handleSubmit, errors, setErrors, isSubmitting } = useForm<CreateCompanyFormValues>({
    validationSchema: formSchema,
    initialValues: {
        companyName: '',
        companyDescription: '',
        companyEmail: '',
    },
})

const onSubmit = handleSubmit(async (data) => {
    try {
        const response = await companyService.createCompany({
            name: data.companyName,
            description: data.companyDescription,
            company_email: data.companyEmail,
        })

        if (response.error) {
            setErrors({
                companyName: getErrorMessage(response.error, 'Unable to create company.'),
            })
            return
        }

        createCompanyResponse.value = response.data ?? response
        isResponseDialogOpen.value = true
    } catch (error) {
        setErrors({
            companyName: getErrorMessage(error, 'Unable to create company.'),
        })
    }
})

function getErrorMessage(error: unknown, fallbackMessage: string) {
    if (error && typeof error === 'object' && 'message' in error && typeof error.message === 'string') {
        return error.message
    }

    return fallbackMessage
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
                </strong>
                <strong class="text-left font-main-theme-color text-2xl">
                    Create Account.
                </strong>
                <p class="text-sm leading-6 text-slate-600">
                    After submitting sign up form <strong>AddToQueue</strong> will send an email for your login credentials.
                </p>
            </Card>
            <CreateCompanyForm
                v-model:response-dialog-open="isResponseDialogOpen"
                :errors="errors"
                :is-submitting="isSubmitting"
                :submit-response="createCompanyResponse"
                :on-submit="onSubmit"
            />
        </div>
    </section>
</template>
