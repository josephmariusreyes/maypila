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
  InputGroupText,
  InputGroupTextarea
} from '@/components/ui/input-group'

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

const { handleSubmit, errors } = useForm({
  validationSchema: formSchema,
  initialValues: {
    queueSessionName: '',
    queueDescription: ''
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
        <VeeField v-slot="{ field, errors }" name="queueSessionName">
          <Field :data-invalid="!!errors.length">
            <FieldLabel for="queue-session-name-input">
              Queue Session Name
            </FieldLabel>
            <Input id="queue-session-name-input" v-bind="field" autocomplete="off" :aria-invalid="!!errors.length" />
            <!-- <FieldError v-if="errors.length">
                {{ errors[0] }}
              </FieldError> -->
          </Field>
        </VeeField>

        <VeeField v-slot="{ field, errors }" name="queueDescription">
          <Field :data-invalid="!!errors.length">
            <FieldLabel for="queue-description-textarea">
              Description
            </FieldLabel>
            <InputGroup>
              <InputGroupTextarea id="queue-description-textarea" v-bind="field" :rows="6" class="min-h-24 resize-none"
                :aria-invalid="!!errors.length" />
              <InputGroupAddon align="block-end">
                <InputGroupText class="tabular-nums">
                  {{ field.value?.length || 0 }}/100 characters
                </InputGroupText>
              </InputGroupAddon>
            </InputGroup>
            <!-- <FieldError v-if="errors.length" :errors="errors" /> -->
          </Field>
        </VeeField>

        <Button class="w-full gap-2 main-theme-color" size="lg" type="submit">
          Create Queue Session
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
