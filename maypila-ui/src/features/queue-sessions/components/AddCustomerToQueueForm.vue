<script setup lang="ts">
import { Field as VeeField } from 'vee-validate'

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

const props = defineProps<{
  errors: Partial<Record<string, string | undefined>>
  isSubmitting: boolean
  onSubmit: (event?: Event) => void
}>()
</script>

<template>
  <Card class="w-full">
    <CardContent class="mt-6">
      <form class="space-y-5" @submit="props.onSubmit">
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
        <Button class="w-full gap-2 main-theme-color" size="lg" type="submit" :disabled="isSubmitting">
          {{ isSubmitting ? 'Adding Customer...' : 'Add Customer to Queue' }}
        </Button>
      </form>
      <div v-if="Object.keys(props.errors).length > 0"
        class="mt-6 rounded-2xl border border-red-100 bg-red-50/80 p-4 text-sm text-red-900">
        <p class="font-medium">Validation Errors</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
          <li v-for="(message, field) in props.errors" :key="field">
            {{ message }}
          </li>
        </ul>
      </div>

    </CardContent>
  </Card>
</template>
