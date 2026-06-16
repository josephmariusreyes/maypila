<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod'
import { useForm, Field as VeeField } from 'vee-validate'
import { h } from 'vue'
import { toast } from 'vue-sonner'
import { z } from 'zod'

import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
} from '@/components/ui/card'
import {
  Field,
  FieldLabel,
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupInput,
  InputGroupText,
} from '@/components/ui/input-group'

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

const { handleSubmit, errors } = useForm({
  validationSchema: formSchema,
  initialValues: {
    firstName: '',
    lastName: '',
    phoneNumber: ''
  },
})

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
  <Card class="w-full sm:max-w-md">
    <CardContent class="mt-6">
      <form class="space-y-5" @submit="onSubmit">
        <VeeField v-slot="{ field, errors }" name="firstName">
          <Field :data-invalid="!!errors.length">
            <FieldLabel for="firstname-input">
              Firstname
            </FieldLabel>
            <Input id="firstname-input" v-bind="field" autocomplete="off" :aria-invalid="!!errors.length" />
            <!-- <FieldError v-if="errors.length">
                {{ errors[0] }}
              </FieldError> -->
          </Field>
        </VeeField>

        <VeeField v-slot="{ field, errors }" name="lastName">
          <Field :data-invalid="!!errors.length">
            <FieldLabel for="lastname-input">
              Lastname
            </FieldLabel>
            <Input id="lastname-input" v-bind="field" autocomplete="off" :aria-invalid="!!errors.length" />
            <!-- <FieldError v-if="errors.length">
                {{ errors[0] }}
              </FieldError> -->
          </Field>
        </VeeField>

        <VeeField v-slot="{ field, errors }" name="phoneNumber">
          <Field :data-invalid="!!errors.length">
            <FieldLabel for="phoneNumber-input">
              Cellphone Number
            </FieldLabel>
            <InputGroup>
              <InputGroupAddon>
                <InputGroupText>+63:</InputGroupText>
              </InputGroupAddon>
              <InputGroupInput id="phoneNumber-input" type="text" maxlength="10" v-bind="field" autocomplete="off"
                :aria-invalid="!!errors.length" />
            </InputGroup>
            <!-- <FieldError v-if="errors.length">
                {{ errors[0] }}
              </FieldError> -->
          </Field>
        </VeeField>
        <Button class="w-full gap-2 main-theme-color" size="lg" type="submit">
          Add Customer to Queue
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
