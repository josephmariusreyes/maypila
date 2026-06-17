<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod'
import { useForm, Field as VeeField } from 'vee-validate'
import { h } from 'vue'
import { toast } from 'vue-sonner'
import { z } from 'zod'
import { Checkbox } from '@/components/ui/checkbox'
import { ref } from 'vue'
import { ArrowRight } from '@lucide/vue'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import {
    Field,
    FieldDescription,
    FieldLabel
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import {
    InputGroup,
    InputGroupAddon,
    InputGroupTextarea,
    InputGroupText,
} from '@/components/ui/input-group'

const formSchema = toTypedSchema(
    z.object({
        companyName: z
            .string()
            .min(1, 'Company name is required'),
        companyDescription: z
            .string()
            .min(1, 'Company description is required'),
        companyEmail: z
            .string()
            .email('Please enter a valid email address')
            .min(10, 'Please enter a valid 10 digit number')
    }),
)

const { handleSubmit, errors } = useForm({
    validationSchema: formSchema,
    initialValues: {
        companyName: '',
        companyDescription: '',
        companyEmail: ''
    },
})

const accepted = ref(false);
const onSubmit = handleSubmit((data) => {
    toast('You submitted the following values:', {
        description: h('pre', { class: 'bg-code text-code-foreground mt-2 w-[320px] overflow-x-auto rounded-md p-4' }, h('code', JSON.stringify(data, null, 2))),
        position: 'bottom-right',
        class: 'flex flex-col gap-2',
        style: {
            '--border-radius': 'calc(var(--radius)  + 4px)',
        },
    })
})
</script>

<template>
    <Card class="w-full">
        <CardContent class="mt-6">
            <form class="space-y-5" @submit="onSubmit">
                <VeeField v-slot="{ field, errors }" name="companyName">
                    <Field :data-invalid="!!errors.length">
                        <FieldLabel for="company-input">
                            Company
                        </FieldLabel>
                        <Input id="company-input" v-bind="field" autocomplete="off" :aria-invalid="!!errors.length" />
                    </Field>
                </VeeField>

                <VeeField v-slot="{ field, errors }" name="companyDescription">
                    <Field :data-invalid="!!errors.length">
                        <FieldLabel for="company-description-textarea">
                            Description
                        </FieldLabel>
                        <InputGroup>
                            <InputGroupTextarea id="queue-description-textarea" v-bind="field" placeholder="" :rows="6"
                                class="min-h-24 resize-none" :aria-invalid="!!errors.length" />
                            <InputGroupAddon align="block-end">
                                <InputGroupText class="tabular-nums">
                                    {{ field.value?.length || 0 }}/100 characters
                                    <br />
                                </InputGroupText>
                            </InputGroupAddon>
                        </InputGroup>
                        <FieldDescription>
                            Provide a short description of your business and what you do.
                        </FieldDescription>
                    </Field>
                </VeeField>

                <VeeField v-slot="{ field, errors }" name="companyEmail">
                    <Field :data-invalid="!!errors.length">
                        <FieldLabel for="company-email">Email</FieldLabel>
                        <Input id="company-email" type="email" v-bind="field" autocomplete="off"
                            :aria-invalid="!!errors.length" />
                        <!-- <FieldError v-if="errors.length">
								{{ errors[0] }}
							</FieldError> -->
                        <FieldDescription>
                            We will send your credentials in this email address.
                        </FieldDescription>
                    </Field>
                </VeeField>
                <div class="rounded-2xl mt-6 border border-cyan-100 bg-cyan-50/80 p-4 text-sm text-cyan-900">
                    <div class="flex items-center gap-3">
                        <Checkbox id="terms" v-model="accepted" />
                        <Label for="terms">Accept terms and conditions</Label>
                    </div>
                    <div class="mt-3 max-h-30 overflow-y-auto text-xs pr-2">
                        <p class="mb-2"><strong>Terms and Conditions</strong></p>
                        <p class="mb-2">
                            By using this service, you agree to the following terms and conditions:
                        </p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>You must be at least 18 years old to use this service.</li>
                            <li>You agree to provide accurate and complete information.</li>
                            <li>You are responsible for maintaining the confidentiality of your account.</li>
                            <li>You agree not to use this service for any illegal or unauthorized purpose.</li>
                            <li>We reserve the right to terminate accounts that violate these terms.</li>
                            <li>Your data will be handled according to our privacy policy.</li>
                            <li>We may update these terms from time to time.</li>
                            <li>You agree to indemnify us against any claims arising from your use.</li>
                            <li>This service is provided "as is" without any warranties.</li>
                            <li>We are not liable for any damages resulting from the use of this service.</li>
                        </ul>
                        <p class="mt-2 text-xs text-cyan-700">
                            Last updated: January 2026
                        </p>
                    </div>
                </div>
                <Button class="w-full gap-2 main-theme-color" size="lg" type="submit">
                    Create AddToQueue Account.
					<ArrowRight class="h-4 w-4" />
                </Button>
            </form>
            <div v-if="Object.keys(errors).length > 0"
                class="mt-6 rounded-2xl border border-red-100 bg-red-50/80 p-4 text-sm text-red-900">
                <p class="font-medium">Validation Errors</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    <li v-for="(message, field) in errors" :key="field">
                        {{ message }}
                    </li>
                </ul>
            </div>

        </CardContent>
    </Card>
</template>
