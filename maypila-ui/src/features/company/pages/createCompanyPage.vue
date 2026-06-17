<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CreateCompanyForm from '../component/CreateCompanyForm.vue';
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
            <CreateCompanyForm />
        </div>
    </section>
</template>
