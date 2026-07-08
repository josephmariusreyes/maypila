<script setup lang="ts">
import { Field as VeeField } from 'vee-validate'
import { computed } from 'vue'

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

const props = defineProps<{
  errors?: Partial<Record<string, string | undefined>>,
  isSubmitting?: boolean,
  onSubmit?: (event?: Event) => void,
  onShowAddQueueUser?: (event?: Event) => void,
  onRemoveQueueUser?: (event?: Event) => void,
}>()

const currentErrors = computed(() => props.errors ?? {})

function handleFormSubmit(event: Event) {
  if (props.onSubmit) {
    props.onSubmit(event)
    return
  }
  event.preventDefault()
}

function handleAddQueueAdmin() {

}

function handleAddQueueEncoder() {

}

</script>

<template>
  <Card class="w-full sm:max-w-md">
    <CardContent class="mt-6">
      <form class="space-y-5" @submit="handleFormSubmit">
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
        <div>
          <div>
            <strong>Queue Admins</strong>
            <span>Add Queue Admin..</span>
          </div>
          ListOfQueueAdminHere
        </div>
        <div>
          <div>
            <strong>Queue Encoder</strong>
            <span @click="">Add Queue Encoder..</span>
          </div>
          ListOfQueueEncoderHere
        </div>
        <Button class="w-full gap-2 main-theme-color" size="lg" type="submit" :disabled="isSubmitting">
          {{ isSubmitting ? 'Creating Queue Session...' : 'Create Queue Session' }}
        </Button>
      </form>
      <div v-if="Object.keys(currentErrors).length > 0"
        class="mt-6 rounded-2xl border border-red-100 bg-red-50/80 p-4 text-sm text-red-900">
        <p class="font-medium">Validation Errors</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
          <li v-for="(message, field) in currentErrors" :key="field">
            {{ message }}
          </li>
        </ul>
      </div>

    </CardContent>
  </Card>
</template>
