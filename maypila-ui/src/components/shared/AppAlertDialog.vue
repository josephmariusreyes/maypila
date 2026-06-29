<script setup lang="ts">
import { ref } from 'vue'

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog'

type AlertDialogCallback = () => void | Promise<void>

type AlertDialogOptions = {
    title: string
    description: string
    callback: AlertDialogCallback
    cancelText?: string
    continueText?: string
}

const defaultCancelText = 'Cancel'
const defaultContinueText = 'Continue'

const isOpen = ref(false)
const title = ref('')
const description = ref('')
const cancelText = ref(defaultCancelText)
const continueText = ref(defaultContinueText)
const continueCallback = ref<AlertDialogCallback | null>(null)
const isLoading = ref(false);

function showAlertDialog(options: AlertDialogOptions) {
    title.value = options.title
    description.value = options.description
    cancelText.value = options.cancelText ?? defaultCancelText
    continueText.value = options.continueText ?? defaultContinueText
    continueCallback.value = options.callback
    isOpen.value = true
}

async function onContinue() {
    if (isLoading.value) return

    isLoading.value = true

    try {
        await continueCallback.value?.()
    } finally {
        isLoading.value = false;
        continueCallback.value = null;
        isOpen.value = false;
        reset();
    }
}

function onCancel() {
    isOpen.value = false
    reset()
}

function reset() {
    title.value = ''
    description.value = ''
    cancelText.value = defaultCancelText
    continueText.value = defaultContinueText
    continueCallback.value = null
}

defineExpose({
    showAlertDialog,
})
</script>

<template>
    <AlertDialog v-model:open="isOpen">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
                <AlertDialogDescription>
                    {{ description }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="onCancel">{{ cancelText }}</AlertDialogCancel>
                <AlertDialogAction :disabled="isLoading" @click="onContinue">
                    {{ isLoading ? 'Please wait...' : continueText }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
